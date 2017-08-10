<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\Exceptions\GeneratorException;
use AgreableInstantArticlesPlugin\GeneratorInterface;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\Html;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\Image;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\ListItem;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\Paragraph;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\PullQuote;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\Wrap;
use Croissant\App;
use Croissant\DI\Interfaces\InstantArticlesLogger;

/**
 * Class Generator
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook
 */
class Generator implements GeneratorInterface {

	/**
	 *
	 */
	const ACF_LAYOUT_KEY = 'acf_fc_layout';
	/**
	 * @var int
	 */
	public $post_id;

	/**
	 * @var array|null
	 */
	private $widgetsData = null;

	/**
	 * @var array
	 */
	private $stats = [
		'missing'       => 0,
		'rendered'      => 0,
		'all'           => 0,
		'missing_names' => []
	];

	/**
	 * @var
	 */
	private $widgetsHtmlOutputs;
	/**
	 * @var InstantArticlesLogger
	 */
	private $_logger;

	/**
	 * Generator constructor.
	 *
	 * @param $post_id
	 */
	public function __construct( $post_id ) {

		$this->_logger = App::get( InstantArticlesLogger::class );
		$this->post_id = $post_id;


	}

	/**
	 * @return mixed|void
	 */
	public function getWidgetList() {

		$list = [
			'html'       => Html::class,
			'image'      => Image::class,
			'list-item'  => ListItem::class,
			'paragraph'  => Paragraph::class,
			'pull-quote' => PullQuote::class
		];

		/**
		 * Trigger hooks so we could extend it from plugins
		 */
		return apply_filters( 'instant_articles_widget_list', $list );

	}

	/**
	 *
	 * @return bool
	 */
	public function qualifies() {
		return true;
	}

	/**
	 * @throws GeneratorException
	 * @return array
	 */
	public function getWidgetsHtmlOutputs() {

		/**
		 * Makes sure items are created only once
		 */
		if ( isset( $this->widgetsHtmlOutputs ) ) {
			return $this->widgetsHtmlOutputs;
		}

		$widgetsData = $this->getWidgetsData();
		$widgetList  = $this->getWidgetList();

		$widgetStrings = [];
		foreach ( $widgetsData as $index => $widgetData ) {

			$acf_key = $widgetData[ self::ACF_LAYOUT_KEY ];

			if ( isset( $widgetList[ $acf_key ] ) ) {

				unset( $widgetData[ self::ACF_LAYOUT_KEY ] );
				$widgetClass = $widgetList[ $acf_key ];

				/**
				 * Check if it's widget class like in most of the cases
				 */
				if ( is_string( $widgetClass ) && class_exists( $widgetClass ) ) {
					$widgetStrings[] = new $widgetClass( $widgetData, $this->post_id );
					continue;
				}

				/**
				 * We can also allow normal functions.
				 * Each function need to return string, null or object implementing to string
				 */
				if ( is_callable( $widgetClass ) ) {
					$widgetStrings[] = call_user_func( $widgetClass, $widgetData, $this->post_id );
					continue;
				}

				throw new GeneratorException( 'It seems like ' . var_export( $widgetClass, true ) . ' is not valid widget generator for ' . $acf_key );
			}
			$this->stats['missing_names'][] = $acf_key;
		}

		/**
		 * remove nulls
		 */
		$this->widgetsHtmlOutputs = array_filter( $widgetStrings );

		return $this->widgetsHtmlOutputs;

	}

	/**
	 * @return array
	 */
	public function getStats() {
		$this->stats['missing_names'] = array_unique( $this->stats['missing_names'] );
		$this->stats['all']           = count( $this->getWidgetsData() );
		$this->stats['rendered']      = count( $this->getWidgetsHtmlOutputs() );
		$this->stats['missing']       = $this->stats['all'] - $this->stats['missing'];

		return $this->stats;
	}

	/**
	 * @return Wrap
	 */
	public function render() {

		$widgetsHtml = implode( PHP_EOL, $this->getWidgetsHtmlOutputs() );

		$wrap = new Wrap( [ 'content' => $widgetsHtml ], $this->post_id );

		return $wrap;
	}

	/**
	 * @return array
	 */
	public function getWidgetsData() {
		if ( is_null( $this->widgetsData ) ) {
			$widgets           = get_field( 'widgets', $this->post_id );
			$this->widgetsData = is_null( $widgets ) ? [] : $widgets;
		}

		return $this->widgetsData;
	}


}