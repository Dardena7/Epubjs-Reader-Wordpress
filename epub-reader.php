<?php

/*
Plugin Name: Epub-Reader
Description: This plugin allow you to publish and EPUB file and display it in a reader. The reader used is "epubjs-reader" with some changes and options (more informations at https://github.com/futurepress/epubjs-reader). Moreover, you can enable "Hypothesis" which allow to add annotations (More informations at https://web.hypothes.is/).
Author: Alexis Dardenne http://imagiweb.be
Version: 1.0.0
*/

class Epub_Reader {

	public function __construct() {
		include_once plugin_dir_path(__FILE__)."er-mimes-allower.php";
		include_once plugin_dir_path(__FILE__)."er-custom-post.php";

		new Epub_Mimes_Allower();
		new Epub_Custom_Post();
	}
}

new Epub_Reader();