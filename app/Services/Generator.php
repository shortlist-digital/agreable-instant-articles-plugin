<?php

namespace AgreableInstantArticlesPlugin\Services;

use Herbert\Framework\Models\Post;
use \TimberPost;
use \Exception;
use \stdClass;

class Generator
{
    public static function create_object( $post ) {
        $content_components = array_merge(
            self::get_header_components($post),
            self::get_content_components($post),
            self::get_footer_components($post)
        );

        return implode( '', $content_components );
    }

    protected static function get_header_components( TimberPost $post ) {
        $components = [];

        $generator = GeneratorFactory::create( 'super-hero' );
        $components[] = $generator->get($post);

        return $components;
    }

    protected static function get_content_components( $post ) {
        $components = [];
        $theme_base_directory = get_stylesheet_directory();
        $widgets_directory = $theme_base_directory . '/views/widgets';

        foreach ( $post->get_field('widgets') as $widget ) {
            $widget_name = $widget['acf_fc_layout'];

            $generator = GeneratorFactory::create( $widget_name );
            $widget_components = $generator->get($widget, $post);

            if ( ! is_array( $widget_components ) ) {
                $widget_components = [ $widget_components ];
            }

            foreach( $widget_components as $widget_component ) {
                $components[] = $widget_component;
            }
        }

        return $components;
    }

    protected static function get_footer_components( TimberPost $post ) {
        $components = [];

        $generator = GeneratorFactory::create( 'footer' );
        $components[] = $generator->get( $post );

        return $components;
    }
}
