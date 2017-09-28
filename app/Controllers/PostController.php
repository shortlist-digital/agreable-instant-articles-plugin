<?php
namespace AgreableInstantArticlesPlugin\Controllers;

use AgreableInstantArticlesPlugin\Services\Generator;

class PostController {
    /**
     * Show the article.
     */
    public function view($category_slug, $post_slug) {
        $post = new \TimberPost($post_slug);

        if ( ! $post ) {
            throw new \Exception('Post not found');
        }

        echo (new Generator)->create_object($post);
    }
}
