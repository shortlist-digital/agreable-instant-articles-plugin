<?php
namespace AgreableInstantArticlesPlugin\Controllers;

use Herbert\Framework\Models\Post;
use \AgreableInstantArticlesPlugin\Services\Generator;
use \TimberPost;
use \Exception;
use \stdClass;

class PostController {
  /**
   * Show the article.
   */
  public function view($category_slug, $post_slug) {

    $post = $this->get_postby_category_slug_post_slug($category_slug, $post_slug);

    $post = new TimberPost($post);

    if (!$post) {
      throw new Exception('Post not found');
    }

    $object = Generator::create_object($post);
    header('Content-Type: application/json');
    echo json_encode($object);
  }


  protected function get_postby_category_slug_post_slug($category_slug, $post_slug) {
    $args = array(
      'name' => $post_slug,
      'posts_per_page' => 1,
      'category_name' => $category_slug,
      'post_type' => 'post',
      'post_status' => 'publish'
    );
    $posts_array = get_posts($args);

    if (count($posts_array) > 0) {
      return new TimberPost($posts_array[0]);
    }
  }
}
