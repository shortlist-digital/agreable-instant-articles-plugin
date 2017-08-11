<?php

use AgreableInstantArticlesPlugin\Helper;

add_action( 'admin_enqueue_scripts', function () {

	$dir = plugin_dir_url( __FILE__ );
	$dir = str_replace( '/app/plugins/vagrant/web/app/dev/', '/app/mu-plugins/', $dir );

	wp_enqueue_script( 'telemetry-plugin-js', $dir . 'dist/main.js', array(), '1.0.0', true );

} );

add_action( 'add_meta_boxes', function () {

	add_meta_box( 'sharing_center', 'Sharing Center', function () {
		echo '<div class="sharing_center">';
		echo '<input type=hidden name=sharing_center_editor value=1>';
		$outlets = Helper::getOutlets();
		echo "<div class='sharing_center_box_label'>Synchronize with <br> following services:</div>";
		foreach ( $outlets as $index => $outlet ) {
			echo '<div class="sharing_center_box" data-key="' . $index . '">'
			     . $outlet->getAdmin()->render() .
			     '</div>';
		}
		echo '</div>';
	}, 'post', 'side', 'low' );
	if ( is_super_admin() ) {
		add_meta_box( 'sharing_center_debug', 'Sharing Center (Debug)', function () {
			echo '<div class="sharing_center_debug">';

			$outlets = Helper::getOutlets();
			echo '<div class="sharing_center_debug_box">Debug</div>';

			foreach ( $outlets as $index => $outlet ) {
				echo '<div class="sharing_center_debug_box">';
				echo $outlet->getAdmin()->printStats();
				echo '</div>';
			}
			echo '</div>';
		}, 'post', 'side', 'low' );
	}
} );

add_action( 'admin_enqueue_scripts', function () {
	wp_enqueue_style( 'admin_css', plugin_dir_url( __DIR__ . '/plugin.php' ) . '/dist/editor.css', false, '1.0.0' );
} );