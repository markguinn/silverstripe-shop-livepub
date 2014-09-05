<?php
/**
 * Extensions to keep a copy of the order in the session
 * so that a sidecart can still be displayed when using
 * static caching.
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 05.28.2014
 * @package shop_livepub
 */
class LivePubOrder extends DataExtension
{
	/**
	 * @param $item
	 * @param $buyable
	 * @param $quantity
	 * @param $filter
	 */
	public function afterAdd($item, $buyable, $quantity, $filter) {
		$this->updateSessionCart($item, $buyable, $quantity);
	}

	public function afterRemove($item, $buyable, $quantity, $filter) {
		$this->updateSessionCart($item, $buyable, $quantity);
	}

	public function afterSetQuantity($item, $buyable, $quantity, $filter) {
		$this->updateSessionCart($item, $buyable, $quantity);
	}

	public function onAfterWrite() {
		$this->rebuildSessionCart();
	}

	public function onPlaceOrder() {
		if (session_id()) {
			unset($_SESSION['Cart']);
			Session::clear('Cart');
		}
	}

	/**
	 * If this order is still a cart, we save a copy of the items and
	 * the subtotal in the session for the quick cart dropdown to be
	 * usable even on static cached pages.
	 *
	 * @param OrderItem $item
	 * @param Buyable   $buyable
	 * @param int       $quantity
	 */
	protected function updateSessionCart($item, $buyable, $quantity) {
		if (!session_id() || !$buyable) return;
		$cart = !empty($_SESSION['Cart']) ? $_SESSION['Cart'] : array('Items' => array(), 'SubTotal' => 0.0);

		if ($quantity > 0) {
			if (!isset($cart['Items'][$buyable->ID])) {
				$prod = $item->Product();
				$img = $prod ? $prod->Image() : null;
				$img = $img ? $img->getThumbnail() : null;
				// TODO: the key here should probably include the classname (or cover the diff bt Products and Variations)
				$cart['Items'][$buyable->ID] = array(
					'ThumbURL'  => $img ? $img->RelativeLink() : '',
					'Link'      => $prod ? $prod->RelativeLink() : '',
					'Title'     => $item->TableTitle(),
					'SubTitle'  => $item->hasMethod('SubTitle') ? $item->SubTitle() : '',
					'UnitPrice' => $item->obj('UnitPrice')->Nice(),
					'Quantity'  => $quantity,
					'RemoveLink'=> $item->removeallLink(),
				);
			} else {
				// update the quantity if it's already present
				$cart['Items'][$buyable->ID]['Quantity'] = $quantity;
			}
		} else {
			// remove the item if quantity is 0
			unset($cart['Items'][$buyable->ID]);
		}

		// recalculate the subtotal
		$cart['SubTotal'] = $this->owner->obj('SubTotal')->Nice();

		// and the total number of items
		$cart['TotalItems'] = 0;
		foreach ($cart['Items'] as $item) $cart['TotalItems'] += $item['Quantity'];

		$_SESSION['Cart'] = $cart;
	}


	/**
	 * If this order is still a cart, we save a copy of the items and
	 * the subtotal in the session for the quick cart dropdown to be
	 * usable even on static cached pages.
	 */
	public function rebuildSessionCart() {
		if (!session_id()) return; // disable for CLI
		unset($_SESSION['Cart']);
		if ($items = $this->owner->Items()) {
			foreach($items as $item){
				$this->updateSessionCart($item, $item->Buyable(), $item->Quantity);
			}
		}
	}

}
