<?php


namespace AgreableInstantArticlesPlugin;


/**
 * Class Outlet
 *
 * @package AgreableInstantArticlesPlugin
 */
abstract class Outlet implements OutletInterface {

	/**
	 * Article is visible to Shortlist viewers
	 */
	const STATUS_LIVE = 'live';
	/**
	 *  Article is pending due to internal or external review in outside app
	 */
	const STATUS_PENDING = 'pending';
	/**
	 *  Article is enabled but it failed to sync
	 */
	const STATUS_FAILED = 'failed';
	/**
	 *  Article is not synchronising
	 */
	const STATUS_DISABLED = 'disabled';
}