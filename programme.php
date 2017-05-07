<?php
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
        'supports' => array( 'title', 'editor','page-attributes','thumbnail'),  
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'rewrite' => array( 'slug' => 'Programme' ),
        )
    );
}


?>