<?php

/**
 * Woocommerce Endpoints
 *
 * @package       DIGIPWC
 * @author        Digital Present
 * @version       1.0.5
 *
 * @wordpress-plugin
 * Plugin Name:   Woocommerce Endpoints
 * Plugin URI:    https://github.com/hnikoloski/wc-endpoints.git
 * Description:   Because Woocommerce markup sucks here are some endpoints
 * Version:       1.0.5
 * Author:        Digital Present
 * Author URI:    https://digitalpresent.io/
 * Text Domain:   digital-present-woocommerce-endpoints
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;
// get woocommerce path
include_once WP_PLUGIN_DIR . '/woocommerce/woocommerce.php';
include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
// List all products
function dp_get_products()
{
    if (class_exists('WooCommerce')) {
        $products = wc_get_products(array('status' => 'publish', 'limit' => -1));
        $data = [];

        $i = 0;

        foreach ($products as $product) {
            $data[$i]['id'] = $product->get_id();
            $data[$i]['type'] = $product->get_type();
            $data[$i]['name'] = $product->get_name();
            $data[$i]['slug'] = $product->get_slug();
            $data[$i]['permalink'] = $product->get_permalink();
            $data[$i]['sku'] = $product->get_sku();
            $data[$i]['price'] = $product->get_price();
            $data[$i]['regular_price'] = $product->get_regular_price();
            $data[$i]['sale_price'] = $product->get_sale_price();
            $data[$i]['date_created'] = $product->get_date_created();
            $data[$i]['date_modified'] = $product->get_date_modified();
            $data[$i]['date_on_sale_from'] = $product->get_date_on_sale_from();
            $data[$i]['date_on_sale_to'] = $product->get_date_on_sale_to();
            $data[$i]['stock_quantity'] = $product->get_stock_quantity();
            $data[$i]['stock_status'] = $product->get_stock_status();
            $data[$i]['category_id'] = $product->get_category_ids();
            $data[$i]['add_to_cart_link'] = '?add-to-cart=' . $product->get_id();
            $i++;
        }
        return $data;
    } else {
        return 'This plugin requires WooCommerce to be installed and active. Please install and activate WooCommerce.';
    }
}
// Get single product
function dp_get_single_product($prodId)
{
    if (class_exists('WooCommerce')) {

        $data = [];
        $product = wc_get_product($prodId['id']);
        $data['id'] = $product->get_id();
        $data['type'] = $product->get_type();
        $data['name'] = $product->get_name();
        $data['description'] = $product->get_description();
        $data['short_description'] = $product->get_short_description();
        $data['slug'] = $product->get_slug();
        $data['permalink'] = $product->get_permalink();
        $data['sku'] = $product->get_sku();
        $data['price'] = $product->get_price();
        $data['regular_price'] = $product->get_regular_price();
        $data['sale_price'] = $product->get_sale_price();
        $data['date_created'] = $product->get_date_created();
        $data['date_modified'] = $product->get_date_modified();
        $data['date_on_sale_from'] = $product->get_date_on_sale_from();
        $data['date_on_sale_to'] = $product->get_date_on_sale_to();
        $data['stock_quantity'] = $product->get_stock_quantity();
        $data['stock_status'] = $product->get_stock_status();
        $data['category_id'] = $product->get_category_ids();
        $data['add_to_cart_link'] = '?add-to-cart=' . $product->get_id();
        $data['product_img_url'] = wp_get_attachment_url($product->get_image_id());
        $data['product_img_alt'] = get_post_meta($product->get_image_id(), '_wp_attachment_image_alt', true);
        $data['product_gallery_ids'] = $product->get_gallery_image_ids();
        $data['product_gallery_urls'] = [];
        foreach ($data['product_gallery_ids'] as $id) {
            $data['product_gallery_urls'][] = wp_get_attachment_url($id);
        }
        // Get acf repeater field
        $data['extra_info'] = [];
        if (have_rows('extra_info', $prodId['id'])) :
            while (have_rows('extra_info', $prodId['id'])) : the_row();
                $data['extra_info'][] = [
                    'title' => get_sub_field('title', $prodId['id']),
                    'content' => get_sub_field('content', $prodId['id'])
                ];
            endwhile;
        endif;

        return $data;
    } else {
        return 'This plugin requires WooCommerce to be installed and active. Please install and activate WooCommerce.';
    }
}
// List Products in category
function dp_get_products_in_cat($catId)
{
    if (class_exists('WooCommerce')) {
        $products = wc_get_products(array(
            'status' => 'publish',
            'limit' => -1,
            'tax_query'      => array(array(
                'taxonomy'   => 'product_cat',
                'field'      => 'term_id',
                'terms'      => array($catId['id']),
            ))
        ));
        $data = [];

        $i = 0;

        foreach ($products as $product) {
            $data[$i]['id'] = $product->get_id();
            $data[$i]['type'] = $product->get_type();
            $data[$i]['name'] = $product->get_name();
            $data[$i]['slug'] = $product->get_slug();
            $data[$i]['permalink'] = $product->get_permalink();
            $data[$i]['sku'] = $product->get_sku();
            $data[$i]['price'] = $product->get_price();
            $data[$i]['regular_price'] = $product->get_regular_price();
            $data[$i]['sale_price'] = $product->get_sale_price();
            $data[$i]['date_created'] = $product->get_date_created();
            $data[$i]['date_modified'] = $product->get_date_modified();
            $data[$i]['date_on_sale_from'] = $product->get_date_on_sale_from();
            $data[$i]['date_on_sale_to'] = $product->get_date_on_sale_to();
            $data[$i]['stock_quantity'] = $product->get_stock_quantity();
            $data[$i]['stock_status'] = $product->get_stock_status();
            $data[$i]['category_id'] = $product->get_category_ids();
            $data[$i]['add_to_cart_link'] = '?add-to-cart=' . $product->get_id();
            $i++;
        }
        return $data;
    } else {
        return 'This plugin requires WooCommerce to be installed and active. Please install and activate WooCommerce.';
    }
}
// List All Categories
function dp_get_product_categories()
{
    if (class_exists('WooCommerce')) {

        $orderby = 'name';
        $order = 'asc';
        $hide_empty = true;
        $cat_args = array(
            'orderby'    => $orderby,
            'order'      => $order,
            'hide_empty' => $hide_empty,
        );

        $product_categories = get_terms('product_cat', $cat_args);
        $data = [];

        $i = 0;

        foreach ($product_categories as $key => $category) {
            $data[$i]['id'] = $category->term_id;
            $data[$i]['name'] = $category->name;
            $data[$i]['slug'] = $category->slug;
            $data[$i]['permalink'] = get_term_link($category);
            $data[$i]['count'] = $category->count;
            $data[$i]['parent'] = $category->parent;
            $data[$i]['child_cats'] = get_term_children($category->term_id, 'product_cat');


            $i++;
        }
        return $data;
    } else {
        return 'This plugin requires WooCommerce to be installed and active. Please install and activate WooCommerce.';
    }
}
// Get User Info
function dp_get_user_info($userId)
{
    if (class_exists('WooCommerce')) {
        $data = [];

        $customer_orders = get_posts(
            apply_filters(
                'woocommerce_my_account_my_orders_query',
                array(
                    'numberposts' => 99999,
                    'meta_key'    => '_customer_user',
                    'meta_value'  => $userId['id'],
                    'post_type'   => wc_get_order_types('view-orders'),
                    'post_status' => array_keys(wc_get_order_statuses()),
                )
            )
        );

        $data['user_id'] = get_userdata($userId['id'])->id;
        $data['user_nicename'] = get_userdata($userId['id'])->user_nicename;
        $data['display_name'] = get_userdata($userId['id'])->display_name;
        $data['first_name'] = get_userdata($userId['id'])->first_name;
        $data['last_name'] = get_userdata($userId['id'])->last_name;
        $data['user_email'] = get_userdata($userId['id'])->user_email;
        $data['user_phone'] = get_userdata($userId['id'])->billing_phone;
        $data['user_address_1'] = get_userdata($userId['id'])->billing_address_1;
        $data['user_address_2'] = get_userdata($userId['id'])->billing_address_2;
        $data['user_zip'] = get_userdata($userId['id'])->billing_postcode;
        $data['user_city'] = get_userdata($userId['id'])->billing_city;
        $data['user_shipping_address_1'] = get_userdata($userId['id'])->shipping_address_1;
        $data['user_shipping_address_2'] = get_userdata($userId['id'])->shipping_address_2;
        $data['user_shipping_zip'] = get_userdata($userId['id'])->shipping_postcode;
        $data['user_shipping_city'] = get_userdata($userId['id'])->shipping_city;
        $data['user_country'] = WC()->countries->countries[get_userdata($userId['id'])->billing_country];
        $data['nonce'] = wp_create_nonce();
        if ($customer_orders) :
            $data['orders'] = [];
            foreach ($customer_orders as $customer_order) {
                $order = wc_get_order($customer_order);
                // print_r($order);
                $data['orders'][] = [
                    'id' => $order->get_id(),
                    'order_number' => $order->get_order_number(),
                    'order_date' => $order->get_date_created()->date('M d, Y'),
                    'order_status' => wc_get_order_status_name($order->get_status()),
                    'order_total' => $order->get_total(),
                    'order_link' => $order->get_view_order_url(),
                    'payment_method_title' => $order->get_payment_method_title(),
                    'billing' => [
                        'first_name' => $order->get_billing_first_name(),
                        'last_name' => $order->get_billing_last_name(),
                        'address_1' => $order->get_billing_address_1(),
                        'address_2' => $order->get_billing_address_2(),
                        'city' => $order->get_billing_city(),
                        'state' => $order->get_billing_state(),
                        'postcode' => $order->get_billing_postcode(),
                        'country' => WC()->countries->countries[$order->get_billing_country()],
                        'email' => $order->get_billing_email(),
                        'phone' => $order->get_billing_phone(),
                    ],
                    'shipping' => [
                        'first_name' => $order->get_shipping_first_name(),
                        'last_name' => $order->get_shipping_last_name(),
                        'address_1' => $order->get_shipping_address_1(),
                        'address_2' => $order->get_shipping_address_2(),
                        'city' => $order->get_shipping_city(),
                        'state' => $order->get_shipping_state(),
                        'postcode' => $order->get_shipping_postcode(),
                        'country' => $order->get_shipping_country(),
                    ],
                    'items' => [],
                ];
                $items = $order->get_items();
                foreach ($items as $item_id => $item) {
                    $product = $item->get_product();
                    $data['orders'][count($data['orders']) - 1]['items'][] = [
                        'id' => $item_id,
                        'name' => $item->get_name(),
                        'quantity' => $item->get_quantity(),
                        'price' => $item->get_total(),
                        'product_id' => $product->get_id(),
                        'product_link' => get_permalink($product->get_id()),
                        'product_image' => get_the_post_thumbnail_url($product->get_id()),

                    ];
                }
            }
        endif;

        return $data;
    } else {
        return 'This plugin requires WooCommerce to be installed and active. Please install and activate WooCommerce.';
    }
}
// dp_get_cart_items
function dp_get_single_order($request)
{
    if (class_exists('WooCommerce')) {
        // Get an instance of the WC_Order object
        $orderId = intval($request->get_param('order_id'));
        $data = [];
        $order = wc_get_order($orderId);
        if (!empty($order)) {
            $data['order_id'] = $order->get_id();
            $data['order_number'] = $order->get_order_number();
            $data['order_date'] = $order->get_date_created()->date('M d, Y');
            $data['order_status'] = wc_get_order_status_name($order->get_status());
            $data['order_status_nicename'] = preg_replace('/\s+/', '-', strtolower($data['order_status']));
            $data['order_total'] = $order->get_total();
            $data['order_billing_address_1'] = $order->get_billing_address_1();
            $data['order_billing_address_2'] = $order->get_billing_address_2();
            $data['order_link'] = $order->get_view_order_url();
            $data['payment_method_title'] = $order->get_payment_method_title();
            $data['currency'] = $order->get_currency();
            $data['currency_symbol'] = get_woocommerce_currency_symbol($order->get_currency());
            $data['billing'] = [
                'first_name' => $order->get_billing_first_name(),
                'last_name' => $order->get_billing_last_name(),
                'address_1' => $order->get_billing_address_1(),
                'address_2' => $order->get_billing_address_2(),
                'city' => $order->get_billing_city(),
                'state' => $order->get_billing_state(),
                'postcode' => $order->get_billing_postcode(),
                'country' => WC()->countries->countries[$order->get_billing_country()],
                'email' => $order->get_billing_email(),
                'phone' => $order->get_billing_phone(),
            ];
            $items = $order->get_items();
            $data['items'] = [];
            foreach ($items as $item_id => $item) {
                $product = $item->get_product();
                $data['items'][] = [
                    'id' => $item_id,
                    'name' => $item->get_name(),
                    'quantity' => $item->get_quantity(),
                    'price' => $item->get_total(),
                    'product_weight' => $product->get_weight(),
                    'product_id' => $product->get_id(),
                    'product_link' => get_permalink($product->get_id()),
                    'product_image' => get_the_post_thumbnail_url($product->get_id()),
                    'currency' => $order->get_currency(),
                    'currency_symbol' => get_woocommerce_currency_symbol($order->get_currency()),
                ];
            }
        } else {
            $data['error'] = 'Order not found';
        }
        return rest_ensure_response($data);
    } else {
        return 'This plugin requires WooCommerce to be installed and active. Please install and activate WooCommerce.';
    }
}




add_action('rest_api_init', function () {
    register_rest_route('dp-api/v1', 'products', array(
        'methods' => 'GET',
        'callback' => 'dp_get_products'
    ));

    register_rest_route('dp-api/v1', 'categories', array(
        'methods' => 'GET',
        'callback' => 'dp_get_product_categories'
    ));
    register_rest_route('dp-api/v1', 'products/category/(?P<id>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'dp_get_products_in_cat'
    ));
    register_rest_route('dp-api/v1', 'product/(?P<id>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'dp_get_single_product'
    ));
    register_rest_route('dp-api/v1', 'userinfo/(?P<id>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'dp_get_user_info'
    ));
    register_rest_route('dp-api/v1', 'single_order', array(
        'methods' => 'GET',
        'callback' => 'dp_get_single_order',
        'permission_callback' => '__return_true'

    ));
});
