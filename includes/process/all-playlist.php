<?php
if (!defined('ABSPATH')) exit;  // if direct access
if (isset($_GET["task"]))
    $task = $_GET["task"];
else
    $task = '';
if (isset($_GET["id"]))
    $id = $_GET["id"];
else
    $id = 0;
global $wpdb;

switch ($task) {


    case 'edit':
        if ($id) {
            edit_playlist($id);
            break;
        }
    default:
        show_all_playlist();
        break;
}
function show_all_playlist()
{
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php echo esc_html__('Playlists', 'tdm') ?></h1>

        <a href="<?php echo get_home_url(); ?>/wp-admin/admin.php?page=add-new"
           class="page-title-action"><?php echo esc_html__('Add New', 'tdm'); ?></a>
        <hr class="wp-header-end">


        <h2 class="screen-reader-text">Filter posts list</h2>
        <form id="posts-filter" method="get">

            <h2 class="screen-reader-text">Posts list</h2>
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text"
                               for="cb-select-all-1">Select All</label></td>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc">
                        <a href="javascript:void(0)">
                            <span>Title</span>
                        </a>
                    </th>
                    <th scope="col" id="shortcode" class="manage-column"><?php echo esc_html__('Shortcode') ?></th>
                    <th scope="col" id="number"
                        class="manage-column column-author"><?php echo esc_html__('Number of songs') ?>
                    </th>
                    <th scope="col" class="manage-column column-author">
                        <span><?php echo esc_html__('Author', 'tdm'); ?></span>
                    </th>
                    <th scope="col" id="date" class="manage-column music-press-column-date">
                        <span><?php echo esc_html__('Date', 'tdm') ?></span>
                    </th>
                </tr>
                </thead>

                <tbody id="the-list">
                <?php
                global $wpdb;
                $table = $wpdb->prefix . 'music_press_quick_playlist';
                $playlist_values = "SELECT * FROM {$table}";
                $playlist_results = $wpdb->get_results($playlist_values);
                ?>
                <?php
                if (isset($playlist_results) && $playlist_results != '' && !empty($playlist_results)):
                    foreach ($playlist_results as $results):
                        ?>
                        <tr id="playlist-<?php echo $results->id; ?>"
                            class="iedit author-self level-0 post-<?php echo $results->id; ?> type-post status-publish format-standard hentry">
                            <th scope="row" class="check-column">
                                <label class="screen-reader-text" for="cb-select-43">
                                    Select
                                    rererer
                                </label>
                                <div class="locked-indicator">
                                    <span class="locked-indicator-icon" aria-hidden="true"></span>
                                </div>
                            </th>
                            <td class="title column-title has-row-actions column-primary page-title"
                                data-colname="Title">
                                <div class="locked-info">
                                    <span class="locked-avatar"></span>
                                    <span class="locked-text"></span>
                                </div>
                                <strong>
                                    <a class="row-title"
                                       href="admin.php?page=all-playlist&amp;task=edit&amp;id=<?php echo esc_html($results->id); ?>"
                                       aria-label="“<?php echo esc_html($results->playlist_name); ?>” (Edit)"><?php echo esc_html($results->playlist_name); ?>
                                    </a>
                                </strong>

                                <div class="row-actions">
                                <span class="edit">
                                     <a href="admin.php?page=all-playlist&amp;task=edit&amp;id=<?php echo esc_html($results->id); ?>"
                                        aria-label="Edit “<?php echo esc_html($results->playlist_name); ?>”">
                                       <?php echo esc_html__('Edit', 'tdm');
                                       ?>
                                     </a> |
                                 </span>
                                    <span href="#" id="single_delete_playlist_<?php echo esc_html($results->id); ?>"
                                          class="trash delete_single_playlist">
                                    <a href="javascript:void(0);" data-id="<?php echo esc_html($results->id); ?>">
                                        <?php echo esc_html__('Delete', 'tdm'); ?>
                                    </a>
                                </span>
                                </div>
                            </td>
                            <td class="shortcode-item" data-colname="shortcode">
                                <code>
                                    [music_press_quick_playlist id="<?php echo esc_attr($results->id); ?>"]
                                </code>
                            </td>
                            <td class="number-of-songs column-number-of-songs" data-colname="songs_number">
                                <a href="#">
                                    <?php
                                    $songs_string = $results->song_ids;
                                    $songs_array = unserialize($songs_string);
                                    if ($songs_array != '') {
                                        $song_count = count($songs_array);
                                        echo esc_html($song_count);
                                    } else {
                                        echo esc_html__('0', 'tdm');
                                    }

                                    ?>
                                </a>
                            </td>
                            <td class="author column-author" data-colname="Author">
                                <span>
                                    <?php
                                    $author_obj = get_user_by('id', $results->user_id);
                                    echo esc_html($author_obj->user_nicename);
                                    ?>
                                </span>
                            </td>
                            <td class="date column-date" data-colname="Date">
                                <?php echo esc_html($results->publish_date); ?>
                            </td>
                        </tr>
                    <?php
                    endforeach;
                else:
                    ?>
                    <!--    is empty playlist   -->
                    <tr id="playlist-empty"
                        class="iedit author-self level-0 post-empty type-post status-publish format-standard hentry">
                        <th scope="row" class="check-column"></th>
                        <td class="title column-title has-row-actions column-primary page-title"
                            data-colname="Title">
                            <strong>
                                <p>
                                   <?php echo esc_html__('No Item Found','tdm'); ?>
                                </p>
                            </strong>
                        </td>
                <?php
                endif;
                ?>
                </tbody>

                <tfoot>
                <tr>
                    <td class="manage-column column-cb check-column"><label class="screen-reader-text"
                                                                            for="cb-select-all-2">Select All</label>
                    </td>
                    <th scope="col" class="manage-column column-title column-primary sortable desc">
                        <a href="javascript:void(0)"><span>Title</span></a>
                    </th>
                    <th scope="col" id="shortcode" class="manage-column"><?php echo esc_html__('Shortcode') ?></th>
                    <th scope="col" class="manage-column column-author"><?php echo esc_html__('Number of songs') ?></th>
                    <th scope="col" class="manage-column column-author">
                        <span><?php echo esc_html__('Author', 'tdm'); ?></span>
                    </th>
                    <th scope="col" class="manage-column music-press-column-date">
                        <span><?php echo esc_html__('Date', 'tdm'); ?></span>
                    </th>
                </tr>
                </tfoot>

            </table>

        </form>

        <div id="ajax-response"></div>
        <br class="clear">
    </div>
    <?php
    return;
}

?>

<?php
function edit_playlist($id)
{
    global $wpdb;
    $table = $wpdb->prefix . 'music_press_quick_playlist';
    $playlist_values = "SELECT * FROM {$table} WHERE  id = $id";
    $playlist_results = $wpdb->get_results($playlist_values);
    foreach ($playlist_results as $results) {
        $current_name_playlist = $results->playlist_name;
        $songs_string = $results->song_ids;
        $songs_array = unserialize($songs_string);
    }

    ?>
    <div class="music-press-quick-playlist-wrap">
        <div class="nofication">

            <div class="nofication__added nofication__item">
                <p><?php echo esc_html__('Playlist Added', 'music-press-quick-playlist'); ?> <i
                            class="fa fa-check-circle" aria-hidden="true"></i></p>
                <div class="clear_nofication">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div>
            <div class="nofication__songisnull nofication__item">
                <p>
                    <?php echo esc_html__('error songs', 'music-press-quick-playlist'); ?>
                    <i class="fa fa-smile-o" aria-hidden="true"></i>
                </p>
                <div class="clear_nofication">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div>
        </div>
        <h3><?php echo esc_html__('Edit Playlist', '') ?></h3>
        <div id="titlewrap">
            <input type="text" name="playlist_title" size="30" value="<?php echo esc_attr($current_name_playlist); ?>"
                   id="playlist_title" spellcheck="true" autocomplete="off" placeholder="Enter title here">
        </div>
        <div id="filter">
            <select name="parent" id="genre" class="postform">
                <option selected>Genre</option>
                <?php
                $args = array(
                    'post_type' => 'mp_genre',
                    'post_status' => 'publish',
                    'order' => 'title',
                    'orderby' => 'DESC',
                    'posts_per_page' => '',
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                    ?>
                    <option class="level-0" value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
                <?php
                endwhile; endif;
                ?>
            </select>
            <select name="parent" id="album" class="postform">
                <option selected><?php echo esc_html__('Album', 'music-press-quick-playlist'); ?></option>
                <?php
                $args = array(
                    'post_type' => 'mp_album',
                    'post_status' => 'publish',
                    'order' => 'title',
                    'orderby' => 'DESC',
                    'posts_per_page' => '',
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                    ?>
                    <option class="level-0" value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
                <?php
                endwhile; endif;
                ?>
            </select>
            <select name="parent" id="artist" class="postform">
                <option selected><?php echo esc_html__('Artist', 'music-press-quick-playlist'); ?></option>
                <?php
                $args = array(
                    'post_type' => 'mp_artist',
                    'post_status' => 'publish',
                    'order' => 'title',
                    'orderby' => 'DESC',
                    'posts_per_page' => '',
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
                    ?>
                    <option class="level-0" value="<?php echo get_the_ID(); ?>"><?php the_title(); ?></option>
                <?php
                endwhile; endif;
                ?>
            </select>

            <select name="parent" id="order" class="postform">
                <option selected value="none"><?php echo esc_html__('Order', 'music-press-quick-playlist'); ?></option>
                <option class="level-0"
                        value="0"><?php echo esc_html__('DESC', 'music-press-quick-playlist'); ?></option>
                <option class="level-0"
                        value="1"><?php echo esc_html__('ASC', 'music-press-quick-playlist'); ?></option>
            </select>

            <select name="parent" id="orderby" class="postform">
                <option selected
                        value="none"><?php echo esc_html__('Order By', 'music-press-quick-playlist'); ?></option>
                <option class="level-0"
                        value="0"><?php echo esc_html__('Date', 'music-press-quick-playlist'); ?></option>
                <option class="level-0"
                        value="1"><?php echo esc_html__('Plays', 'music-press-quick-playlist'); ?></option>
            </select>

            <input type="text" name="playlist_title" size="30" value="" id="filter_limit" spellcheck="true"
                   autocomplete="off" placeholder="Limit">

            <button id="filter_songs" class="button button-primary button-large">
                <?php echo esc_html__('Filter', 'music-press-quick-playlist'); ?>
            </button>

        </div>
        <div id="contentwrap">
            <div class="leftcontent">
                <ul class="mp-list">
                    <?php
                    $query_args = array(
                        'post_type' => 'mp_song',
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => 1,
                        'order' => 'title',
                        'orderby' => 'DESC',
                        'posts_per_page' => '',
                        'post__not_in' => $songs_array,
                        'meta_query' => array(
                            array(
                                'key' => 'song_type',
                                'value' => 'audio'
                            )
                        ),
                    );
                    $songs = new WP_Query($query_args);
                    if ($songs->have_posts()) :
                        while ($songs->have_posts()) : $songs->the_post();
                            $songID = get_the_ID();
                            ?>

                            <li data-id="<?php echo get_the_ID(); ?>" class="playlist_item">
                                <?php the_title(); ?>
                            </li>

                        <?php
                        endwhile;
                        ?>
                    <?php endif;
                    ?>
                </ul>
                <div id="replace_playlist" data-replace-id="<?php echo esc_attr($results->id); ?>">
                    <span class="spinner"></span>
                    <input name="original_publish" type="hidden" id="original_publish" value="Publish">
                    <input type="submit" name="publish" id="publish" class="button button-primary button-large"
                           value="Update">
                </div>
            </div>

            <div class="centercontent">
                <button id="send_data" class="button button-primary button-large">
                    <?php echo esc_html__('Add your Playlist') ?>
                </button>
            </div>

            <div class="rightcontent">
                <ul class="mp-listed" id="list-added">
                    <?php
                    if (isset($songs_array) && $songs_array != ''):
                        foreach ($songs_array as $array):
                            ?>
                            <li data-id="<?php echo $array; ?>" class="playlist_item">
                                <?php echo get_the_title($array); ?>
                            </li>
                        <?php
                        endforeach;
                    endif
                    ?>
                </ul>
                <div class="remove_songids">
                    <button id="clear_data" class="button button-primary button-large">
                        <?php echo esc_html__('Clear item selected', 'music-press-quick-playlist') ?>
                    </button>
                    <button id="clear_all" class="button button-primary button-large">
                        <?php echo esc_html__('Clear All', 'music-press-quick-playlist') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php
    return;
}