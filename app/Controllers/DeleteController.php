<?php

namespace AgreableInstantArticlesPlugin\Controllers;

use Timberpost;

use AgreableInstantArticlesPlugin\Services\Client;
use AgreableInstantArticlesPlugin\Services\ClientProvider;

class DeleteController
{
    function __construct(Timberpost $post) {
        $this->post = $post;

        $client = (new ClientProvider())->get_client_instance();

        $final_url = get_permalink($post->ID);
        $url = parse_url($final_url);
        $domain = getenv('WEB_BASE_DOMAIN') ?: 'www.shortlist.com';

        if ($url['host'] !== $domain) {
            $final_url = $url['scheme'] . '://' . $domain . $url['path'];
        }

        $client->removeArticle($final_url);
    }
}
