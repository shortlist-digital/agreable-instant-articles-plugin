<?php

namespace AgreableInstantArticlesPlugin\Services;

class Generator
{
    public function create_object( $post ) {
        $content_components = array_merge(
            $this->get_header_components($post),
            $this->get_content_components($post),
            $this->get_footer_components($post)
        );

        return implode( '', $content_components );
    }

    private function get_header_components( $post ) {
        $components = [];

        $headerGenerator = GeneratorFactory::create( 'super-hero' );
        $components[] = $headerGenerator->get($post);

        if ($post->standfirst !== "") {
            $standFirstGenerator = GeneratorFactory::create( 'standfirst' );
            $components[] = $standFirstGenerator->get($post);
        }

        return $components;
    }

    private function get_content_components( $post ) {
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

    private function get_footer_components( $post ) {
        $components = [];

        $generator = GeneratorFactory::create( 'footer' );
        $components[] = $generator->get( $post );

        return $components;
    }
}
