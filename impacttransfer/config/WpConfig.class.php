<?
// Include Core Class
include("WpConfigCore.class.php");

class WpConfig extends WpConfigCore {

	
	public function __construct() {

		$this->defaults 		= $this->defaultSettings();
		$this->customs 			= $this->defaultCustomizations();
		$this->dashboard_boxes 	= $this->defaultDashboardBoxes();

		$this->theme_path 		= get_template_directory();
		$this->theme_url 		= get_template_directory_uri();

	}

	/*************************************************************************************************************************************/
	/********* BASIC FUNCTIONS
	/*************************************************************************************************************************************/

	public function set( $setting, $value ) {

		$this->defaults[$setting] = $value;


	}

	public function customize( $setting, $value ) {

		$this->customs[$setting] = $value;

	}

	// Scripts
	public function addScripts( $scripts ) {
		
		foreach( $scripts as $k => $script ):
			$this->addScript( $script );
		endforeach;

	}

	public function addScript( $script ) {

		$this->add_scripts[] = $script;

	}

	public function removeScript( $slug ) {
		
		$this->remove_scripts[] = $slug;
	}

	// Styles
	public function addStyles( $styles ) {
		
		foreach( $styles as $k => $style ):
			$this->addStyle( $style );
		endforeach;

	}

	public function addStyle( $style ) {
		
		$this->add_styles[] = $style;

	}

	// Media Sizes
	public function addMediaSize( $size ) {

		$this->media_sizes[] = $size;
		
	}

	// Body Classes
	public function addBodyClass( $classes ) {

		if( !$this->body_classes ) $this->body_classes = array();

		if( is_array( $classes ) ):
			foreach( $classes as $k => $class ):
				$this->addBodyClass( $class );
			endforeach;
		else:
			$this->body_classes[] = $classes;
		endif;

	}

	// Mimetypes
	public function addMimeType( $extension, $mime ) {
		$this->mime_types[$extension] = $mime;
	}

	public function get( $what ) {

		switch( $what ):

			case "theme_path":
				return $this->theme_path;
			break;

			case "theme_url":
				return $this->theme_url;
			break;

		endswitch;

	}

	// Post Types
	public function addCustomPostType( $slug, $labels, $args ) {

		$default_labels = array(
			'add_new'            	=> 'Add New',
			'add_new_item'       	=> 'Add New [[SINGLE]]',
			'edit_item'          	=> 'Edit [[SINGLE]]',
			'new_item'           	=> 'New [[SINGLE]]',
			'all_items'          	=> 'All [[PLURAL]]',
			'view_item'          	=> 'View [[SINGLE]]',
			'search_items'       	=> 'Search [[PLURAL]]',
			'not_found'          	=> 'No [[PLURAL]] found',
			'not_found_in_trash' 	=> 'No [[PLURAL]] found in the Trash', 
			'parent_item_colon'  	=> '',
			'menu_name'          	=> '[[PLURAL]]'
		);

		foreach( $default_labels as $k => $df ):

			$df = str_replace( array("[[SINGLE]]", "[[PLURAL]]"), array( $labels['singular_name'], $labels['name'] ), $df );

			if( $labels[$k] == '' )	$labels[$k] = $df;

		endforeach;

		$args['labels'] = $labels;

		$this->custom_post_types[] = array(
			'slug' 	=> $slug,
			'args' 	=> $args
		);

	}

	/*************************************************************************************************************************************/
	/********* SPECIAL FUNCTIONS
	/*************************************************************************************************************************************/
	public function removeDashboardBoxes( $boxes = 'all' ) {
		
		if( $boxes == 'all' ):
			$this->dashboard_boxes = array();
			return;
		endif;

		foreach( $boxes as $box ):
			unset( $this->dashboard_boxes["dashboard_" . $box] );
		endforeach;

	}

	/*************************************************************************************************************************************/
	/********* DEFAULTS
	/*************************************************************************************************************************************/
	public function defaultSettings() {

		$defaults = array(
			'post_thumbnails' 		=> false,
			'page_excerpt' 			=> false,
			'html5' 				=> false,
			'html5_elements' 		=> array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption')
		);

	}

	public function defaultCustomizations() {

		$defaults = array(
			'footer_text' 			=> false,
			'welcome_panel' 		=> false
		);

	}

	public function defaultDashboardBoxes() {

		return array(
			'dashboard_incoming_links' 		=> 'normal',
			'dashboard_plugins' 			=> 'normal',
			'dashboard_primary' 			=> 'normal',
			'dashboard_secondary' 			=> 'normal',
			'dashboard_quick_press' 		=> 'side',
			'dashboard_recent_drafts' 		=> 'side',
			'dashboard_recent_comments' 	=> 'normal',
			'dashboard_right_now' 			=> 'normal',
			'dashboard_activity' 			=> 'normal'
		);

	}

}