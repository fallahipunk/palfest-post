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

/* Meta box setup function. */
function smashing_post_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'smashing_add_post_meta_boxes' );

  /* Save post meta on the 'save_post' hook. */
add_action( 'save_post', 'smashing_save_post_class_meta', 10, 2 );

}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function smashing_add_post_meta_boxes() {

  add_meta_box(
    'smashing-post-class',      // Unique ID
    esc_html__( 'Post Class', 'example' ),    // Title
    'smashing_post_class_meta_box',   // Callback function
    'post',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
}

/* Display the post meta box. */
function smashing_post_class_meta_box( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'smashing_post_class_nonce' ); ?>

  <p>
    <label for="smashing-post-class"><?php _e( "Add a custom CSS class, which will be applied to WordPress' post class.", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="smashing-post-class" id="smashing-post-class" value="<?php echo esc_attr( get_post_meta( $post->ID, 'smashing_post_class', true ) ); ?>" size="30" />
  </p>
<?php }

/* Save the meta box's post metadata. */
function smashing_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['smashing_post_class_nonce'] ) || !wp_verify_nonce( $_POST['smashing_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['smashing-post-class'] ) ? sanitize_html_class( $_POST['smashing-post-class'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'smashing_post_class';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}

/* Filter the post class hook with our custom post class function. */
add_filter( 'post_class', 'smashing_post_class' );

function smashing_post_class( $classes ) {

  /* Get the current post ID. */
  $post_id = get_the_ID();

  /* If we have a post ID, proceed. */
  if ( !empty( $post_id ) ) {

    /* Get the custom post class. */
    $post_class = get_post_meta( $post_id, 'smashing_post_class', true );

    /* If a post class was input, sanitize it and add it to the post class array. */
    if ( !empty( $post_class ) )
      $classes[] = sanitize_html_class( $post_class );
  }

  return $classes;
}



add_action( 'init', 'palfest_create_programme' );
add_action( 'init', 'palfest_create_palfestivians' );
add_action( 'init', 'palfest_create_articles' );

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'smashing_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'smashing_post_meta_boxes_setup' );


?>