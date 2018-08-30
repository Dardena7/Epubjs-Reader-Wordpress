<?php

class Epub_Custom_Post {
	var $post_type_name = 'epub_post_type'; 

	public function __construct() {
		add_action('init', array($this,'epub_post_register'));
		add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
		add_action('post_edit_form_tag', array($this, 'add_post_enctype'));
		add_action('save_post', array($this, 'save_custom_meta_data'));
		add_filter('single_template', array($this, "reader_template"));
		add_action('pre_get_posts', array($this,'add_epubposts_to_query'), 99);
	}

	//Register epub post type
	public function epub_post_register() {
		$labels = array(
			'name' => _x('Epub Post', 'post type general name'),
			'singular_name' => _x('epub item', 'post type singular name'),
			'add_new' => _x('Add New', 'epub item'),
			'add_new_item' => __('Add New Epub Item'),
			'edit_item' => __('Edit Epub Item'),
			'new_item' => __('New Epub Item'),
			'view_item' => __('View epub Item'),
			'search_items' => __('Search Epub'),
			'not_found' =>  __('Nothing found'),
			'not_found_in_trash' => __('Nothing found in Trash'),
			'parent_item_colon' => ''
		);

		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => 'dashicons-book-alt',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail')
		  ); 

		register_post_type($this->post_type_name, $args );
	}

	//Add uploader meta box in 'add & edit epub post'
	public function add_meta_boxes() {
		$this->add_upload_meta_box();
	}

	public function save_custom_meta_data($id) {
		$this->save_epub_upload($id);
		$this->save_hypothesis_enabled($id);
	}

	public function add_upload_meta_box() {
		add_meta_box("epub_upload_meta_box", "Upload your epub file", array($this,"epub_upload_html"), $this->post_type_name, "normal", "low");
		add_meta_box("hypothesis_meta_box", "Enable hypothesis", array($this,"hypothesis_html"), $this->post_type_name, "normal", "low");
	}

	//epub uploader meta box html
	public function epub_upload_html() {
		$html = "<p>";
		$html .= "<label>Epub</label>";
		$html .= "<input id='epub_file' name='epub_file' type='file'>";
		$html .= "</p>";

		$screen = get_current_screen();
		
		if($screen->action != 'add')
			$html .= "<p><b>Current Epub : </b>". get_post_meta(get_post()->ID, 'epub_file', true)['url']."</p>";
		
		echo $html;
	}

	//epub uploader meta box html
	public function hypothesis_html() {
		$html = "<p>";
		$html .= "<label>Enable Hypothesis  :  </label>";
		$html .= $this->hypothesis_checkbox_html();
		$html .= "</p>";
		
		echo $html;
	}

	private function hypothesis_checkbox_html() {
		if($this->check_hypothesis_enabled_for_edit()) 
			return "<input id='hypothesis_enabled' name='hypothesis_enabled' type='checkbox' checked>";
		else
			return "<input id='hypothesis_enabled' name='hypothesis_enabled' type='checkbox'>";
	}

	private function check_hypothesis_enabled_for_edit() {
		$screen = get_current_screen();
		if($screen->action != 'add')
			return get_post_meta(get_post()->ID, 'hypothesis_enabled', true) == "enabled";
		return false;
	}

	//Load epub reader template for epub posts
	public function reader_template() {
		global $post;
		if ($post->post_type == $this->post_type_name) {
			if(file_exists(plugin_dir_path(__FILE__) . 'reader_template/reader_template.php')) {
				return plugin_dir_path(__FILE__) . 'reader_template/reader_template.php';
			}
		}
		return $single;
	}

	public function save_hypothesis_enabled($id) {
		if(isset($_POST['hypothesis_enabled'])){
			add_post_meta($id, 'hypothesis_enabled', 'enabled');
			update_post_meta($id, 'hypothesis_enabled', 'enabled');
		}
		else{
			add_post_meta($id, 'hypothesis_enabled', 'disabled');
			update_post_meta($id, 'hypothesis_enabled', 'disabled');
		}
	}

	//Save epub files
	public function save_epub_upload($id) {
	    // Make sure the file array isn't empty

	    if(!empty($_FILES['epub_file']['name'])) {
	        // Setup the array of supported file types. In this case, it's just PDF.
	        $supported_types = array('application/epub+zip', 'application/x-mobipocket-ebook');
	         
	        // Get the file type of the upload
	        $arr_file_type = wp_check_filetype(basename($_FILES['epub_file']['name']));
	        $uploaded_type = $arr_file_type['type'];
	         
	        // Check if the type is supported. If not, throw an error.
	        if(in_array($uploaded_type, $supported_types)) {
	 
	            // Use the WordPress API to upload the file
	            $upload = wp_upload_bits($_FILES['epub_file']['name'], null, file_get_contents($_FILES['epub_file']['tmp_name']));
	     
	            if(isset($upload['error']) && $upload['error'] != 0) {
	                wp_die('There was an error uploading your file. The error is: ' . $upload['error']);
	            } else {
	                add_post_meta($id, 'epub_file', $upload);
	                update_post_meta($id, 'epub_file', $upload);     
	            } // end if/else
	 
	        } else {
	            wp_die("The file type that you've uploaded is not an EPUB.");
	        } // end if/else
	         
	    } // end if
	     
	} // end save_custom_meta_data

	//add enctype to forms
	public function add_post_enctype() {
	    echo 'enctype="multipart/form-data"';
	}

	//add epub posts in home flux
	public function add_epubposts_to_query( $query ) {
	  	if ( is_home() && $query->is_main_query() ) {
	  		$post_types = $query->get('post_type');
	  		// Check that the current posts types are stored as an array
	  		if(!is_array($post_types) && !empty($post_types))
            	$post_types = explode(',', $post_types);
            // If there are no post types defined, be sure to include posts so that they are not ignored
	        if(empty($post_types))                              
	            $post_types[] = 'post';    
	        // Add your custom post type     
	        $post_types[] = $this->post_type_name;                  
	        // Trim every element, just in case
	        $post_types = array_map('trim', $post_types);
	        // Remove any empty elements, just in case       
	        $post_types = array_filter($post_types); 

	    	$query->set( 'post_type', $post_types);
	  	}
	  	return $query;
	}

}