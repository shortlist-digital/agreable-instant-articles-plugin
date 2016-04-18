<?php namespace AgreableInstantArticlesPlugin\Controllers;

use TimberPost;

class Save {
  function __construct(TimberPost $post) {
    $this->post = $post;
    print_r($this->post);die;
  }
}
