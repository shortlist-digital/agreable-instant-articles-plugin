<?php

namespace AgreableInstantArticlesPlugin\Generators;

class TelemetryAcquisition implements GeneratorInterface
{
	public function get( $widget ) {

		$site = \getenv('FACEBOOK_IA_DOMAIN');
		$url = \getenv('WEB_BASE_URL');

		return "<p>Competitions & promotions are only available on <a href=\"$url\">$site</a></p>";
	}
}
