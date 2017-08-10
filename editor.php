<?php
add_action( 'admin_enqueue_scripts', function () {

	$dir = plugin_dir_url( __FILE__ );
	$dir = str_replace( '/app/plugins/vagrant/web/app/dev/', '/app/mu-plugins/', $dir );

	wp_enqueue_script( 'telemetry-plugin-js', $dir . 'dist/main.js', array(), '1.0.0', true );

} );