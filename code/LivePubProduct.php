<?php
/**
 * Extensions to Product class to help with static caching via livepub
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 06.04.2014
 * @package shop_livepub
 */
class LivePubProduct extends DataExtension
{
	/**
	 * Livepub compatible: 'in-cart' or 'not-in-cart' based on session cart
	 * TODO: this won't cover the case where a variation of this product is in the cart.
	 * @return string
	 */
	public function CartStateClass() {
		return LivePubHelper::eval_php('
			return (!empty($_SESSION["Cart"])
				&& !empty($_SESSION["Cart"]["Items"])
				&& !empty($_SESSION["Cart"]["Items"][' . $this->owner->ID . ']))
			? "product-in-cart"
			: "product-not-in-cart";
		');
	}
}