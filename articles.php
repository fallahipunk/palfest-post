<?php
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
?>