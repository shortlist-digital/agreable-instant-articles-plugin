<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook;


use AgreableInstantArticlesPlugin\Exceptions\GeneratorException;
use AgreableInstantArticlesPlugin\GeneratorInterface;
use AgreableInstantArticlesPlugin\Helper;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\Html;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\Image;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\ListItem;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\Paragraph;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\PullQuote;
use AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms\Wrap;
use Croissant\App;
use Croissant\DI\Interfaces\InstantArticlesLogger;
use Croissant\DI\Interfaces\Paths;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Transformer\Transformer;


/**
 *
 */

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
	 * @var
	 */
	private static $logFile;

	/**
	 * @var
	 */
	private $transformer;

	/**
	 * Generator constructor.
	 *
	 * @param $post_id
	 */
	public function __construct( $post_id ) {

		$this->_logger = App::get( InstantArticlesLogger::class );
		$this->post_id = $post_id;


	}

	public function getHtml() {
		$widgetsHtml = implode( PHP_EOL, $this->getWidgetsHtmlOutputs() );

		return new Wrap( [ 'content' => $widgetsHtml ], $this->post_id );
	}

	/**
	 * @return InstantArticle
	 */
	public function get() {

		$html = $this->getHtml();

		return $this->parse( (string) $html );
	}

	/**
	 * @return string
	 */
	public function render() {
		return $this->get()->render( '', true );
	}

	/**
	 * @return array
	 */
	private function getWidgetList() {

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
	 * @throws GeneratorException
	 * @return array
	 */
	private function getWidgetsHtmlOutputs() {

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
			//$widgetStrings[] = '<!--MISSING WIDGET ' . $acf_key . '--->';

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
	public function getStats( $uKey ) {
		$this->get();
		$this->stats['missing_names'] = array_unique( $this->stats['missing_names'] );
		$this->stats['all']           = count( $this->getWidgetsData() );
		$this->stats['rendered']      = count( $this->getWidgetsHtmlOutputs() );
		$this->stats['missing']       = $this->stats['all'] - $this->stats['missing'];
		$this->stats['warnings']      = array_map( function ( $i ) {
			return get_class( $i );
		}, $this->getWarnings() );
		$this->stats['generator']     = '<a target="_blank" href="' . implode( '/', [
				Helper::reverseLinkReplacement( get_permalink() ),
				'sharing_center',
				$uKey,
				'generate'
			] ) . '">template</a>';


		return $this->stats;
	}

	public function getWarnings() {
		return $this->getTransformer()->getWarnings();
	}

	/**
	 * @param $html
	 *
	 * @return InstantArticle
	 */
	private function parse( $html ) {

		libxml_use_internal_errors( true );
		$document = new \DOMDocument();
		$document->loadHTML( $html );
		libxml_use_internal_errors( false );

		$this->silenceLogger();

		$instant_article = $this->getTransformer()->transform( InstantArticle::create(), $document );

		return $instant_article;
	}

	/**
	 * @return Transformer
	 */
	public function getTransformer() {
		if ( ! $this->transformer ) {
			$this->transformer = new Transformer();
			$this->transformer->loadRules( file_get_contents( __DIR__ . '/simple-rules.json' ) );
		}

		return $this->transformer;
	}

	/**
	 *
	 */
	public function silenceLogger() {
		/**
		 * @var $logger \Logger
		 */
		$file = $this->getLogFile();
		file_put_contents( $file, '' );
		\Logger::configure( array(
			'rootLogger' => array(
				'level'     => 'ALL',
				'appenders' => array( 'default' ),
			),
			'appenders'  => array(
				'default' => array(
					'class'  => 'LoggerAppenderFile',
					'layout' => array(
						'class' => 'LoggerLayoutSimple'
					),
					'params' => array(
						'file'   => $file,
						'append' => true
					)
				)
			)
		) );
		$logger = \Logger::getLogger( 'facebook-instantarticles-transformer' );
		$logger->removeAllAppenders();
	}

	/**
	 * @return string
	 */
	public function getLoggerOutput() {
		return trim( file_get_contents( $this->getLogFile() ) );

	}

	/**
	 * @return string
	 */
	public function getLogFile() {
		if ( ! self::$logFile ) {
			self::$logFile = App::get( Paths::class )->getLogsPath() . 'fb_generator.log';
		}

		return self::$logFile;
	}

	/**
	 * @return array
	 */
	private function getWidgetsData() {
		if ( is_null( $this->widgetsData ) ) {
			$widgets           = get_field( 'widgets', $this->post_id );
			$this->widgetsData = is_null( $widgets ) ? [] : $widgets;
		}

		return $this->widgetsData;
	}


}