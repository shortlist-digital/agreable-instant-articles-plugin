<?php

namespace AgreableInstantArticlesPlugin\Controllers;

use TimberPost;

use AgreableInstantArticlesPlugin\Services\Client;
use AgreableInstantArticlesPlugin\Services\ClientProvider;
use AgreableInstantArticlesPlugin\Services\Generator;
use Facebook\InstantArticles\Elements\InstantArticle;
use Facebook\InstantArticles\Transformer\Transformer;

class SaveController {

    function __construct(TimberPost $post) {
        $take_live = empty($post->instant_articles_is_preview) && ($post->post_status === 'publish');

        $instant_article = (new Generator)->create_object($post);
        $client = (new ClientProvider())->get_client_instance();

        try {
            $response = $client->importArticle($instant_article, $take_live);

            if ($id = $response->id) {
                update_field('instant_articles_status_id', $id, $post);
            }
        } catch (Exception $e) {
            echo 'Could not import the article: '.$e->getMessage();
        }
    }

    public function build_article_object($url) {
        try {
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }

        return $html;
    }
}
