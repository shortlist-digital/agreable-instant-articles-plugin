<?php

namespace AgreableInstantArticlesPlugin\Generators;

class SuperHero extends TwigRenderer implements GeneratorInterface {

    public function get( $post ) {
        $title = strlen( $post->post_title ) < 250 ? $post->post_title : $post->short_headline;

        $url = get_permalink( $post->ID );
        $parsed_url = parse_url( $url );

		$category = $this->get_category( $post_id );
        $domain = getenv('FACEBOOK_IA_DOMAIN');

        if ( $parsed_url['host'] !== $domain ) {
            $url = $parsed_url['scheme'] . '://' . $domain . $parsed_url['path'];
        }

		$share_image = get_field( 'share_image', $post->ID );
		if ( $share_image === false ) {
			$share_image = get_field( 'hero_images', $post->ID )[0];
		}

        return $this->renderer->render(
            'super-hero.twig',
            [
                'site' => new \TimberSite(),
                'post' => $post,
				'post_title' => $title,
				'short_headline' => get_post_meta( $post_id, 'short_headline', true ),
				'sell' => get_post_meta( $post_id, 'sell', true ),
				'share_image' => $share_image['url'],
				'landscape_image' => $share_image['sizes']['landscape'],
                'post_category' => get_term( wp_get_post_categories( $post->ID )[0] )->name,
                'post_category_slug' => $category->slug,
				'author' => get_user_by( 'id', $post->post_author )->data->display_name,
                'post_date' => gmdate('d M Y', strtotime($post->post_date)),
                'segment_write_key' => getenv( 'SEGMENT_WRITE_KEY' ),
                'canonical_url' => $url,
                'adverts' => $this->get_adverts( $post_id )
            ]
        );
    }

    private function get_adverts( $post_id ) {
        $web_base_url = getenv('WEB_BASE_URL');

        $category = $this->get_category( $post_id );
        $zone = get_home_url();
        if ( $category instanceof \WP_Term ) {
            $zone = $category->slug;
        }

        $path = str_replace( $web_base_url, '', get_permalink( $post_id ) );

        return [
            [
                'web_base_url' => $web_base_url,
                'zone'         => $zone,
                'path'         => $path
            ]
        ];
    }

	private function get_category( $post_id ) {
        return get_term( wp_get_post_categories( $post_id )[0] );
	}
}
