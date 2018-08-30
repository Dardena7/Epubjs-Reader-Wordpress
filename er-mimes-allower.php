<?php

class Epub_Mimes_Allower {
	public function __construct() {
		add_filter('upload_mimes', array($this, 'allow_epub'));
	}

	//Allow epub files upload
	public function allow_epub($existing_mimes) {
	    $existing_mimes['epub'] = 'application/epub+zip';
	    $existing_mimes['mobi'] = 'application/x-mobipocket-ebook';
 
    	return $existing_mimes;
	}

}