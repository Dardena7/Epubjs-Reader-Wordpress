<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">

        <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__).'css/normalize.css'; ?>">
        <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__).'css/main.css'; ?>">
        <link rel="stylesheet" href="<?php echo plugin_dir_url(__FILE__).'css/popup.css'; ?>">

        <script src="<?php echo plugin_dir_url(__FILE__).'js/libs/jquery.min.js'; ?>" ></script>
 
        <script src="<?php echo plugin_dir_url(__FILE__).'js/libs/zip.min.js'?>"></script>

        <script>
            "use strict";
            document.onreadystatechange = function () {
              if (document.readyState == "complete") {
                window.reader = ePubReader("<?php echo get_post_meta($post->ID, 'epub_file', true)['url']; ?>", {
                   restore: true
                 });

                $('#title-controls').css('margin-right', '30px');
              }
            };


        </script>

        <!-- File Storage -->
        <!-- <script src="js/libs/localforage.min.js"></script> -->

        <!-- Full Screen -->
        <script src="<?php echo plugin_dir_url(__FILE__).'js/libs/screenfull.min.js'; ?>"></script>

        <!-- Render -->
        <script src="<?php echo plugin_dir_url(__FILE__).'js/epub.js'; ?>"></script>

        <!-- Reader -->
        <script src="<?php echo plugin_dir_url(__FILE__).'js/reader.js'; ?>"></script>
        <script src="<?php echo plugin_dir_url(__FILE__).'js/test.js'; ?>"></script>

        <!-- Plugins -->
        <!--<script src="<?php //echo plugin_dir_url(__FILE__).'js/plugins/search.js'; ?>"></script>-->
        <!-- <script src="<?php //echo plugin_dir_url(__FILE__).'js/hypothesis.js'; ?>"></script> -->
        <?php
        if(get_post_meta($post->ID, 'hypothesis_enabled', true) == "enabled") {
        ?>
          <script src="https://hypothes.is/embed.js" async></script>
        <?php
          }
        ?>

        <!-- Highlights -->
        <!--<script src="<?php //echo plugin_dir_url(__FILE__).'js/libs/jquery.highlight.js'; ?>"></script>
        <script src="<?php //echo plugin_dir_url(__FILE__).'js/hooks/extensions/highlight.js'; ?>"></script>-->


    </head>
    <body>
      <div id="sidebar">
        <div id="panels">

          <!--<input id="searchBox" placeholder="search" type="search">
          <a id="show-Search" class="show_view icon-search" data-view="Search">Search</a>-->
          <a id="show-Toc" class="show_view icon-list-1 active" data-view="Toc">TOC</a>
          <a id="show-Bookmarks" class="show_view icon-bookmark" data-view="Bookmarks">Bookmarks</a>
          <!-- <a id="show-Notes" class="show_view icon-edit" data-view="Notes">Notes</a> -->

        </div>
        <div id="tocView" class="view">
        </div>
        <!--<div id="searchView" class="view">
          <ul id="searchResults"></ul>
        </div>-->
        <div id="bookmarksView" class="view">
          <ul id="bookmarks"></ul>
        </div>
        <div id="notesView" class="view">
          <div id="new-note">
            <textarea id="note-text"></textarea>
            <button id="note-anchor">Anchor</button>
          </div>
          <ol id="notes"></ol>
        </div>
      </div>
      <div id="main">

        <div id="titlebar">
          <div id="opener">
            <a id="slider" class="icon-menu">Menu</a>
          </div>
          <div id="metainfo">
            <span id="book-title"></span>
            <span id="title-seperator">&nbsp;&nbsp;–&nbsp;&nbsp;</span>
            <span id="chapter-title"></span>
          </div>
          <div id="title-controls">
            <a id="bookmark" class="icon-bookmark-empty">Bookmark</a>
            <a id="setting" class="icon-cog">Settings</a>
            <a id="fullscreen" class="icon-resize-full">Fullscreen</a>
          </div>
        </div>

        <div id="divider"></div>
        <div id="prev" class="arrow">‹</div>
        <div id="viewer"></div>
        <div id="next" class="arrow">›</div>
        <div id="extras">
          <ul id="highlights"></ul>
        </div>

        <div id="loader"><img src="<?php echo plugin_dir_url(__FILE__).'img/loader.gif'; ?>"></div>
      </div>


      <div class="modal md-effect-1" id="settings-modal">
          <div class="md-content">
              <h3>Settings</h3>
              <div>
              <!--
                  <p>
                    <input type="checkbox" id="sidebarReflow" name="sidebarReflow">Reflow text when sidebars are open.
                  </p>
              -->
                  <p>
                    <label for='font_family_selector'>Font Family</label>
                    <select id='font_family_selector' name='font_family_selector'>
                      <option value="serif" selected>Serif</option>
                      <option value="sans-serif">Sans-Serif</option>
                    </select>
                  </p>
                  <p>
                    <label for="font_size_selector">Font Size</label>
                    <select id="font_size_selector" name="font_size_selector">
                      <option value="75%">75%</option>
                      <option value="100%" selected>100%</option>
                      <option value="125%">125%</option>
                    </select>
                  </p>
                  <p>
                    <label for="theme_mode_selector">Theme Mode</label>
                    <select id="theme_mode_selector" name="theme_mode_selector">
                      <option value="light" selected>Light</option>
                      <option value="night">Night</option>
                      <option value="beige">Beige</option>
                    </select>
                  </p>
              </div>
              <div class="closer icon-cancel-circled"></div>
          </div>
      </div>
      <div class="overlay"></div>

      <script src="<?php echo plugin_dir_url(__FILE__).'js/reader-options.js'; ?>"></script>
    </body>
</html>