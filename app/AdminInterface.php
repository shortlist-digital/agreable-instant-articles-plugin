<?php


namespace AgreableInstantArticlesPlugin;


interface AdminInterface {
	public function __construct($post_id);

	public function renderInterface();
}