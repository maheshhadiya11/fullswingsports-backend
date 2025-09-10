<?php

/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.9.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>
<div class="default-grid">
	<div class="col-span-full xl:col-span-10 xl:col-start-2">
		<div>
			<h1 class="title"><?php esc_html_e('Your Cart', 'woocommerce'); ?></h1>
			<form class="woocommerce-cart-form" action="/cart" method="post">
				<?php do_action('woocommerce_before_cart_table'); ?>

				<hr class="separator after-title" />

				<table class="shop_table cart woocommerce-cart-form__contents" cellspacing="0">
					<tbody>
						<?php do_action('woocommerce_before_cart_contents'); ?>

						<?php
						foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
							$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
							$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
							/**
							 * Filter the product name.
							 *
							 * @since 2.1.0
							 * @param string $product_name Name of the product in the cart.
							 * @param array $cart_item The product in the cart.
							 * @param string $cart_item_key Key for the product in the cart.
							 */
							$product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
							$removeButton = '
					<div class="product-remove">' .
								apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 13 13" fill="none">
							<path d="M3.29883 3.66333L9.1306 9.4951M9.1306 3.66333L3.29883 9.4951" stroke="#121212" stroke-width="1.45794" stroke-linecap="round" stroke-linejoin="round"/>
						</svg></a>',
										esc_url(wc_get_cart_remove_url($cart_item_key)),
										/* translators: %s is the product name */
										esc_attr(sprintf(__('Remove %s from cart', 'woocommerce'), wp_strip_all_tags($product_name))),
										esc_attr($product_id),
										esc_attr($_product->get_sku())
									),
									$cart_item_key
								) .
								'</div>';

							if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
								$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
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
								<tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
									<td class="product-thumbnail">
										<?php
										$thumbnail = apply_filters('medium', $_product->get_image(), $cart_item, $cart_item_key);

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
											echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<h5>%s</h5>', $_product->get_name()), $cart_item, $cart_item_key));
										}

										do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

										echo '<div class="short-description">' . $_product->get_short_description() . '</div>';
										echo $removeButton;

										// Meta data.
										echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

										// Backorder notification.
										if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
											echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
										}
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
												'input_name'   => "cart[{$cart_item_key}][qty]",
												'input_value'  => $cart_item['quantity'],
												'max_value'    => $max_quantity,
												'min_value'    => $min_quantity,
												'product_name' => $product_name,
											),
											$_product,
											false
										);
										?>

										<div class="select-wrapper">
											<select class="quantity" name="cart[<?php echo esc_attr($cart_item_key); ?>][qty]" data-quantity="<?php echo esc_attr($cart_item['quantity']); ?>" data-product_id="<?php echo esc_attr($product_id); ?>" data-product_sku="<?php echo esc_attr($_product->get_sku()); ?>" aria-label="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
												<?php
												for ($i = $min_quantity; $i <= $max_quantity; $i++) {
													$selected = $cart_item['quantity'] === $i;
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
											<div class="data">
												<?php
												echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
												?>
											</div>
										</div>
									</td>

									<td class="product-subtotal" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
										<?php
										echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.

										echo $removeButton;
										?>
									</td>
								</tr>
						<?php
							}
						}

						do_action('woocommerce_cart_contents');
						?>
						<tr>
							<td colspan="6" class="upsells">
								<?php show_items_upsells(3, 1); ?>
							</td>
						</tr>

						<tr>
							<td colspan="6" class="actions">
								<?php if (wc_coupons_enabled()) { ?>
									<hr class="separator" />
									<div class="coupon">
										<label for="coupon_code"><?php esc_html_e('Have a Coupon?', 'woocommerce'); ?></label> <input placeholder="Enter Coupon" type="text" name="coupon_code" class="input-text" id="coupon_code" value="" /> <button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="apply_coupon" value="<?php esc_attr_e('Apply Coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply Coupon', 'woocommerce'); ?></button>
										<?php do_action('woocommerce_cart_coupon'); ?>
									</div>
								<?php } ?>

								<button type="submit" class="button<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>" name="update_cart" value="<?php esc_attr_e('Update Cart', 'woocommerce'); ?>"><?php esc_html_e('Update Cart', 'woocommerce'); ?></button>

								<?php do_action('woocommerce_cart_actions'); ?>

								<?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
							</td>
						</tr>

						<?php do_action('woocommerce_after_cart_contents'); ?>
					</tbody>
				</table>
				<?php do_action('woocommerce_after_cart_table'); ?>
			</form>

			<?php do_action('woocommerce_before_cart_collaterals'); ?>

			<div class="cart-collaterals">
				<?php
				/**
				 * Cart collaterals hook.
				 *
				 * @hooked woocommerce_cross_sell_display
				 * @hooked woocommerce_cart_totals - 10
				 */
				do_action('woocommerce_cart_collaterals');
				?>
			</div>
		</div>
	</div>
</div>

<?php do_action('woocommerce_after_cart'); ?>
