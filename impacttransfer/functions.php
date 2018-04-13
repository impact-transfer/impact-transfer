<?

//include( get_template_directory() . "/config/WpConfig.class.php" );
/**
 * Initialise Class
 */
//$WpConfigSase = new WpConfig;

/**
 * Create custom post types
 */

register_post_type( 'solution',
array(
  'labels' => array(
    'name' => __( 'Solutions' ),
    'singular_name' => __( 'Solution' )
  ),
  'public' => true,
  'has_archive' => true,
  'menu_icon' => 'dashicons-lightbulb',
  'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail')
)
);

register_post_type( 'zero',
array(
  'labels' => array(
    'name' => __( 'Zero projects' ),
    'singular_name' => __( 'Zero project' )
  ),
  'public' => true,
  'has_archive' => true,
  'menu_icon' => 'dashicons-lightbulb',
  'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail')
)
);


register_post_type( 'role',
array(
  'labels' => array(
    'name' => __( 'Roles' ),
    'singular_name' => __( 'Role' )
  ),
  'public' => true,
  'has_archive' => true,
  'menu_icon' => 'dashicons-groups',
  'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail')
)
);

function delete_post_type(){
    unregister_post_type( 'fellow' );
}
add_action('init','delete_post_type');



function child_styles() {
wp_enqueue_style( 'sase-styles', get_stylesheet_directory_uri().'/assets/css/style.css', array('ashoka-styles'), '1.0' );
}
add_action( 'wp_enqueue_scripts', 'child_styles' );


function create_custom_sase_taxonomies() {
  
  $labels = array(
    'name'              => _x( 'Topic', 'taxonomy general name' ),
    'singular_name'     => _x( 'Topic', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Topic' ),
    'all_items'         => __( 'All Areas' ),
    'parent_item'       => __( 'Parent Topic' ),
    'parent_item_colon' => __( 'Parent Topic:' ),
    'edit_item'         => __( 'Edit Topic' ),
    'update_item'       => __( 'Update Topic' ),
    'add_new_item'      => __( 'Add New Topic' ),
    'new_item_name'     => __( 'New Topic Name' ),
    'menu_name'         => __( 'Topic' ),
  );

  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'topic' ),
  );

  register_taxonomy( 'topic', array( 'solution' ), $args );

}
add_action( 'init', 'create_custom_sase_taxonomies', 0 );


function create_zero_taxonomies() {
  
  $labels = array(
    'name'              => _x( 'Topic zero', 'taxonomy general name' ),
    'singular_name'     => _x( 'Topic', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Topic' ),
    'all_items'         => __( 'All Areas' ),
    'parent_item'       => __( 'Parent Topic' ),
    'parent_item_colon' => __( 'Parent Topic:' ),
    'edit_item'         => __( 'Edit Topic' ),
    'update_item'       => __( 'Update Topic' ),
    'add_new_item'      => __( 'Add New Topic' ),
    'new_item_name'     => __( 'New Topic Name' ),
    'menu_name'         => __( 'Topic' ),
  );

  $args = array(
    'hierarchical'      => true,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
  //  'rewrite'           => array( 'slug' => 'topic' ),
  );

  register_taxonomy( 'topic_zero', array( 'zero' ), $args );

}
add_action( 'init', 'create_zero_taxonomies', 0 );



add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );
  
  function add_current_nav_class($classes, $item) {
    
    // Getting the current post details
    global $post;
    
    // Getting the post type of the current post
    $current_post_type = get_post_type_object(get_post_type($post->ID));
    $current_post_type_slug = $current_post_type->rewrite[slug];
      
    // Getting the URL of the menu item
    $menu_slug = strtolower(trim($item->url));
    
    // If the menu item URL contains the current post types slug add the current-menu-item class
    if (strpos($menu_slug,$current_post_type_slug) !== false) {
    
       $classes[] = 'current-menu-item';
    
    }
    
    // Return the corrected set of classes to be added to the menu item
    return $classes;
  
  }


  function wpdev_nav_classes( $classes, $item ) {
      if( ( is_post_type_archive( array('role', 'solution') ) || is_singular( array('role', 'solution') ) ) ){
          $classes = array_diff( $classes, array( 'current_page_parent' ) );
      }
      return $classes;
  }
  add_filter( 'nav_menu_css_class', 'wpdev_nav_classes', 10, 2 );


  function child_theme_setup() {
      add_image_size( 'hero', 1400, 500, true );
  }
  add_action( 'after_setup_theme', 'child_theme_setup', 11 );