<?
class WpConfigCore {

	public $defaults;
	public $customs;

	public $imageSizes;
	public $add_scripts 				= array();
	public $remove_scripts 			= array();
	public $add_styles 					= array();
	public $dashboard_boxes 			= array();
	public $media_sizes 				= array();
	public $body_classes 				= false;
	public $custom_post_types	 		= false;
	public $mime_types 				= array();



	public function execute() {

		add_action( 'after_setup_theme', array( &$this, 'after_setup_theme' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ) );

		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		add_action( 'init', array( &$this, 'init' ) );


		// Filters
		add_filter( 'admin_footer_text', array( &$this, 'admin_footer_text' ) );

		if( count( $this->media_sizes ) > 0 ):
			add_filter( 'image_size_names_choose', array( &$this, 'custom_image_sizes' ) );
		endif;

		if( count( $this->mime_types ) > 0 ):
			add_filter('upload_mimes', array( &$this, 'upload_mimes' ) );
		endif;

		if( $this->body_classes ):
			add_filter( 'body_class', array( &$this, 'body_class' ) );
		endif;

	}
	
	/*************************************************************************************************************************************/
	/********* ACTIONS
	/*************************************************************************************************************************************/
	public function after_setup_theme() {

		// Post thumbnails
		if( $this->defaults['post_thumbnails'] ):
			add_theme_support( 'post-thumbnails' );
		endif;

		// Page Excerpt
		if( $this->defaults['page_excerpt'] ):
			add_post_type_support( 'page', 'excerpt');
		endif;

		// HTML 5
		if( $this->defaults['html5'] ):
			add_theme_support( 'html5', $this->defaults['html5_elements'] );
		endif;

		// Add Image Sizes
		if( count( $this->media_sizes ) > 0 ):

			foreach( $this->media_sizes AS $media_size ):

				if( $media_size['slug'] == '' || !$media_size['slug'] ) continue;

				$width		= ( $media_size['width'] ) ? $media_size['width'] : 0;
				$height 	= ( $media_size['height'] ) ? $media_size['height'] : 0;
				$crop 		= ( $media_size['crop'] ) ? $media_size['crop'] : 0;

				add_image_size( $media_size['slug'], $width, $height, $crop );

			endforeach;

		endif;

	}

	public function wp_enqueue_scripts() {

		if( count( $this->remove_scripts ) > 0 ):

			foreach( $this->remove_scripts as $k => $r_script ):
				wp_deregister_script( $r_script );
			endforeach;

		endif;

		if( count( $this->add_scripts ) > 0 ):

			foreach( $this->add_scripts as $k => $a_script ):
				wp_enqueue_script( $a_script[0], $a_script[1], $a_script[2], null );
			endforeach;

		endif;


		if( count( $this->add_styles ) > 0 ):

			foreach( $this->add_styles as $k => $a_style ):
				wp_enqueue_style( $a_style[0], $a_style[1], $a_style[2], null );
			endforeach;

		endif;

	}


	public function admin_init() {

		// Remove Dashboard Widgets
		$default_dashboard_boxes = $this->defaultDashboardBoxes();

		foreach( $default_dashboard_boxes AS $box => $position ):
			if( !array_key_exists( $box, $this->dashboard_boxes ) ):
		        remove_meta_box( $box, 'dashboard', $position );
		    endif;
		endforeach;

		// Remove Welcome Screen
		if( !$this->customs['welcome_panel'] ):
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
		endif;

	}


	public function init() {

		// Post Types
		if( $this->custom_post_types ):

			foreach( $this->custom_post_types as $k => $pt ):

				register_post_type( $pt['slug'], $pt['args'] ); 

			endforeach;

		endif;

	}


	/*************************************************************************************************************************************/
	/********* FILTERS
	/*************************************************************************************************************************************/

	public function admin_footer_text() {

		if( $this->customs['footer_text'] ):
			return '<span id="footer-thankyou">' . $this->customs['footer_text'] . '<span>';
		endif;

	}

	public function body_class( $classes ) {

		foreach( $this->body_classes as $k => $class ):

			$classes[] = $class;

		endforeach;

		return $classes;

	}

	public function custom_image_sizes( $sizes ) {

		foreach( $this->media_sizes AS $media_size ):

			if( $media_size['slug'] == '' || !$media_size['slug'] ) continue;

			$sizes[ $media_size['slug'] ] = __( $media_size['name'] );

		endforeach;

		return $sizes;

	}

	public function upload_mimes( $mime_types ) {

		foreach( $this->mime_types AS $extension => $mime_type ):
			$mime_types[ $extension ] = $mime_type;
		endforeach;
		// $existing_mimes['deb'] = 'application/x-deb';
		// unset( $existing_mimes['deb'] );

		return $mime_types;
	}

}