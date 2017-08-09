<?php


namespace AgreableInstantArticlesPlugin\Outlet\Facebook\Transforms;


class Wrap extends AbstractWidget {
	public function getData() {
		$title = get_the_title( $this->post_id );

		if ( strlen( $title ) < 250 ) {
			$title = $post->title;
		} else {
			$title = get_field( 'short_headline', $this->post_id );
		}

		$category       = $post->terms( 'category' );
		$html_as_string = \Timber::compile(
			'./template.twig',
			array(
				'site'               => new TimberSite(),
				'post'               => $post,
				'post_category'      => $post->post_category,
				'post_category_slug' => $category[0]->slug,
				'post_date'          => gmdate( 'd M Y', strtotime( $post->post_date ) ),
				'adverts'            => $this->get_adverts( $post ),
				'canonical_url'      => $post->get_field( 'catfish_importer_url' ),
			)
		);

		return $html_as_string;
	}

	protected function get_adverts( $post ) {
		$widgets_directory = get_stylesheet_directory() . '/views/widgets';
		include_once $widgets_directory . '/advert-slot/generators/instant-articles/generator.php';
		$ad_generator = new \Agreable\Widgets\AdvertSlot\Generators\InstantArticles\Generator();

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
		$adverts->head = $ad_generator->get( $head_ad_widget, $post );
		$adverts->body = [];
		foreach ( $body_ad_widgets as $index => $body_ad_widget ) {
			if ( ( $index + 1 ) === count( $body_ad_widgets ) ) {
				$body_ad_widget['default_ad'] = true;
			}
			$adverts->body[] = $ad_generator->get( $body_ad_widget, $post );
		}

		return $adverts;
	}
}