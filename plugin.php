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
if ( class_exists( '\Croissant\Helper\RequiredEnv' ) && ! \Croissant\Helper\RequiredEnv::variables( [
		'instant_articles_page_token' => 'A user access token for someone with access to the relevant Facebook Page.</br><a href="https://developers.facebook.com/tools/accesstoken" target="_blank"/">Generate one here</a>. (Click "debug", and extend the token)',
		'instant_articles_app_id'     => 'The Facebook App ID for your Instant Articles',
		'instant_articles_app_secret' => 'The Facebook App secret for your Instant Articles',
		'instant_articles_page_id'    => 'The Facebook Page ID to post to Instant Articles',
	] ) ) {
	return;
}

include __DIR__ . '/register.php';
include __DIR__ . '/ajax.php';
include __DIR__ . '/editor.php';
include __DIR__ . '/hooks.php';

