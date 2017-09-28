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

if(file_exists(__DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php')){
  require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';
} else {
  require_once __DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php';
}
