<?php

/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if (!defined('ABSPATH')) {
	exit;
}

if ($upsells) : ?>
	<hr class="separator" />

	<section class="up-sells upsells products">
		<?php
		$heading = apply_filters('woocommerce_product_upsells_products_heading', __('Complete your bundle', 'woocommerce'));

		if ($heading) :
		?>
			<h5 class="cart-title"><?php echo esc_html($heading); ?></h5>
		<?php endif; ?>

		<?php woocommerce_product_loop_start(); ?>

		<?php foreach ($upsells as $upsell) : ?>
			<?php
			$_product = wc_get_product($upsell);
			$product_id = $upsell->get_id();

			$product_name = $_product->get_name();
			$addToCartButton = '<a href="' . esc_url($_product->add_to_cart_url()) . '" class="button add_to_cart_button ajax_add_to_cart" data-product_id="' . esc_attr($product_id) . '" data-product_sku="' . esc_attr($_product->get_sku()) . '" aria-label="' . esc_attr($_product->add_to_cart_description()) . '" rel="nofollow">' . esc_html__('Add to cart', 'woocommerce') . '<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="bag-shopping">
				<path id="Icon"
					d="M6.49984 7.83333V4.5C6.49984 3.39543 7.39527 2.5 8.49984 2.5C9.60441 2.5 10.4998 3.39543 10.4998 4.5V7.81151M7.43317 14.5H9.5665C11.06 14.5 11.8067 14.5 12.3771 14.2093C12.8789 13.9537 13.2869 13.5457 13.5425 13.044C13.8332 12.4735 13.8332 11.7268 13.8332 10.2333V8.63333C13.8332 7.8866 13.8332 7.51323 13.6878 7.22801C13.56 6.97713 13.356 6.77316 13.1052 6.64532C12.8199 6.5 12.4466 6.5 11.6998 6.5H5.29984C4.5531 6.5 4.17973 6.5 3.89452 6.64532C3.64363 6.77316 3.43966 6.97713 3.31183 7.22801C3.1665 7.51323 3.1665 7.8866 3.1665 8.63333V10.2333C3.1665 11.7268 3.1665 12.4735 3.45715 13.044C3.71282 13.5457 4.12076 13.9537 4.62253 14.2093C5.19296 14.5 5.9397 14.5 7.43317 14.5Z"
					stroke="currentColor" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
			</g></svg></a>';
			?>

			<?php
			if ($_product && $_product->exists()) :
				$product_permalink = get_permalink($product_id);
			?>
				<tr class="table-head-mobile">
					<th><?php esc_html_e('Product', 'woocommerce'); ?></th>
				</tr>
				<tr class="table-head">
					<th class="product-thumbnail"><span class="screen-reader-text"><?php esc_html_e('Thumbnail image', 'woocommerce'); ?></span></th>
					<th class="product-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
					<th class="product-quantity"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
					<th class="product-subtotal"><?php esc_html_e('Price', 'woocommerce'); ?></th>
				</tr>
				<tr class="woocommerce-cart-form__cart-item">
					<td class="product-thumbnail">
						<?php
						$thumbnail = apply_filters('medium', $_product->get_image());

						// Wrapping the thumbnail in a div
						echo '<span class="thumbnail-wrapper">' . $thumbnail . '</span>'; // PHPCS: XSS ok.
						?>
					</td>


					<td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
						<?php
						if (!$product_permalink) {
							echo wp_kses_post($product_name . '&nbsp;');
						} else {
							/**
							 * This filter is documented above.
							 *
							 * @since 2.1.0
							 */
							echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<h5>%s</h5>', $_product->get_name())));
						}

						echo '<div class="short-description">' . $_product->get_short_description() . '</div>';
						?>
					</td>

					<td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
						<?php
						if ($_product->is_sold_individually()) {
							$min_quantity = 1;
							$max_quantity = 1;
						} else {
							$min_quantity = 0;
							$max_quantity = $_product->get_max_purchase_quantity();

							if (!$max_quantity || $max_quantity < 0) {
								$max_quantity = 99;
							}
						}

						$product_quantity = woocommerce_quantity_input(
							array(
								'input_name'   => "quantity",
								'input_value'  => 1,
								'max_value'    => $max_quantity,
								'min_value'    => $min_quantity,
								'product_name' => $product_name,
							),
							$_product,
							false
						);
						?>

						<div class="select-wrapper">
							<select class="quantity upsell" data-product_id="<?php echo esc_attr($product_id); ?>" data-product_sku="<?php echo esc_attr($_product->get_sku()); ?>" aria-label="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
								<?php
								for ($i = $min_quantity; $i <= $max_quantity; $i++) {
									$selected = 1 === $i;
									printf('<option value="%s" %s>%s</option>', $i, selected($selected, true, false), $i);
								}
								?>
							</select>
							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
								<g clip-path="url(#clip0_5062_9126)">
									<path d="M5.47707 6.46753L8.82305 9.80622L12.169 6.46753L13.1969 7.49538L8.82305 11.8692L4.44922 7.49538L5.47707 6.46753Z" fill="#121212" />
								</g>
								<defs>
									<clipPath id="clip0_5062_9126">
										<rect width="17.4953" height="17.4953" fill="white" transform="translate(0.0751953 0.205566)" />
									</clipPath>
								</defs>
							</svg>
						</div>
					</td>

					<td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
						<?php
						echo $_product->get_price_html();

						echo $addToCartButton;
						?>
					</td>
				</tr>
				<tr class="mobile-add-to-cart">
					<td>
						<?php echo $addToCartButton; ?>
					</td>
				</tr>

		<?php
			endif;
		endforeach;
		?>

		<?php woocommerce_product_loop_end(); ?>

	</section>

<?php
endif;

wp_reset_postdata();
