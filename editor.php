<?php

use AgreableInstantArticlesPlugin\Helper;

add_action( 'add_meta_boxes', function () {

	/**
	 * this adds default boxes to interface
	 */
	add_meta_box( 'sharing_center', 'Sharing Center', function () {
		echo '<div class="sharing_center">';
		echo '<input type=hidden name=sharing_center_editor value=1>';
		$outlets = Helper::getOutlets();
		echo "<div class='sharing_center_box_label'>Synchronize with external outlets.
			<div class='sharing_center_colordot sharing_center_colordot-red'>Sync disabled</div>
			<div class='sharing_center_colordot sharing_center_colordot-yellow'>Awaiting publication</div>
			<div class='sharing_center_colordot sharing_center_colordot-green'>Published</div>
		</div>";
		foreach ( $outlets as $index => $outlet ) {
			echo '<div class="sharing_center_box" data-key="' . $index . '">'
			     . $outlet->generateInterface( get_the_ID() ) .
			     '</div>';
		}
		echo '</div>';
	}, 'post', 'side', 'low' );
	/**
	 * This adds stuff for developers, you need to be super admin to see that.
	 */
	if ( is_super_admin() ) {
		add_meta_box( 'sharing_center_debug', 'Sharing Center (Debug)', function () {

			echo '<div class="sharing_center_debug">';
			$outlets = Helper::getOutlets();
			echo '<div class="sharing_center_debug_box">Debug</div>';

			foreach ( $outlets as $index => $outlet ) {
				echo '<div class="sharing_center_debug_box">';
				echo $outlet->getStats( get_the_ID() );
				echo '</div>';
			}
			echo '</div>';

		}, 'post', 'side', 'low' );
	}
} );

add_action( 'admin_enqueue_scripts', function () {
	wp_enqueue_style( 'admin_css', plugin_dir_url( __DIR__ . '/plugin.php' ) . '/dist/editor.css', false, '1.0.0' );
} );