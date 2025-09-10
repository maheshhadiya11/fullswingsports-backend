jQuery(document).ready(function($) {
    // Function to refresh cart fragments
    function refresh_cart_fragments() {
        // This uses WooCommerce's built-in AJAX to refresh fragments
        $.ajax({
            type: 'POST',
            url: wc_cart_params.ajax_url,
            data: {
                action: 'woocommerce_get_refreshed_fragments' // Built-in action
            },
            success: function(response) {
                if (response && response.fragments) {
                    // Update the cart fragments in the DOM
                    $.each(response.fragments, function(key, value) {
                        $(key).replaceWith(value);
                    });
                }
            }
        });
    }

    // Refresh cart when an item is added
    $(document).on('change','select.quantity', function() {
	$('button[name="update_cart"]').prop('disabled', false);
	
	// Submit the cart form (standard WooCommerce behavior)
	$('form.woocommerce-cart-form').trigger('submit');


        setTimeout(function() {
            refresh_cart_fragments();
        }, 2000); // Adjust delay if needed
	});

	
    // Refresh cart when an item is removed
    $(document).on('click', '.remove', function(e) {

        // Delay the refresh slightly to ensure the item is removed first
        setTimeout(function() {
            refresh_cart_fragments();
        }, 2000); // Adjust delay if needed
    });

    // Optional: Refresh on page load
   refresh_cart_fragments();
});

//Update Coupon code discount on Cart Page//
$(document).on('click', 'button[name="apply_coupon"], .woocommerce-remove-coupon', function() {
        setTimeout(function() {
           location.reload(); 
        }, 1000); 
	});
