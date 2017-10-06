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

add_filter( 'timber/cache/mode', function () {
    return 'none';
} );

if(file_exists(__DIR__ . '/vendor/shortlist-digital/agreable-wp-plugin-framework/bootstrap/autoload.php')){
  require_once __DIR__ . '/vendor/shortlist-digital/agreable-wp-plugin-framework/bootstrap/autoload.php';
} else {
  require_once __DIR__ . '/../../../../vendor/shortlist-digital/agreable-wp-plugin-framework/bootstrap/autoload.php';
}

add_action( 'admin_notices', function() {
    if (
        empty( get_option( 'instant_articles_app_id' ) ) ||
        empty( get_option( 'instant_articles_app_secret' ) ) ||
        empty( get_option( 'instant_articles_app_user_access_token' ) )
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
        <p>[Facebook Instant Articles Plugin] The enviroment variable SEGMENT_WRITE_KEY is not setup correctly. This will affect the Facebook IA analytics. Please contact someone from the development team and ask to fix it.</p>
    </div>
<?php
    }
});
