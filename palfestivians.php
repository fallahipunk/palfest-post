<?php
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
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'taxonomies' => array('category' ),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'Palfestivians' ),
		)
	);
}

/* Meta box setup function. */
function palfestivian_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'palfestivian_add_post_meta_boxes' );

  /* Save post meta on the 'save_post' hook. */
add_action( 'save_post', 'palfestivian_save_featured_meta', 10, 2 );
add_action( 'save_post', 'palfestivian_save_last_name_meta', 10, 2 );

}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function palfestivian_add_post_meta_boxes() {

    add_meta_box(
    'palfestivian-last-name',      // Unique ID
    esc_html__( 'Last Name', 'example' ),    // Title
    'palfestivian_last_name_meta_box',   // Callback function
    'profile',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );

  add_meta_box(
    'palfestivian-featured',      // Unique ID
    esc_html__( 'Featured Content', 'example' ),    // Title
    'palfestivian_featured_meta_box',   // Callback function
    'profile',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );

}

function palfestivian_last_name_meta_box( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'palfestivian_last_name_nonce' ); ?>

  <p>
    <label for="palfestivian-last-name"><?php _e( "Last Name (for sorting purposes)", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="palfestivian-last-name" id="palfestivian-last-name" value="<?php echo esc_attr( get_post_meta( $post->ID, 'palfestivian_last_name', true ) ); ?>" size="30" />
  </p>
<?php }

function palfestivian_featured_meta_box( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'palfestivian_featured_nonce' ); ?>

  <p>
    <label for="palfestivian-featured"><?php _e( "Add featured content by this author", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="palfestivian-featured" id="palfestivian-featured" value="<?php echo esc_attr( get_post_meta( $post->ID, 'palfestivian_featured', true ) ); ?>" size="30" />
  </p>
<?php }

/* Save the last name metadata. */

function palfestivian_save_last_name_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['palfestivian_last_name_nonce'] ) || !wp_verify_nonce( $_POST['palfestivian_last_name_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['palfestivian-last-name'] ) ? sanitize_html_class( $_POST['palfestivian-last-name'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'palfestivian_last_name';

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


/* Save the featured content metadata. */
function palfestivian_save_featured_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['palfestivian_featured_nonce'] ) || !wp_verify_nonce( $_POST['palfestivian_featured_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['palfestivian-featured'] ) ? sanitize_html_class( $_POST['palfestivian-featured'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'palfestivian_featured';

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


//////////////////////////////////////////////////////////////


/* Filter the post class hook with our custom post class function. */
add_filter( 'post_class', 'palfestivian_featured' );

function palfestivian_featured( $classes ) {

  /* Get the current post ID. */
  $post_id = get_the_ID();

  /* If we have a post ID, proceed. */
  if ( !empty( $post_id ) ) {

    /* Get the custom post class. */
    $post_class = get_post_meta( $post_id, 'palfestivian_featured', true );

    /* If a post class was input, sanitize it and add it to the post class array. */
    if ( !empty( $post_class ) )
      $classes[] = sanitize_html_class( $post_class );
  }

  return $classes;
}


////////////////////////////////////////////////////////////


/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'palfestivian_meta_boxes_setup' );
add_action( 'load-post-new.php', 'palfestivian_meta_boxes_setup' );

?>