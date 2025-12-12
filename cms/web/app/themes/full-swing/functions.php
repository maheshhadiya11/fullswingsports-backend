<?php
require_once('inc/woocommerce.php');

function fullswing_theme_enqueue_styles()
{
  $themeURL = get_template_directory_uri();

  wp_enqueue_style('maincss', $themeURL . '/dist/style.css');
  wp_enqueue_style('neuehaasfont', "https://use.typekit.net/ifs0qcr.css");
  wp_enqueue_script('mainjs', $themeURL . '/dist/main-min.js', array('jquery'), false, true);
}
add_action('wp_enqueue_scripts', 'fullswing_theme_enqueue_styles');

if (function_exists('acf_add_options_page')) {

  acf_add_options_page(array(
    'page_title'    => 'Global Settings',
    'menu_title'    => 'Global Settings',
    'menu_slug'     => 'global-settings',
    'capability'    => 'edit_posts',
    'menu_icon'     => 'dashicons-admin-settings',
    'redirect'      => false,
    'show_in_graphql' => true,
  ));
}

// function fullswing_acf_json_save_point($path)
// {
//   return get_stylesheet_directory() . '/acf-json';
// }
// add_filter('acf/settings/save_json', 'fullswing_acf_json_save_point');

function register_post_athletes_cpt()
{
  $labels = array(
    'name'                  => _x('Athletes', 'Post Type General Name', 'text_domain'),
    'singular_name'         => _x('Athlete', 'Post Type Singular Name', 'text_domain'),
    'menu_name'             => __('Athletes', 'text_domain'),
    'name_admin_bar'        => __('Athlete', 'text_domain'),
    'archives'              => __('Athlete Archives', 'text_domain'),
    'attributes'            => __('Athlete Attributes', 'text_domain'),
    'parent_item_colon'     => __('Parent Athlete:', 'text_domain'),
    'all_items'             => __('All Athletes', 'text_domain'),
    'add_new_item'          => __('Add New Athlete', 'text_domain'),
    'add_new'               => __('Add New', 'text_domain'),
    'new_item'              => __('New Athlete', 'text_domain'),
    'edit_item'             => __('Edit Athlete', 'text_domain'),
    'update_item'           => __('Update Athlete', 'text_domain'),
    'view_item'             => __('View Athlete', 'text_domain'),
    'view_items'            => __('View Athletes', 'text_domain'),
    'search_items'          => __('Search Athlete', 'text_domain'),
    'not_found'             => __('Not found', 'text_domain'),
    'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
    'featured_image'        => __('Athlete Image', 'text_domain'),
    'set_featured_image'    => __('Set person image', 'text_domain'),
    'remove_featured_image' => __('Remove person image', 'text_domain'),
    'use_featured_image'    => __('Use as person image', 'text_domain'),
    'insert_into_item'      => __('Insert into person', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this person', 'text_domain'),
    'items_list'            => __('Athletes list', 'text_domain'),
    'items_list_navigation' => __('Athletes list navigation', 'text_domain'),
    'filter_items_list'     => __('Filter Athletes list', 'text_domain'),
  );

  $args = array(
    'label'                 => __('Athlete', 'text_domain'),
    'description'           => __('Athletes Description', 'text_domain'),
    'labels'                => $labels,
    'supports'              => array('title', 'editor', 'thumbnail', 'revisions', 'custom-fields',),
    'hierarchical'          => false,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 5,
    'menu_icon'             => 'dashicons-groups', // Set the menu icon to dashicons-groups
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'rewrite'     => array('slug' => 'athlete', 'with_front' => false), // my custom slug
    'exclude_from_search'   => false,
    'publicly_queryable'    => true, // Set to false to prevent single post views for this post type
    'capability_type'       => 'page',
    'show_in_graphql'       => true, // Make it available in WPGraphQL
    'graphql_single_name'   => 'Athlete',
    'graphql_plural_name'   => 'Athletes'
  );

  register_post_type('athlete', $args);
}
add_action('init', 'register_post_athletes_cpt', 0);

function register_bundle_group_cpt()
{
  $labels = array(
    'name'                  => _x('Product Bundle Groups', 'Post Type General Name', 'text_domain'),
    'singular_name'         => _x('Product Bundle Group', 'Post Type Singular Name', 'text_domain'),
    'menu_name'             => __('Product Bundle Groups', 'text_domain'),
    'name_admin_bar'        => __('Product Bundle Group', 'text_domain'),
    'archives'              => __('Product Bundle Group Archives', 'text_domain'),
    'attributes'            => __('Product Bundle Group Attributes', 'text_domain'),
    'parent_item_colon'     => __('Parent Product Bundle Group:', 'text_domain'),
    'all_items'             => __('All Product Bundle Groups', 'text_domain'),
    'add_new_item'          => __('Add New Product Bundle Group', 'text_domain'),
    'add_new'               => __('Add New', 'text_domain'),
    'new_item'              => __('New Product Bundle Group', 'text_domain'),
    'edit_item'             => __('Edit Product Bundle Group', 'text_domain'),
    'update_item'           => __('Update Product Bundle Group', 'text_domain'),
    'view_item'             => __('View Product Bundle Group', 'text_domain'),
    'view_items'            => __('View Product Bundle Groups', 'text_domain'),
    'search_items'          => __('Search Product Bundle Group', 'text_domain'),
    'not_found'             => __('Not found', 'text_domain'),
    'not_found_in_trash'    => __('Not found in Trash', 'text_domain'),
    'featured_image'        => __('Product Bundle Group Image', 'text_domain'),
    'set_featured_image'    => __('Set person image', 'text_domain'),
    'remove_featured_image' => __('Remove person image', 'text_domain'),
    'use_featured_image'    => __('Use as person image', 'text_domain'),
    'insert_into_item'      => __('Insert into person', 'text_domain'),
    'uploaded_to_this_item' => __('Uploaded to this person', 'text_domain'),
    'items_list'            => __('Product Bundle Groups list', 'text_domain'),
    'items_list_navigation' => __('Product Bundle Groups list navigation', 'text_domain'),
    'filter_items_list'     => __('Filter Product Bundle Groups list', 'text_domain'),
  );

  $args = array(
    'label'                 => __('Product Bundle Group', 'text_domain'),
    'description'           => __('Product Bundle Groups Description', 'text_domain'),
    'labels'                => $labels,
    'supports'              => array('title', 'slug', 'revisions', 'custom-fields',),
    'hierarchical'          => true,
    'public'                => true,
    'show_ui'               => true,
    'show_in_menu'          => true,
    'menu_position'         => 57,
    'menu_icon'             => 'dashicons-products', // Set the menu icon to dashicons-groups
    'show_in_admin_bar'     => true,
    'show_in_nav_menus'     => true,
    'can_export'            => true,
    'has_archive'           => true,
    'exclude_from_search'   => false,
    'publicly_queryable'    => true, // Set to false to prevent single post views for this post type
    'capability_type'       => 'post',
    'show_in_graphql'       => true, // Make it available in WPGraphQL
    'graphql_single_name'   => 'ProductBundleGroup',
    'graphql_plural_name'   => 'ProductBundleGroups'
  );

  register_post_type('bundle', $args);
}
add_action('init', 'register_bundle_group_cpt', 0);

function add_deploy_menu_item()
{
  add_menu_page(
    'Deploy',
    'Deploy',
    'read',
    'deploy',
    'deploy_callback',
    'dashicons-upload',
    100
  );
}

add_action('admin_menu', 'add_deploy_menu_item');

function wpheadless_preview_link()
{
  $token = rawurlencode("VmFsZW50aW5lIFNjaHJlaWJtYWllcjpiQ3RZIFlOanQgamZrOSBXQkNUIDhXMDIgNW5vNQ==");
  $contentUrl = get_permalink();
  $url = parse_url($contentUrl);
  return "{$url['scheme']}://fullswinggolf.com/api/preview?url={$url['path']}&token={$token}&t";
}
add_filter('preview_page_link', 'wpheadless_preview_link', 5);
add_filter('preview_post_link', 'wpheadless_preview_link', 5);

function deploy_callback()
{
?>
  <div class="wrap">
    <h1>Deployment</h1>
    <p>A deployment usually takes about 3-5 minutes to complete.</p>
    <button data-env="production" class="deploy_button">Deploy Production</button>
    <button data-env="staging" class="deploy_button">Deploy Staging</button>
  </div>

  <script>
    jQuery(document).ready(function($) {
      $('.deploy_button').click(function(btn) {
        var env = $(this).attr('data-env')
        console.log('deploying', env)
        $.post('<?php echo admin_url("admin-ajax.php"); ?>', {
          action: 'handle_deploy',
          env: env,
        }, function(response) {
          alert(env + ' deploy triggered in Amplify!');
        });
      });
    });
  </script>
<?php
}
function handle_deploy()
{
  // Get the URL to make the POST call to

  $current_url = get_site_url(); // Get the current site URL
  $parsed_url = parse_url($current_url); // Parse the URL into an array
  $host = $parsed_url['host']; // Get the hostname from the parsed URL

  // dev hook
  $env = $_POST["env"];
  if (!isset($env)) return;
  switch ($env) {
    case 'staging':
      $url = "https://webhooks.amplify.us-east-1.amazonaws.com/prod/webhooks?id=c9cad6d3-c6c8-4569-8bfe-0e6df9257596&token=ptZUY2ebJ68ZhEr1fXVpj7otqbOMfDVhkw3xZNxo";
      break;
    case 'production':
      $url = "https://webhooks.amplify.us-east-1.amazonaws.com/prod/webhooks?id=049bb276-5d22-4971-90d5-f3491cea8a77&token=aBfstXIy5Ryyn0vkiYCUNqD1Ijjuw71McSzs6ucQ8";
      break;
  }

  // Set up the HTTP request arguments
  $args = array(
    'method' => 'POST',
    'timeout' => 45,
    'redirection' => 5,
    'httpversion' => '1.0',
    'blocking' => true,
    'body' => '',
    'headers' => array(
      'content-type' => 'application/json'
    ),
  );

  // Make the HTTP POST request
  $response = wp_remote_post($url, $args);

  // Handle the response
  if (is_wp_error($response)) {
    $error_message = $response->get_error_message();
    wp_send_json_error($error_message);
  } else {
    $body = wp_remote_retrieve_body($response);
    wp_send_json_success($url);
  }
}

add_action('wp_ajax_handle_deploy', 'handle_deploy');

add_action('graphql_register_types', function () {
  register_graphql_field('MediaItem', 'focalPoint', [
    'type' => 'String',
    'description' => __('The focal point of the image', 'wp-graphql'),
    'resolve' => function ($post) {
      $bg = get_post_meta($post->ID, 'bg_pos_desktop', true);
      return !empty($bg) ? $bg : '50% 50%';
    }
  ]);
});

add_action('woocommerce_load_cart_from_session', function () {
  if (isset($_COOKIE['woo_frontend_session']) && !isset($_GET['session_id'])) {
    global $wpdb;
    // copy the session
    $target_id = $_COOKIE['woo_frontend_session'];
    $source_id = WC()->session->get_customer_id();
    $sql = $wpdb->prepare("SELECT session_value FROM wp_woocommerce_sessions WHERE session_key = %s", $source_id);
    $source_session = $wpdb->get_row($sql)->session_value;
    $sql_update = $wpdb->prepare("UPDATE wp_woocommerce_sessions SET session_value = %s WHERE session_key = %s", [$source_session, $target_id]);
    $wpdb->get_results($sql_update);
    return;
  }
  // Bail if there isn't any data
  if (!isset($_GET['session_id'])) {
    return;
  }

  $session_id = sanitize_text_field($_GET['session_id']);

  try {

    $handler      = new \WC_Session_Handler();
    $session_data = $handler->get_session($session_id);

    // We were passed a session ID, yet no session was found. Let's log this and bail.
    if (empty($session_data)) {
      throw new \Exception('Could not locate WooCommerce session on checkout');
    }

    // Go get the session instance (WC_Session) from the Main WC Class
    $session = WC()->session;

    // Set the session variable
    foreach ($session_data as $key => $value) {
      $session->set($key, unserialize($value));
    }
    setcookie('woo_frontend_session', $session_id, time() + (86400 * 30), "/");
    wp_redirect(remove_query_arg(['session_id'], false));
  } catch (\Exception $exception) {
    ErrorHandling::capture($exception);
  }
});

add_filter('graphql_woocommerce_product_types', function ($product_types) {
  $product_types['bundle'] = 'BundleProduct';

  return $product_types;
});

add_action('graphql_register_types', function () {

  /**
   * Register BundleProduct ObjectType
   */
  register_graphql_object_type(
    'BundleProduct',
    [
      'description' => 'A product bundle object',
      'interfaces'  => ['Node', 'Product'], // Following same pattern that other product types declare
      'fields'      =>
      [
        'bundlePriceMin' => [
          'type'    => 'String',
          'resolve' => function ($source) {
            return $source->get_bundle_price('min');
          }
        ],
        'bundlePriceMax' => [
          'type'    => 'String',
          'resolve' => function ($source) {
            return $source->get_bundle_price('max');
          }
        ],
        'groupMode' => [
          'type'    => 'String',
          'resolve' => function ($source) {
            return $source->get_group_mode();
          }
        ],
        'price' => [
          'type'    => 'String',
          'resolve' => function ($source) {
            return $source->get_price();
          },
        ],
        'salePrice' => [
          'type'    => 'String',
          'resolve' => function ($source) {
            return $source->get_sale_price();
          },
        ],
        'regularPrice' => [
          'type'    => 'String',
          'resolve' => function ($source) {
            return $source->get_regular_price();
          },
        ],
        'bundledItems' => [
          'type'    => 'String',
          'resolve' => function ($source) {
            return 'this is still a work-in-progress';
          },
        ],
      ],
    ]
  );
});

add_filter('woocommerce_get_checkout_url', 'my_change_checkout_url', 30);

function my_change_checkout_url($url)
{
  $url = "/checkout ";
  return $url;
}

// GLOBAL REDIRECT 
$requestUri = $_SERVER['REQUEST_URI'];

// Check if the URI starts with /checkout or /cart but only if env is not development
if (wp_get_environment_type() === 'production' && $_SERVER['REQUEST_METHOD'] === 'GET' && !preg_match('/^\/(checkout|cart|bundles|wp-|wc-|sitemap|graphql|order-received)/', $requestUri) && !str_contains($requestUri, '.xml')) {
  // Redirect to the desired URL
  header('Location: ' . get_home_url() . '/' . $_SERVER['REQUEST_URI']);
  exit;
}

add_filter('rest_url', 'return_site_url');
function return_site_url($url)
{
  $pattern = '/(\S+)(\/wp\/?)$/';
  $siteURL = preg_replace($pattern, '${1}', site_url());
  $url = str_replace(home_url(), $siteURL, $url);

  return $url;
}

add_filter('woocommerce_get_cart_page_permalink', 'get_cart_url');
function get_cart_url()
{
  return '/cart';
  
}

function enqueue_zendesk_script()
{
  wp_enqueue_script('zendesk-js', get_template_directory_uri() . '/assets/js/zendesk.js', array('jquery'), null, true);
}

add_action('wp_enqueue_scripts', 'enqueue_zendesk_script');

function add_gtm_body_script()
{
?>
  <!-- Google Tag Manager (noscript) --> 
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-559NZ5C" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
<?php
}
add_action('wp_body_open', 'add_gtm_body_script');

function add_gtm_head_script()
{
?>
  <!-- Google Tag Manager --> 
  <script>
    (function(w, d, s, l, i) {
      w[l] = w[l] || [];
      w[l].push({
        'gtm.start': new Date().getTime(),
        event: 'gtm.js'
      });
      var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s),
        dl = l != 'dataLayer' ? '&l=' + l : '';
      j.async = true;
      j.src =
        'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
      f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-559NZ5C');
  </script>
  <!-- End Google Tag Manager -->
<?php
}
add_action('wp_head', 'add_gtm_head_script');


add_theme_support('title-tag');


function enqueue_emptycart_script()
{
  wp_enqueue_script('cartcount', get_template_directory_uri() . '/assets/js/cartcount.js', array('jquery'), false, true);
}

add_action('wp_enqueue_scripts', 'enqueue_emptycart_script');

add_filter('woocommerce_cart_item_remove_link', 'modify_cart_remove_url', 10, 2);
 
/*Remove Cart Item Code - 06-03-2025*/
function modify_cart_remove_url($link, $cart_item_key) {
    $remove_url = wc_get_cart_remove_url($cart_item_key);
    $urlreplace = 'https://www.fullswinggolf.com';
 
    $relative_url = str_replace($urlreplace, '', $remove_url);
 
    if (strpos($relative_url, '/cart') !== 0) {
        $relative_url = '/cart' . $relative_url;
    }
 
    $link = preg_replace('/href="([^"]+)"/', 'href="' . esc_url($relative_url) . '"', $link);
 
    return $link;
}

add_action('woocommerce_before_calculate_totals', function ($cart) {
    if (is_admin() && !defined('DOING_AJAX')) return;

    foreach ($cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];
        $product->set_price($product->get_price()); // Force update
    }
});

//Terms and Conditions Code//

add_action('woocommerce_review_order_before_submit', 'add_terms_checkbox', 9);
function add_terms_checkbox() {
    echo '<p class="form-row terms">
        <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
            <input type="checkbox" class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms_custom" id="terms_custom" />
            <span>I agree to the <a href="/e-commerce-terms-and-product-policies/" target="_blank">Terms of Service</a> and LM Terms.</span>
        </label>
    </p>';
}

add_action('woocommerce_checkout_process', 'validate_terms_checkbox');
function validate_terms_checkbox() {
    if (!isset($_POST['terms_custom'])) {
        wc_add_notice(__('Please accept our Terms of Service and LM Terms to proceed.'), 'error');
    }
}

add_action('init', function() {    
  if (strpos($_SERVER['REQUEST_URI'], 'sitemap') !== false) {        
    header('Access-Control-Allow-Origin: https://fullswingsports.com');       
    header('Access-Control-Allow-Methods: GET');       
    header('Access-Control-Allow-Headers: Content-Type');    
  }
});

add_filter('wpseo_stylesheet_url','__return_false');
add_filter('wpseo_stylesheet_url',function() {   return'';});
