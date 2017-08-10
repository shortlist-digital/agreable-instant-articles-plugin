<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;

use AgreableInstantArticlesPlugin\Outlet\Facebook\Helpers\PostObject;


/**
 * Class Wrap
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */

/**
 * Class Wrap
 *
 * @package AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms
 */
class Wrap extends AbstractWidget {

	/**
	 * @return array
	 */
	public function getData() {


		$site = new \ArrayObject( [ 'name' => get_bloginfo( 'name' ),'description' => get_bloginfo( 'description' )] );


		$post = new PostObject( $this->post_id );

		/**
		 * @var $categories \WP_Term[]
		 */
		$categories = wp_get_post_terms( $this->post_id, 'category' );
		$cat        = null;
		if ( count( $categories ) > 0 ) {
			$cat       = new \stdClass();
			$cat->name = $categories[0]->name;
			$cat->slug = $categories[0]->slug;
		}

		return array(
			'site'          => $site,
			'post'          => $post,
			'category'      => $cat,
			'content'       => $this->getField( 'content' ),
			'post_date'     => gmdate( 'd M Y', strtotime( $post->post_date ) ),
			'adverts'       => $this->getAdverts(),
			'canonical_url' => get_permalink( $this->post_id ),
		);
	}


	/**
	 * @return \stdClass
	 */
	protected function getAdverts() {


		$head_ad_widget = [
			'acf_fc_layout' => 'advert-slot',
			'position'      => '1A',
			'type'          => 'horizontal'
		];

		$body_ad_widgets = [
			[
				'acf_fc_layout' => 'advert-slot',
				'position'      => '1A',
				'type'          => 'horizontal'
			],
			[
				'acf_fc_layout' => 'advert-slot',
				'position'      => 'mobile',
				'type'          => 'vertical'
			]
		];

		$adverts       = new \stdClass();
		$adverts->head = new AdvertSlot( $head_ad_widget, $this->post_id );
		$adverts->body = [];
		foreach ( $body_ad_widgets as $index => $body_ad_widget ) {
			if ( ( $index + 1 ) === count( $body_ad_widgets ) ) {
				$body_ad_widget['default_ad'] = true;
			}
			$adverts->body[] = new AdvertSlot( $body_ad_widget, $this->post_id );
		}

		return $adverts;
	}


	/**
	 * @return string
	 */
	public function getTemplate() {
		return 'base.twig';
	}

	public function __toString() {

		$template = $this->getTemplate();

		if ( $template === null ) {
			return '';
		}

		return $this->getTwigInstance()->render( $template, $this->getData() );
	}
}