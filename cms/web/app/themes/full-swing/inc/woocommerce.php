<?php

/* 1. Split product quantities into multiple cart items */

function bbloomer_split_product_individual_cart_items($cart_item_data, $product_id)
{
    $unique_cart_item_key = uniqid();
    $cart_item_data['unique_key'] = $unique_cart_item_key;
    return $cart_item_data;
}

add_filter('woocommerce_add_cart_item_data', 'bbloomer_split_product_individual_cart_items', 10, 2);

/* Disable edit quanity field on the cart page*/
// add_filter('woocommerce_cart_item_quantity', 'wc_cart_item_quantity', 10, 3);
// function wc_cart_item_quantity($product_quantity, $cart_item_key, $cart_item)
// {
//   if (is_cart()) {
//     $product_quantity = sprintf('%2$s <input type="hidden" name="cart[%1$s][qty]" value="%2$s" />', $cart_item_key, $cart_item['quantity']);
//   }
//   return $product_quantity;
// }


/* Split cart items seperately */
add_action('woocommerce_add_to_cart', 'DCS_splitCartItems', 10, 6);
function DCS_splitCartItems($cart_item_key, $product_id, $quantity, $variation_id, $variation, $cart_item_data)
{
    if ($quantity > 1) {
        WC()->cart->set_quantity($cart_item_key, 1);
        for ($i = 1; $i <= $quantity - 1; $i++) {
            $cart_item_data['unique_key'] = md5(microtime() . rand() . "Hi Mom!");
            WC()->cart->add_to_cart($product_id, 1, $variation_id, $variation, $cart_item_data);
        }
    }
}

// add placeholder text to checkout fields
function use_label_as_placeholder($fields)
{
    foreach ($fields as $fieldset_key => &$fieldset) {
        foreach ($fieldset as $field_key => &$field) {
            if (isset($field['label'])) {
                $field['placeholder'] = $field['label'];
            }
        }
    }

    return $fields;
}
add_filter('woocommerce_checkout_fields', 'use_label_as_placeholder');



function custom_configurator()
{
    global $product;




    // Check if we're dealing with a bundle product type
    if (is_a($product, 'WC_Product') && $product->get_type() == 'bundle') {
        $bundled_items = $product->get_bundled_items();


        $bundled_items = array_filter($bundled_items, function ($item) {
            return $item->is_optional() === true || wc_get_product(($item->get_product())->get_id())->get_type() == 'variable';
        });

        $bundled_items = array_values($bundled_items);

        $identifiers = array_map(function ($item) {
            return $item->get_product()->get_name();
        }, $bundled_items);

        $selections = (object) array_merge(...array_map(function ($identifier) {
            return [$identifier => isset($_GET[$identifier]) ? $_GET[$identifier] : ''];
        }, $identifiers));


        $variation_data = [];

        foreach ($bundled_items as $index => $bundled_item) {
            if (wc_get_product($bundled_item->get_product()->get_id())->get_type() == 'variable') {
                $variations = wc_get_product($bundled_item->get_product()->get_id())->get_children();

                foreach ($variations as $variation_id) {
                    $variation_product = wc_get_product($variation_id);
                    $attributes = $variation_product->get_variation_attributes();

                    // Filter out unwanted characters from attributes
                    $variation_data[$variation_id] = [];
                    foreach ($attributes as $key => $attribute) {
                        $variation_data[$variation_id][$key] = str_replace(['"', "'"], '', html_entity_decode($attribute, ENT_QUOTES, 'UTF-8'));
                    }
                }
            }
        }



        $encoded_variation_data = json_encode($variation_data);

        if (!empty($bundled_items)) {
?>
            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.1/dist/cdn.min.js" defer></script>
            <div class="configurator-overlay" x-data="{
                        currentStep: 0, 
                        totalSteps: <?php echo count($bundled_items); ?>,
                        selections: <?php echo str_replace('"', "'", json_encode($selections)); ?>,
                        bundled_items: <?php echo str_replace('"', "'", json_encode($bundled_items)); ?>,
                        variationData: <?php echo str_replace('"', "'", json_encode($variation_data)); ?>,
                        firstRender: true,
                        parseUrlParams: function() {
                            const urlParams = new URLSearchParams(window.location.search);
                            for (let [key, value] of urlParams.entries()) {
                                this.selections[key] = value;
                            }
                        },
                        init: function() {
                            this.parseUrlParams();
                            this.updateURL();
                            const firstProductName = Object.keys(this.selections)[0];
                            if (this.selections[firstProductName] && this.firstRender) {
                                    //this.addSelection(firstProductName, this.selections[firstProductName]);
                            }
                            this.firstRender = false
                            document.body.style.overflow = 'hidden';
                            setTimeout(() => {
                                const firstProductName = Object.keys(this.selections)[0];
                                if (this.selections[firstProductName]) {
                                    this.addSelection(firstProductName, this.selections[firstProductName]);
                                    const isVariableProduct = this.selections[firstProductName] in this.variationData;
                                    if (isVariableProduct) {
                                        this.selectVariation(indexToSelect, this.variationData[this.selections[firstProductName]], firstProductName);
                                    } else{
                                        this.selectChoice(indexToSelect, firstProductName);
                                    }
                                }
                            }, 100)
                        },
                        updateURL: function() {
                            let url = new URL(window.location);
                            Object.keys(this.selections).forEach((key, index) => {
                                let value = this.selections[key];
                                if (value) url.searchParams.set(key, value);
                            });
                            history.pushState({}, '', url);
                        },


                        addSelection: function(productName, selection, isVariableProduct) {
                            let elements = document.querySelectorAll('.item_title');
                    
                        
                            let foundElement = null;
                        
                            // Loop through all elements to find a case-insensitive match.
                            elements.forEach(function(element) {
                                if (element.textContent.trim().toLowerCase().includes(productName.toLowerCase())) {
                                    foundElement = element;
                                }
                            });
                        
                            let detailElement = null;
                            if (foundElement) {
                                let currentElement = foundElement.parentElement;
                            
                                while (currentElement) {
                                    if (currentElement.classList.contains('details')) {
                                        detailElement = currentElement;
                                        break;
                                    }
                                    currentElement = currentElement.parentElement;
                                }
                            }
                        
                        
                            // Update the selections object and URL.
                            this.selections[productName] = selection;
                            this.updateURL();
                        
                            const nextKeys = Object.keys(this.selections).slice(this.currentStep);
                        
                            let stepsToSkip = 0;
                            let foundUnselected = false;
                        
                            // Calculate steps to skip based on whether or not the selection is filled.
                            for (let i = 0; i < nextKeys.length; i++) {
                                if (!foundUnselected && this.selections[nextKeys[i]]) {
                                    stepsToSkip++;
                                } else {
                                    foundUnselected = true;
                                
                                    if (!this.selections[nextKeys[i]]) {
                                        break;
                                    }
                                }
                            }
                        
                        
                            // Update the current step, ensuring we don't skip beyond available steps.
                            this.currentStep += stepsToSkip;
                        
                            // Check if steps were skipped and call the appropriate function for each skipped step
                            for (let i = 1; i <= stepsToSkip; i++) {
                            const indexToSelect = this.currentStep - i;
                                                        
                            const productNameToSelect = Object.keys(this.selections)[indexToSelect];
                                                        
                            const selectedOption = this.selections[productNameToSelect];
                            const isVariableProduct = selectedOption in this.variationData;
                                                        

                                if (isVariableProduct) {
                                    this.selectVariation(indexToSelect, this.variationData[selectedOption], productNameToSelect);
                                } else {
                                    if(selection != 'null') {
                                        this.selectChoice(indexToSelect, productNameToSelect);
                                    }
                                
                            if (this.currentStep >= this.totalSteps) {
                                let addToCartButton = document.querySelector('.bundle_add_to_cart_button');
                                if (addToCartButton) {
                                    setTimeout(() => {
                                        addToCartButton.click();
                                    }, 500);
                                }
                            } 
                                
                                }
                            }
                        },


                        selectChoice: function(index, productName) {
                            let allBundledElements = document.querySelectorAll('.bundled_product');
                            let targetElement = null;
                            allBundledElements.forEach(function(element) {
                                let titleElement = element.querySelector('.item_title');
                                if (titleElement && titleElement.textContent.trim() === productName) {
                                    targetElement = element;
                                }
                            });
                        
                            if (targetElement) {
                                   let checkBox = targetElement.querySelector('input'); 
                                   if (checkBox) {
                                       checkBox.checked = true; 
                                       let event = new Event('change', { 'bubbles': true }); 
                                       checkBox.dispatchEvent(event);
                                   } else {
                                       console.log('No checkbox found in the target element.');
                                   }
                               } else {
                                   console.log('No target element found with index:', index );
                               }
                        },
                        selectVariation: function(index, optionName, productName) {
                                let allBundledElements = document.querySelectorAll('.bundled_product');

                                let targetElement = null;
                                allBundledElements.forEach(function(element) {
                                    let titleElement = element.querySelector('.bundled_product_title_inner');
                                    if (titleElement && titleElement.textContent.trim() === productName) {
                                        targetElement = element;
                                    }
                                });
                            if (targetElement) {
                                let selectElement = targetElement.querySelector('select');
                                
                                if (selectElement) {
                                    let attributeName = selectElement.getAttribute('data-attribute_name');
                                  let matchingOption = Array.from(selectElement.options).find(option => {
                                    let cleanOptionName = optionName[attributeName].replace(/'/g, '');
                                    
                                    let cleanOptionText = option.text.replace(/'/g, '');
                                    let cleanOptionValue = option.value.replace(/'/g, '');
                                    return cleanOptionText === cleanOptionName || cleanOptionValue === cleanOptionName;
                                }); 
                                
                                    if (matchingOption) {
                                        matchingOption.selected = true;
                                        // In case of event listener
                                        let event = new Event('change', { 'bubbles': true }); 
                                        selectElement.dispatchEvent(event);
                                    } else {
                                        console.log('No matching option found for:', optionName);
                                    }
                                } else {
                                    console.log('No select element found within target element.');
                                }
                            } else {
                                console.log('No target element found with index:', index );
                            }
                        }
                    }" x-init="init()">
                <div class="container xl:overflow-visible overflow-auto">

                    <?php foreach ($bundled_items as $index => $bundled_item) : ?>
                        <?php $bundled_product = $bundled_item->get_product(); ?>
                        <?php $current_product = wc_get_product($bundled_product->get_id());
                        ?>
                        <div class="default-grid grid-container" x-show="currentStep === <?php echo $index ?> ">
                            <?php if ($bundled_product) : ?>
                                <h2 class="configurator-headline">
                                    <?php echo $current_product->get_type() == 'variable' ? 'Choose your ' : 'Add a '; ?>
                                    <?php echo esc_html($current_product->get_name()); ?>
                                    <?php echo $current_product->get_type() == 'variable' ? ' :' : '?' ?>

                                </h2>

                                <?php if ($current_product->get_type() == 'variable') : ?>
                                    <?php $variations = $current_product->get_children(); ?>
                                    <div class="hidden xl:block xxl:hidden col-start-1"></div>
                                    <?php foreach ($variations as $variation) : ?>
                                        <?php $variation_product = wc_get_product($variation); ?>
                                        <div class="fifty-fifty-card transition-all duration-300" x-data="{ isExpanded: false }">
                                            <div class="fifty-fifty-image-container">
                                                <?php echo $variation_product->get_image() ?>
                                            </div>

                                            <h3 class="fifty-fifty-headline">
                                                <?php echo esc_html($variation_product->get_name()); ?>
                                            </h3>

                                            <span class="fifty-fifty-copy">
                                                <?php
                                                $current_post = get_post($current_product->get_id());
                                                setup_postdata($current_post);
                                                $content = get_the_content();
                                                echo apply_filters('the_content', $content);
                                                wp_reset_postdata();
                                                ?>
                                            </span>
                                            <div class="additional-details fifty-fifty-copy" :style="{ maxHeight: isExpanded ? '1000px' : '0' }" x-transition:enter="transition-all ease-in-out duration-300" x-transition:leave="transition-all ease-in-out duration-300">
                                                <?php echo get_the_content(); ?>

                                            </div>
                                            <div class="fifty-fifty-button-container">
                                                <button class="select-variant-button" @click="
                                                    selectVariation(<?php echo $index; ?>, <?php echo htmlspecialchars(json_encode($variation_product->get_variation_attributes()), ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars(json_encode($current_product->get_name()), ENT_QUOTES, 'UTF-8'); ?>);
                                                    addSelection(<?php echo htmlspecialchars(json_encode($current_product->get_name()), ENT_QUOTES, 'UTF-8'); ?>, '<?php echo esc_attr($variation); ?>'); 
                                                    ">Select - $<?php echo $variation_product->get_price(); ?>
                                                </button>
                                                <button @click="isExpanded = !isExpanded" class="configurator-secondary-button">Show More
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="full-width-card">
                                        <div class="full-width-image-container">
                                            <?php echo $current_product->get_image() ?>
                                        </div>
                                        <div class="full-width-content">

                                            <?php if ($bundled_item->is_optional()) : ?>
                                                <h4 class="optional-add-on">Optional Add-On</h4>
                                            <?php endif; ?>

                                            <h3 class="full-width-headline">
                                                <?php echo esc_html($current_product->get_name()); ?>
                                            </h3>
                                            <span class="fifty-fifty-copy">
                                                <?php echo $current_product->get_short_description(); ?>
                                            </span>
                                            <div class="fifty-fifty-button-container">
                                                <button class="select-variant-button" @click="
                                            selectChoice(<?php echo $index; ?>, <?php echo htmlspecialchars(json_encode($current_product->get_name()), ENT_QUOTES, 'UTF-8'); ?>);
                                            addSelection(<?php echo htmlspecialchars(json_encode($current_product->get_name())); ?>, '<?php echo esc_attr($current_product->get_id()); ?>');
                                            ">add - $<?php echo $current_product->get_price() ?></button>
                                                <button class="configurator-secondary-button" @click="addSelection(<?php echo htmlspecialchars(json_encode($current_product->get_name())); ?>, 'null')">Continue to Checkout</button>
                                            </div>
                                        </div>
                                        <div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>


                </div>
            </div>
<?php
        } else {
            // No bundled items found
            echo '<div>No bundled products found.</div>';
        }
    } else {
        // Not a bundle product type
        echo '<div>This is not a bundle product.</div>';
    }
}


add_action('woocommerce_after_single_product', 'custom_configurator');

add_action('wp_ajax_add_to_cart_by_sku', 'handle_add_to_cart_by_sku');
add_action('wp_ajax_nopriv_add_to_cart_by_sku', 'handle_add_to_cart_by_sku');

function handle_add_to_cart_by_sku()
{

    $sku = isset($_POST['sku']) ? sanitize_text_field($_POST['sku']) : '';
    if (!empty($sku)) {
        $product_id = wc_get_product_id_by_sku($sku);
        if ($product_id && WC()->cart->add_to_cart($product_id)) {
            wp_send_json_success(['message' => 'Product added to cart']);
        } else {
            wp_send_json_error(['message' => 'Failed to add product to cart']);
        }
    } else {
        wp_send_json_error(['message' => 'No SKU provided']);
    }

    wp_die();
}



function wc_empty_cart_redirect_url()
{
    return '/';
}
add_filter('woocommerce_return_to_shop_redirect', 'wc_empty_cart_redirect_url');


add_filter('gettext', 'change_remove_coupon_text', 20, 3);
function change_remove_coupon_text($translated_text, $text, $domain)
{
    if ('woocommerce' === $domain && '[Remove]' === $text) {
        $translated_text = 'Remove';
    }
    return $translated_text;
}

/* 
 *
 * Display cart items upsells on WooCommerce checkout page
 * https://stackoverflow.com/questions/62891893/how-to-display-cart-items-upsells-on-woocommerce-checkout-page
 */

function show_items_upsells($limit = '-1', $columns = 4, $orderby = 'rand', $order = 'desc')
{
    $cart  = WC()->cart;

    if (WC()->cart->is_empty()) {
        echo 'nothing';
        return;
    }

    $upsell_ids = $cart_item_ids = array();

    // Loop through cart items
    foreach ($cart->get_cart() as $cart_item) {
        // Merge all cart items upsells ids
        $upsell_ids      = array_merge($upsell_ids, $cart_item['data']->get_upsell_ids());
        $cart_item_ids[] = $cart_item['product_id'];
    }

    // Remove cart item ids from upsells
    $upsell_ids = array_diff($upsell_ids, $cart_item_ids);
    $upsell_ids = array_unique($upsell_ids); // Remove duplicated Ids

    // Handle the legacy filter which controlled posts per page etc.
    $args = apply_filters('woocommerce_upsell_display_args', array(
        'posts_per_page' => $limit,
        'orderby'        => $orderby,
        'order'          => $order,
        'columns'        => $columns,
    ));

    wc_set_loop_prop('name', 'up-sells');
    wc_set_loop_prop('columns', apply_filters('woocommerce_upsells_columns', isset($args['columns']) ? $args['columns'] : $columns));

    $orderby = apply_filters('woocommerce_upsells_orderby', isset($args['orderby']) ? $args['orderby'] : $orderby);
    $_order  = apply_filters('woocommerce_upsells_order', isset($args['order']) ? $args['order'] : $order);
    $limit   = apply_filters('woocommerce_upsells_total', isset($args['posts_per_page']) ? $args['posts_per_page'] : $limit);

    // Get visible upsells then sort them at random, then limit result set.
    $upsells = wc_products_array_orderby(array_filter(array_map('wc_get_product', $upsell_ids), 'wc_products_array_filter_visible'), $orderby, $_order);
    $upsells = $limit > 0 ? array_slice($upsells, 0, $limit) : $upsells;

    wc_get_template('single-product/up-sells.php', array(
        'upsells'        => $upsells,

        // Not used now, but used in previous version of up-sells.php.
        'posts_per_page' => $limit,
        'orderby'        => $orderby,
        'columns'        => $columns,
    ));
}
