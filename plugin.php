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

if(file_exists(__DIR__ . '/vendor/autoload.php')){
  require_once __DIR__ . '/vendor/autoload.php';
} else {
  require_once __DIR__ . '/../../../../vendor/autoload.php';
}

if(file_exists(__DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php')){
  require_once __DIR__ . '/vendor/getherbert/framework/bootstrap/autoload.php';
} else {
  require_once __DIR__ . '/../../../../vendor/getherbert/framework/bootstrap/autoload.php';
}

if (!getenv('FB_INSTANT_ARTICLES_DEVELOPMENT_MODE')) {
  \Jigsaw::show_notice("<b>NOTICE</b>: FB_INSTANT_ARTICLES_DEVELOPMENT_MODE missing from .env", 'error');
}
