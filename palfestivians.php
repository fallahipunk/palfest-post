<?php
// register custom post type to work with
function palfest_create_palfestivians() {
	// set up labels
	$labels = array(
 		'name' => 'Artists',
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
    	'menu_name' => 'Artists',
    );
    //register post type
	register_post_type( 'profile', array(
		'labels' => $labels,
		'has_archive' => true,
 		'public' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies' => array('category' ),	
		'exclude_from_search' => false,
		'capability_type' => 'post',
		'rewrite' => array( 'slug' => 'Artists' ),
		)
	);
}

/* Meta box setup function. */
function palfestivian_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'palfestivian_add_post_meta_boxes' );

  /* Save post meta on the 'save_post' hook. */
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



}

function palfestivian_last_name_meta_box( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'palfestivian_last_name_nonce' ); ?>

  <p>
    <label for="palfestivian-last-name"><?php _e( "Last Name (for sorting purposes)", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="palfestivian-last-name" id="palfestivian-last-name" value="<?php echo esc_attr( get_post_meta( $post->ID, 'palfestivian_last_name', true ) ); ?>" size="30" />
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
  $new_meta_value = $_POST['palfestivian-last-name'];

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

// ------------ link profile to articles, requires post2post -----------------//
function my_connection_types() {
    p2p_register_connection_type( array(
        'name' => 'profiles_to_articless',
        'from' => 'profile',
        'to' => 'article'
    ) );

        p2p_register_connection_type( array(
        'name' => 'profiles_to_days',
        'from' => 'profile',
        'to' => 'day'
    ) );

}
add_action( 'p2p_init', 'my_connection_types' );



////////////////////////////////////////////////////////////


/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'palfestivian_meta_boxes_setup' );
add_action( 'load-post-new.php', 'palfestivian_meta_boxes_setup' );

?>