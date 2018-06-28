<?php

$container = new Pimple\Container();

$container['facebook_ia_domain'] = function($c) {
	return getenv( 'FACEBOOK_IA_DOMAIN' );
};

$container['instant_articles_app_id'] = function($c) {
	return getenv( 'INSTANT_ARTICLES_APP_ID' );
};

$container['instant_articles_app_secret'] = function($c) {
	return getenv( 'INSTANT_ARTICLES_APP_SECRET' );
};

$container['instant_articles_app_user_access_token'] = function($c) {
	return getenv( 'INSTANT_ARTICLES_APP_USER_ACCESS_TOKEN' );
};

$container['instant_articles_page_id'] = function($c) {
	return getenv( 'INSTANT_ARTICLES_PAGE_ID' );
};

$container['development_mode'] = function($c) {
	return getenv('WP_ENV') !== 'production';
};

$container['generator'] = function($c) {
	return new AgreableInstantArticlesPlugin\Services\Generator();
};

$container['client_provider'] = function($c) {
	return new AgreableInstantArticlesPlugin\Services\ClientProvider([
		'app_id'       => $c['instant_articles_app_id'],
		'app_secret'   => $c['instant_articles_app_secret'],
		'access_token' => $c['instant_articles_app_user_access_token'],
		'page_id'      => $c['instant_articles_page_id'],
		'dev_mode'     => $c['development_mode']
	]);
};

$container['save_controller'] = function($c) {
	return new AgreableInstantArticlesPlugin\Controllers\SaveController($c['generator'], $c['client_provider']);
};

$container['delete_controller'] = function($c) {
	return new AgreableInstantArticlesPlugin\Controllers\DeleteController($c['client_provider'], $c['facebook_ia_domain']);
};

$container['hooks'] = function($c) {
	return new AgreableInstantArticlesPlugin\Admin\Hooks($c['save_controller'], $c['delete_controller']);
};

$container['custom_fields'] = function($c) {
	return new AgreableInstantArticlesPlugin\CustomFields();
};

return $container;
