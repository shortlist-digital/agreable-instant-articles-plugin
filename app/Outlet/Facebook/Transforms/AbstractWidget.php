<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


/**
 * Class AbstractWidget
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */

use Croissant\Helper\ArrayHelper;

/**
 * Class AbstractWidget
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class AbstractWidget {
	/**
	 * @var array
	 */
	protected $data = [];
	/**
	 * @var int
	 */
	protected $post_id;
	/**
	 * @var \Twig_Environment
	 */
	private static $twig;

	/**
	 * AbstractWidget constructor.
	 *
	 * @param array $data
	 * @param $post_id
	 */
	public function __construct( $data = [], $post_id ) {
		$this->setData( $data );
		$this->post_id;

	}

	/**
	 * Prepares data for templates
	 *
	 * @return array|null
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @param $path
	 * @param null $default
	 *
	 * @return mixed|null
	 */
	public function getField( $path, $default = null ) {
		return ArrayHelper::getValueByPath( $this->data, $path, $default );

	}

	/**
	 * @param array $data
	 *
	 * @return static
	 */
	public function setData( $data ) {
		$this->data = $data;

		return $this;
	}

	/**
	 * @param $name
	 *
	 * @return string
	 */
	public static function camel2dashed( $name ) {
		return strtolower( preg_replace( '/([a-zA-Z])(?=[A-Z])/', '$1-', $name ) );
	}

	/**
	 * If null returned template will not be rendered
	 *
	 * @return string
	 */
	public function getTemplate() {

		$classSegments = explode( '\\', static::class );
		$name          = array_pop( $classSegments );

		return 'widgets/' . self::camel2dashed( $name ) . '.twig';

	}

	/**
	 * @return \Twig_Environment
	 */
	public function getTwigInstance() {

		if ( isset( self::$twig ) ) {
			return self::$twig;
		}

		$loader     = new \Twig_Loader_Filesystem( dirname( __DIR__ ) . '/views' );
		self::$twig = new \Twig_Environment( $loader, array(
			'cache'      => false,
			'debug'      => true,
			'autoescape' => false
		) );

		return self::$twig;
	}

	/**
	 * That's where the magic happens
	 *
	 * @return string
	 */
	public function __toString() {

		$template = $this->getTemplate();
		if ( $template === null ) {
			return '';
		}

		try {
			return $this->getTwigInstance()->render( $template, $this->getData() );
		} catch ( \Exception $e ) {
			return 'Error while processing' . $this->getTemplate() . ': ' . $e->getMessage();
		}
	}

}