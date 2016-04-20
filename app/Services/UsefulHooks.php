<?php

namespace AgreableUtility;

use TimberPost;

class UsefulHooks {

  function __construct() {
    // Trash
    add_action('wp_trash_post', array($this, 'delete'));
    // Equivalent to a create
    add_action('wp_untrash_post', array($this, 'create'));
    // Create
    add_action('draft_to_publish', array($this, 'create'));
    add_action('pending_to_publish', array($this, 'create'));
    add_action('auto-draft_to_publish', array($this, 'create'));
    // Update
    add_action('publish_to_publish', array($this, 'update'));
    // Equivalent to delete
    add_action('publish_to_draft', array($this, 'delete'));
    add_action('publish_to_pending', array($this, 'delete'));
    add_action('publish_to_private', array($this, 'delete'));
  }

  public function create($post_id) {
    do_action('useful-hook-create', $post_id);
    echo "Create";die;
  }

  public function update($post_id) {
    do_action('useful-hook-update', $post_id);
    echo "Update";die;
  }

  public function delete($post_id) {
    do_action('useful-hook-delete', $post_id);
    echo "Delete";die;
  }

}

new UsefulHooks();
