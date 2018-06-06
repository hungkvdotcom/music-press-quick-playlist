<?php
/** Ajax Post */
add_action('wp_ajax_nopriv_MusicPressQuickPlaylist_playlist_init', 'MusicPressQuickPlaylist_playlist_init');
add_action('wp_ajax_MusicPressQuickPlaylist_playlist_init', 'MusicPressQuickPlaylist_playlist_init');
function MusicPressQuickPlaylist_playlist_init()
{
    $music_press_quick_playlist_get_title = $_POST['music_press_quick_playlist_title'];
    $music_press_quick_playlist_get_slug = sanitize_title($music_press_quick_playlist_get_title);
    $music_press_quick_playlist_get_ids = $_POST['music_press_quick_playlist_ids'];
    $music_press_quick_playlist_get_songIDs = serialize($music_press_quick_playlist_get_ids);
    $user = get_current_user_id();
    $now_time = current_time('mysql');
    global $wpdb;

    $table = $wpdb->prefix . 'music_press_quick_playlist';

    $query = "SELECT * FROM {$table} WHERE status = 1";

    $data = array(
        'playlist_name' => $music_press_quick_playlist_get_title,
        'slug' => $music_press_quick_playlist_get_slug,
        'song_ids' => $music_press_quick_playlist_get_songIDs,
        'user_id' => $user,
        'publish_date' => $now_time,
    );

    $format = array('%s', '%s', '%s', '%d');

    $info = $wpdb->insert($table, $data, $format);

    exit;
}

// Filter Process
/** Ajax Post */
add_action('wp_ajax_nopriv_MusicPressQuickPlaylist_filter', 'MusicPressQuickPlaylist_filter_init');
add_action('wp_ajax_MusicPressQuickPlaylist_filter', 'MusicPressQuickPlaylist_filter_init');
function MusicPressQuickPlaylist_filter_init()
{
    $sourcegenreID = $_POST['filter_genre'];
    $sourcealbumID = $_POST['filter_album'];
    $sourceartistID = $_POST['filter_artist'];
    $sourcelimit = $_POST['filter_limit'];
    $sourceorder = $_POST['filter_order'];
    $sourceorderby = $_POST['filter_orderby'];
    $genreID = '';
    $albumID = '';
    $artistID = '';
    $limit = '';
    $order = 'DESC';
    $orderby = 'title';
    $metakey = '';
    if($sourcegenreID != 'Genre'){
        $genreID = $sourcegenreID;
    }
    if($sourcealbumID != 'Album'){
        $albumID = $sourcealbumID;
    }
    if($sourceartistID != 'Artist'){
        $artistID = $sourceartistID;
    }
    if($sourcelimit != ''){
        $limit = $sourcelimit;
    }
    if($sourceorder != 'none'){
        if($sourceorder == 0){
            $order = 'DESC';
        }else{
            $order = 'ASC';
        }
    }
    if($sourceorderby != 'none'){
        if($sourceorderby == 0){
            $orderby = 'date';
        }else{
            $order = 'meta_value_num';
            $metakey = 'mp_count_play';
        }
    }
    $query_args = array(
        'post_type' => 'mp_song',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'song_genre',
                'value' => $genreID,
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'song_album',
                'value' => $albumID,
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'song_artist',
                'value' => $artistID,
                'compare' => 'LIKE',
            ),
            array(
                'key' => 'song_type',
                'value' => 'audio'
            )
        ),
        'ignore_sticky_posts' => 1,
        'order' => $order,
        'orderby' => $orderby,
        'meta_key' => $metakey,
        'posts_per_page' => $limit,

    );
    $songs = new WP_Query($query_args);
    if ($songs->have_posts()) :
        while ($songs->have_posts()) : $songs->the_post();
//            $songID = get_the_ID();
            ?>

            <li data-id="<?php echo get_the_ID(); ?>" class="playlist_item">
                <?php the_title(); ?>
            </li>

        <?php
        endwhile;
    endif;
    exit;
}

add_action('wp_ajax_music_press_single_delete', 'music_press_single_delete_init');
add_action('wp_ajax_nopriv_music_press_single_delete', 'music_press_single_delete_init');
function music_press_single_delete_init()
{

    $deleteID = $_POST['id_delete'];
// Khởi tạo biến toàn cục
    global $wpdb;

// Gán biến $table để hứng giá trị
    $table = $wpdb->prefix . 'music_press_quick_playlist';

// Câu truy vấn sql
    $query = "SELECT * FROM {$table} WHERE status = 1";

// Chỉ đinh xóa dòng dữ liệu thuộc ID là 26
    $where = array(
        'id' => $deleteID
    );

// Định dạng dữ liệu là con số.
    $where_format = array('%d');

// Phương thức xóa một dòng dữ liệu trong table
    $info = $wpdb->delete($table, $where, $where_format);

    exit;
}

add_action('wp_ajax_music_press_replace', 'music_press_replace_init');
add_action('wp_ajax_nopriv_music_press_replace', 'music_press_replace_init');
function music_press_replace_init()
{

    $replaceID = $_POST['id_replace'];
    $replace_title = $_POST['replace_title'];
    $replace_slug = sanitize_title($replace_title);
    $replace_songids = $_POST['replace_songids'];
    $update_songids = serialize($replace_songids);
    $user = get_current_user_id();
    $now_time = current_time('mysql');

    global $wpdb;

    $table = $wpdb->prefix . 'music_press_quick_playlist';

    $query = "SELECT * FROM {$table} WHERE status = 1";

    $data = array(
        'playlist_name' => $replace_title,
        'slug' => $replace_slug,
        'song_ids' => $update_songids,
        'user_id' => $user,
        'publish_date' => $now_time
    );

    $where = array(
        'id' => $replaceID
    );

    $info = $wpdb->update($table, $data, $where);


    exit;
}
