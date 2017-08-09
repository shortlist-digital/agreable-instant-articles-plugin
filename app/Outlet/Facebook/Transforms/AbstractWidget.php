<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


/**
 * Class AbstractWidget
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class AbstractWidget {
	/**
	 * @var array
	 */
	private $data = [];
	/**
	 * @var int
	 */
	private $post_id;
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
	 * @return array
	 */
	public function getData() {
		return $this->data;
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
	 * @return string
	 */
	public function getTemplate() {

		$classSegments = explode( '\\', static::class );
		$name          = array_pop( $classSegments );

		return self::camel2dashed( $name );

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
			'cache' => false,
		) );

		return self::$twig;
	}

	/**
	 * That's where the magic happens
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getTwigInstance()->render( $this->getTemplate(), $this->getData() );
	}

}