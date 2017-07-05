<?php

namespace AgreableInstantArticlesPlugin\Services;

use TimberPost;

class Generator {
	public static function create_object( $post ) {
		$content_components = [];
		$content_components = array_merge( $content_components, self::get_header_components( $post ) );
		$content_components = array_merge( $content_components, self::get_content_components( $post ) );
		$content_components = array_merge( $content_components, self::get_footer_components( $post ) );
		foreach ( $content_components as $content_component ) {
			echo $content_component;
		}
	}

	protected static function get_header_components( TimberPost $post ) {
		$components           = [];
		$theme_base_directory = get_stylesheet_directory();
		$header_directory     = $theme_base_directory . '/views/partials';
		$header_type          = 'super-hero';
		$component_type       = 'Partials';
		$generator_class      = $header_directory . '/' . $header_type . '/generators/instant-articles/generator.php';
		if ( file_exists( $generator_class ) ) {
			include_once $generator_class;
			$class_name   = self::get_class_name( $header_type, $component_type );
			$generator    = new $class_name();
			$components[] = $generator->get( $post );
		}

		return $components;
	}

	protected static function get_content_components( TimberPost $post ) {
		$components = [];

		// // Iterate through the widget folders, detect if there are Instant Articles generators

		$theme_base_directory = get_stylesheet_directory();
		$widgets_directory    = $theme_base_directory . '/views/widgets';


		foreach ( $post->get_field( 'widgets' ) as $widget ) {
			$widget_name     = $widget['acf_fc_layout'];
			$component_type  = 'Widgets';
			$generator_class = $widgets_directory . '/' . $widget_name . '/generators/instant-articles/generator.php';

			// Check if widget is Instant Articles compatible
			if ( file_exists( $generator_class ) ) {
				include_once $generator_class;
				$class_name = self::get_class_name( $widget_name, $component_type );

				$generator         = new $class_name();
				$widget_components = $generator->get( $widget, $post );
				if ( ! is_array( $widget_components ) ) {
					$widget_components = [ $widget_components ];
				}
				foreach ( $widget_components as $widget_component ) {
					$components[] = $widget_component;
				}
			} // Else skip widget
		}

		return $components;
	}

	protected static function get_footer_components( TimberPost $post ) {
		$components           = [];
		$theme_base_directory = get_stylesheet_directory();
		$generator_class      = $theme_base_directory . '/views/partials/footer/generators/instant-articles/generator.php';
		if ( file_exists( $generator_class ) ) {
			include_once $generator_class;
			$class_name   = self::get_class_name( 'footer', 'Partials' );
			$generator    = new $class_name();
			$components[] = $generator->get( $post );
		}

		return $components;
	}

	protected static function get_class_name( $widget_name, $component_type ) {
		$widget_class_name = '';
		foreach ( explode( '-', $widget_name ) as $widget_name_fragment ) {
			$widget_class_name .= ucfirst( $widget_name_fragment );
		}

		return 'Agreable\\' . $component_type . '\\' . $widget_class_name . '\Generators\InstantArticles\Generator';
	}
}
