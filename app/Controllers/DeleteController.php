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
        $domain = getenv('FACEBOOK_IA_DOMAIN');

        if ($url['host'] !== $domain) {
            $final_url = $url['scheme'] . '://' . $domain . $url['path'];
        }

        $client->removeArticle($final_url);
    }
}
