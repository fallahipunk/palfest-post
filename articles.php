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
        'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail',),
        'taxonomies' => array( 'post_tag', 'category' ),    
        'exclude_from_search' => false,
        'capability_type' => 'post',
        'rewrite' => array( 'slug' => 'Articles' ),
        )
    );
}

/* Meta box setup function. */
function article_profiles_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'article_add_profiles_boxes' );

    /* Save profiles on the 'save_post' hook. */
  add_action( 'save_post', 'article_save_profiles_meta', 10, 2 );
}

function article_add_profiles_boxes() {

  add_meta_box(
    'article-profiles',      // Unique ID
    esc_html__( 'Profiles', 'example' ),    // Title
    'article_profiles_meta_box',   // Callback function
    'article',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
}

/* Display the profiles meta box. */
function article_profiles_meta_box( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'article_profiles_nonce' ); ?>

  <p>
    <label for="article-profiles"><?php _e( "Add profiles of Palfestivians in this article", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="article-profiles" id="article-profiles" value="<?php echo esc_attr( get_post_meta( $post->ID, 'article_profiles', true ) ); ?>" size="30" />
  </p>
<?php }

/* Save the meta box's post metadata. */
function article_save_profiles_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['article_profiles_nonce'] ) || !wp_verify_nonce( $_POST['article_profiles_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = ( isset( $_POST['article-profiles'] ) ? sanitize_html_class( $_POST['article-profiles'] ) : '' );

  /* Get the meta key. */
  $meta_key = 'article_profiles';

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


add_action( 'load-post.php', 'article_profiles_setup' );
add_action( 'load-post-new.php', 'article_profiles_setup' );

?>