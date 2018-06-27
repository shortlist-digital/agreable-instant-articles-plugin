<?php

$container = new Pimple\Container();

$container['facebook_ia_domain'] = function($c) {
	return getenv( 'FACEBOOK_IA_DOMAIN' );
};

$container['generator'] = function($c) {
	return new AgreableInstantArticlesPlugin\Services\Generator();
};

$container['client_provider'] = function($c) {
	return new AgreableInstantArticlesPlugin\Services\ClientProvider();
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
