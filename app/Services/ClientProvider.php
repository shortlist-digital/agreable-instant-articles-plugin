<?php

namespace AgreableInstantArticlesPlugin\Services;

class ClientProvider
{
	private $client;

    public function get_client_instance() {
		if ( $this->client !== null ) {
			return $client;
		}

        $this->client = Client::create(
            get_option('instant_articles_app_id'),
            get_option('instant_articles_app_secret'),
            get_option('instant_articles_app_user_access_token'),
            get_option('instant_articles_page_id'),
            getenv('WP_ENV') !== "production" //dev mode
        );

		return $this->client;
    }
}

