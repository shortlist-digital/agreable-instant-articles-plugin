<?php

namespace AgreableInstantArticlesPlugin\Generators;

class SuperHero implements GeneratorInterface
{
    public function get( $post ) {
        if ( strlen( $post->post_title ) < 250 ) {
            $title = $post->post_title;
        } else {
            $title = $post->short_headline;
        }

        $url = get_permalink( $post->id );
        $parsed_url = parse_url( $url );
        $domain = getenv('WEB_BASE_DOMAIN') ?: 'www.shortlist.com';

        if ( $parsed_url['host'] !== $domain ) {
            $url = $parsed_url['scheme'] . '://' . $domain . $parsed_url['path'];
        }

        $category = $post->terms( 'category' );

        return \Timber::compile(
            __DIR__ . '/views/super-hero.twig',
            [
                'site' => new \TimberSite(),
                'post' => $post,
                'post_category' => $post->post_category,
                'post_category_slug' => $category[0]->slug,
                'post_date' => gmdate('d M Y', strtotime($post->post_date)),
                'segment_write_key' => getenv( 'SEGMENT_WRITE_KEY' ),
                'canonical_url' => $url,
                'adverts' => $this->get_adverts( $post )
            ],
            false,
            \TimberLoader::CACHE_NONE
        );
    }

    private function get_adverts( $post ) {
        $web_base_url = getenv('WEB_BASE_URL');

        $category = get_the_category($post->ID);
        $zone = get_home_url();

        if ( isset( $category[0] ) && $category[0] instanceof \WP_Term ) {
            $zone = $category[0]->slug;
        }

        $path = str_replace( $web_base_url, '', get_permalink( $post->ID ) );

        return [
            [
                'web_base_url' => $web_base_url,
                'zone'         => $zone,
                'path'         => $path
            ]
        ];
    }
}
