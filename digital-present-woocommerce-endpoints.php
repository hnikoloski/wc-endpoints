<?php

/**
 * Woocommerce Endpoints
 *
 * @package       DIGIPWC
 * @author        Digital Present
 * @version       1.0.2
 *
 * @wordpress-plugin
 * Plugin Name:   Woocommerce Endpoints
 * Plugin URI:    https://github.com/hnikoloski/wc-endpoints.git
 * Description:   Because Woocommerce markup sucks here are some endpoints
 * Version:       1.0.2
 * Author:        Digital Present
 * Author URI:    https://digitalpresent.io/
 * Text Domain:   digital-present-woocommerce-endpoints
 * Domain Path:   /languages
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) exit;



// List all products
function dp_get_products()
{
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
}

// Get single product
function dp_get_single_product($prodId)
{


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
}

// List Products in category
function dp_get_products_in_cat($catId)
{
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
}

// List All Categories
function dp_get_product_categories()
{
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
}

// Get User Info
function dp_get_user_info($userId)
{
    $data = [];
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
    return $data;
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
});
