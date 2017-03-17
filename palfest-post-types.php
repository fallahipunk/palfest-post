<?php 
/*Plugin Name: Create Product Post Type
Description: This plugin registers the 'product' post type.
Version: 1.0
License: GPLv2
*/

// register custom post type to work with
function wpmudev_create_post_type() {
	// set up labels
	$labels = array(
 		'name' => 'Products',
    	'singular_name' => 'Product',
    	'add_new' => 'Add New Product',
    	'add_new_item' => 'Add New Product',
    	'edit_item' => 'Edit Product',
    	'new_item' => 'New Product',
    	'all_items' => 'All Products',
    	'view_item' => 'View Product',
    	'search_items' => 'Search Products',
    	'not_found' =>  'No Products Found',
    	'not_found_in_trash' => 'No Products found in Trash', 
    	'parent_item_colon' => '',
    	'menu_name' => 'Products',
    );
    //register post type
	register_post_type( 'product', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
		'taxonomies' => array( 'post_tag', 'category' ),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'products' ),
		)
	);
}
add_action( 'init', 'wpmudev_create_post_type' );
?>