<?php

namespace AgreableInstantArticlesPlugin\Generators;

use Timber;
use TimberLoader;
use TimberSite;

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

        if ( $parsed_url['host'] !== 'www.shortlist.com' ) {
            $url = $parsed_url['scheme'] . '://www.shortlist.com' . $parsed_url['path'];
        }

        $category = $post->terms( 'category' );

        return Timber::compile(
            __DIR__ . '/views/super-hero.twig',
            [
                'site' => new TimberSite(),
                'post' => $post,
                'post_category' => $post->post_category,
                'post_category_slug' => $category[0]->slug,
                'post_date' => gmdate('d M Y', strtotime($post->post_date)),
                'SEGMENT_WRITE_KEY' => getenv( 'SEGMENT_WRITE_KEY' ),
                'canonical_url' => $url
            ],
            false,
            TimberLoader::CACHE_NONE
        );
    }
}
