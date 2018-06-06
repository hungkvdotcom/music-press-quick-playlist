<?php

class MusicPressQuickPlayListBackend {

    private $_menuSlug = 'MusicPressQuickPlayList-my-setting';


    public function __construct(){

        add_action( 'admin_menu', array( $this, 'admin_menu' ), 12 );
    }

    public function admin_menu() {
        add_menu_page(
            'Music Quick Playlist',
            'Music Quick Playlist',
            'manage_options',
            'music-press-quick-playlist',
            array( $this, 'settingPage' ), // Callback, leave empty
            MUSIC_PRESS_QUICK_PLAYLIST_PLUGIN_DIR . 'assets/images/music-press.png',
            11 // Position
        );

        //add_dashboard_page( '', '', 'manage_options', 'qa-setup', '' );
        add_submenu_page( 'music-press-quick-playlist', __( 'Add New', 'music-press-quick-playlist' ), __( 'Add New', 'music-press-quick-playlist' ), 'manage_options', 'addnewPage', array( $this, 'addnewPage' ) );


        do_action( 'qa_action_admin_menus' );

    }

    public function settingPage(){
        include( MUSIC_PRESS_QUICK_PLAYLIST_VIEWS_DIR. '/setting-page.php' );
    }


    public function addnewPage(){
        include( MUSIC_PRESS_QUICK_PLAYLIST_VIEWS_DIR. '/add-new-page.php' );
    }


}