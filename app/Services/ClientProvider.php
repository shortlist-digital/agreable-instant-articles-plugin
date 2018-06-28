<?php

namespace AgreableInstantArticlesPlugin\Services;

class ClientProvider
{
	private $client;
	private $env_params;

	public function __construct( array $env_params ) {
		$this->env_params = $env_params;
	}

    public function get_client_instance() {
		if ( $this->client !== null ) {
			return $client;
		}

        $this->client = Client::create(
			$this->env_params['app_id'],
			$this->env_params['app_secret'],
			$this->env_params['access_token'],
			$this->env_params['page_id'],
			$this->env_params['dev_mode']
        );

		return $this->client;
    }
}

