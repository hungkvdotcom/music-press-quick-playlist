<?php
function music_press_pro_get_songs_from_playlist($playlistID)
{
    global $wpdb;
    $table = $wpdb->prefix . 'music_press_quick_playlist';
    $playlist_values = "SELECT * FROM {$table} WHERE id = $playlistID";
    $playlist_results = $wpdb->get_results($playlist_values);
    $song_arr = array();
    if (isset($playlist_results) && $playlist_results != ''):
        foreach ($playlist_results as $results):

            $songs_string = $results->song_ids;
            $song_arr = unserialize($songs_string);

        endforeach;
        return $song_arr;
    endif;
}
