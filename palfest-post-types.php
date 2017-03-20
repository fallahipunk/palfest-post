<?php 
/*Plugin Name: PalFest Post Types
Description: Custom post types for the PalFest website
Version: 1.0
License: GPLv2
*/

// register custom post type to work with
function palfest_create_palfestivians() {
	// set up labels
	$labels = array(
 		'name' => 'Palfestivians',
    	'singular_name' => 'Profile',
    	'add_new' => 'Add New Profile',
    	'add_new_item' => 'Add New Profile',
    	'edit_item' => 'Edit Profile',
    	'new_item' => 'New Profile',
    	'all_items' => 'All Profiles',
    	'view_item' => 'View Profile',
    	'search_items' => 'Search Profiles',
    	'not_found' =>  'No Profiles Found',
    	'not_found_in_trash' => 'No Profiles found in Trash', 
    	'parent_item_colon' => '',
    	'menu_name' => 'Palfestivians',
    );
    //register post type
	register_post_type( 'profile', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
		'taxonomies' => array( 'post_tag', 'category' ),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'Palfestivians' ),
		)
	);
}

function palfest_create_articles() {
    // set up labels
    $labels = array(
        'name' => 'Articles',
        'singular_name' => 'Article',
        'add_new' => 'Add New Article',
        'add_new_item' => 'Add New Article',
        'edit_item' => 'Edit Article',
        'new_item' => 'New Article',
        'all_items' => 'All Articles',
        'view_item' => 'View Article',
        'search_items' => 'Search Articles',
        'not_found' =>  'No Articles Found',
        'not_found_in_trash' => 'No Articles found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Articles',
    );
    //register post type
    register_post_type( 'article', array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
        'taxonomies' => array( 'post_tag', 'category' ),    
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'rewrite' => array( 'slug' => 'Articles' ),
        )
    );
}

function palfest_create_programme() {
    // set up labels
    $labels = array(
        'name' => 'Programme',
        'singular_name' => 'Day',
        'add_new' => 'Add New Day',
        'add_new_item' => 'Add New Day',
        'edit_item' => 'Edit Day',
        'new_item' => 'New Day',
        'all_items' => 'All Days',
        'view_item' => 'View Day',
        'search_items' => 'Search Programme Days',
        'not_found' =>  'No Programme Days Found',
        'not_found_in_trash' => 'No Programme Days found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Programme',
    );
    //register post type
    register_post_type( 'day', array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
        'taxonomies' => array( 'post_tag', 'category' ),    
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'rewrite' => array( 'slug' => 'Programme' ),
        )
    );
}


add_action( 'init', 'palfest_create_programme' );
add_action( 'init', 'palfest_create_palfestivians' );
add_action( 'init', 'palfest_create_articles' );



?>