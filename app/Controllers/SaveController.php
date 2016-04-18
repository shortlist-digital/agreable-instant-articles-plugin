<?php namespace AgreableInstantArticlesPlugin\Controllers;

use TimberPost;

class SaveController {
  function __construct(TimberPost $post) {
    $this->post = $post;
    print_r($this->post);die;
  }
}
