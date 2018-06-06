<?php

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_qa_settings  {
	
	public function __construct(){

		add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
    }
	
	public function admin_menu() {
        add_menu_page(
            'Quick Playlist',
            'Quick Playlist',
            'manage_options',
            'music-press-quick-playlist',
            array( $this, 'settings' ), // Callback, leave empty
            MUSIC_PRESS_QUICK_PLAYLIST_PLUGIN_URL . '/assets/images/music-press.png',
            11 // Position
        );


        //add_dashboard_page( '', '', 'manage_options', 'qa-setup', '' );
        add_submenu_page( 'music-press-quick-playlist', __( 'All Playlists', 'music-press-quick-playlist' ), __( 'All Playlists', 'music-press-quick-playlist' ), 'manage_options', 'all-playlist', array( $this, 'allplaylist' ) );

		//add_dashboard_page( '', '', 'manage_options', 'qa-setup', '' );
		add_submenu_page( 'music-press-quick-playlist', __( 'Add New', 'music-press-quick-playlist' ), __( 'Add New', 'music-press-quick-playlist' ), 'manage_options', 'add-new', array( $this, 'addnew' ) );

        remove_submenu_page('music-press-quick-playlist','music-press-quick-playlist');

		do_action( 'qa_action_admin_menus' );
		
	}
	
	public function settings(){
		include( MUSIC_PRESS_QUICK_PLAYLIST_PLUGIN_DIR. 'includes/process/setting.php' );
	}

	public function addnew(){
		include( MUSIC_PRESS_QUICK_PLAYLIST_PLUGIN_DIR. 'includes/process/add-new.php' );
	}
    public function allplaylist(){
        include( MUSIC_PRESS_QUICK_PLAYLIST_PLUGIN_DIR. 'includes/process/all-playlist.php' );
    }
    public function edit(){
        include( MUSIC_PRESS_QUICK_PLAYLIST_PLUGIN_DIR. 'includes/process/edit.php' );
    }
} new class_qa_settings();

