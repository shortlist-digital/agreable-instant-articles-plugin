<?php

namespace AgreableInstantArticlesPlugin\Controllers;

use AgreableInstantArticlesPlugin\Services\Generator;
use Exception;
use Herbert\Framework\Models\Post;
use TimberPost;

class PostController {
	/**
	 * Show the article.
	 */
	public function view( $category_slug, $post_slug ) {

		$post = $this->get_postby_category_slug_post_slug( $category_slug, $post_slug );

		// Commenting this out as it seems to break the HTML loading
		// $post = new TimberPost($post);

		if ( ! $post ) {
			throw new Exception( 'Post not found' );
		}

		$object = Generator::create_object( $post );
		echo $object;
	}


	protected function get_postby_category_slug_post_slug( $category_slug, $post_slug ) {
		$args        = array(
			'name'           => $post_slug,
			'posts_per_page' => 1,
			'category_name'  => $category_slug,
			'post_type'      => 'post',
			'post_status'    => 'publish'
		);
		$posts_array = get_posts( $args );

		if ( count( $posts_array ) > 0 ) {
			return new TimberPost( $posts_array[0] );
		}
	}
}
