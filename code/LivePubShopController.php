<?php
/**
 * Provides some livepub compatible hooks
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 05.28.2014
 * @package shop_livepub
 */
class LivePubShopController extends Extension
{
	/**
	 * Global setup
	 */
	public function onBeforeInit() {
		Requirements::css('shop_livepub/css/shoplivepub.css');
		LivePubHelper::add_template_path('shop_livepub/templates/php');

		if (!empty($_REQUEST['flushsessioncart']) || !empty($_REQUEST['flush'])) {
			$cart = ShoppingCart::curr();
			if ($cart) $cart->rebuildSessionCart();
		}

		if (!empty($_REQUEST['debugsessioncart'])) {
			Debug::dump(Session::get('Cart'));
		}
	}


	/**
	 * @return string
	 */
	public function LoggedInClass() {
		return LivePubHelper::eval_php('return !empty($_SESSION["LoggedInMember"]) ? "logged-in" : "";');
	}
}