<div class="sidecart">
	<h3><?= _t("HEADLINE","My Cart") ?></h3>
	<?php if (!empty($_SESSION['Cart'])): ?>
		<p class="itemcount">There <?= count($_SESSION['Cart']['Items']) == 1 ? 'is' : 'are' ?> <a href="/cart"><?= count($_SESSION['Cart']['Items']) ?> item<<?= count($_SESSION['Cart']['Items']) == 1 ? '' : 's' ?></a> in your cart.</p>
		<div class="checkout"><a href="/checkout">Checkout</a></div>
		<?php foreach ($_SESSION['Cart']['Items'] as $item): ?>
			<div class="item">
				<?php if ($item['ThumbURL']): ?>
					<div class="image">
						<a href="<?= $item['Link'] ?>"><img src="<?= $item['ThumbURL'] ?>" alt="<?= htmlentities($item['Title']) ?>"/></a>
					</div>
				<?php endif; ?>
				<p class="title">
					<a href="<?= $item['Link'] ?>"><?= htmlentities($item['Title']) ?></a>
				</p>
				<p class="quantityprice">
					<span class="quantity"><?= $item['Quantity'] ?></span>
					<span class="times">x</span>
					<span class="unitprice"><?= $item['UnitPrice'] ?></span>
				</p>
				<?php if (!empty($item['SubTitle'])): ?><p class="subtitle"><?= $item['SubTitle'] ?></p><?php endif; ?>
			</div>
		<?php endforeach; ?>
	<?php else: ?>
		<p class="noItems"><?= _t("NOITEMS","There are no items in your cart") ?>.</p>
	<?php endif; ?>
</div>