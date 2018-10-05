<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Agreable Instant Articles Plugin
 * Description:       A WordPress plugin to generate Instant Articles Format content.
 * Version:           1.0.0
 * Author:            Shortlist Media
 * Author URI:        http://shortlistmedia.co.uk/
 * License:           MIT
 */

if( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

add_action( 'plugins_loaded', function() {
	$container = require __DIR__ . '/container.php';

	$container['custom_fields']->register_fields();
	$container['hooks']->register_hooks();
} );


add_action( 'admin_notices', function() {
    if (
        empty( getenv( 'INSTANT_ARTICLES_APP_ID' ) ) ||
        empty( getenv( 'INSTANT_ARTICLES_APP_SECRET' ) ) ||
        empty( getenv( 'INSTANT_ARTICLES_APP_USER_ACCESS_TOKEN' ) )
    ) {
?>
    <div class="notice notice-error">
        <p>[Facebook Instant Articles Plugin] Please complete the configuration otherwise you will not be able to save any post. <a href="http://shortlist.dev/wp/wp-admin/admin.php?page=instant-articles-index">You can complete the configuration by clicking here</a> or clicking in the "Instant Articles" menu option.</p>
    </div>
<?php
    }

    if ( empty( getenv( 'SEGMENT_WRITE_KEY' ) ) ) {
?>
    <div class="notice notice-error">
        <p>[Facebook Instant Articles Plugin] The enviroment variable SEGMENT_WRITE_KEY is not setup correctly. This will affect the Facebook IA analytics. Please contact someone from the development team.</p>
    </div>
<?php
    }

	if ( empty( getenv('FACEBOOK_IA_DOMAIN') ) ) {
?>
    <div class="notice notice-error">
        <p>[Facebook Instant Articles Plugin] The enviroment variable FACEBOOK_IA_DOMAIN is not setup correctly. This will affect the Facebook IA plugin. Please contact someone from the development team.</p>
    </div>
<?php
	}
});
