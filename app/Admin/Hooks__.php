<?php

namespace AgreableInstantArticlesPlugin\Admin;

use AgreableInstantArticlesPlugin\Controllers\SaveController;
use AgreableInstantArticlesPlugin\Controllers\DeleteController;

class Hooks {

	private $save_controller;
	private $delete_controller;

	public function __construct( SaveController $save_controller, DeleteController $delete_controller ) {
		$this->save_controller = $save_controller;
		$this->delete_controller = $delete_controller;
	}

	public function register_hooks() {
		add_action( 'save_post',	 [ $this, 'create_or_update' ], 13, 1);
		add_action( 'wp_trash_post', [ $this, 'custom_delete' ], 13, 1);
	}

	public function create_or_update($post_id) {
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}

		$post = get_post( $post_id );
		if ($post->post_type !== 'post') {
			return;
		}

		if ( (bool) get_post_meta( $post_id, 'article_should_publish_to_instant_articles', true ) === false ) {
			$this->delete_controller->delete( $post );
			return;
		}

		$this->save_controller->save( $post );
	}
}
