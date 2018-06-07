<?php
?>
<div class="music-press-quick-playlist-wrap">
    <div class="nofication">

        <div class="nofication__added nofication__item">
            <p><?php echo esc_html__('Playlist Added', 'music-press-quick-playlist'); ?> <i class="fa fa-check-circle"
                                                                                            aria-hidden="true"></i></p>
            <div class="clear_nofication">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
        </div>
        <div class="nofication__songisnull nofication__item">
            <p><?php echo esc_html__('error songs', 'music-press-quick-playlist'); ?><i class="fa fa-smile-o"
                                                                                        aria-hidden="true"></i></p>
            <div class="clear_nofication">
                <i class="fa fa-times" aria-hidden="true"></i>
            </div>
        </div>
    </div>
    <h3><?php echo esc_html__('Add New Playlist', '') ?></h3>
    <div id="titlewrap">
        <input type="text" name="playlist_title" size="30" value="" id="playlist_title" spellcheck="true"
               autocomplete="off" placeholder="Enter title here">
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
            <option class="level-0" value="0"><?php echo esc_html__('DESC', 'music-press-quick-playlist'); ?></option>
            <option class="level-0" value="1"><?php echo esc_html__('ASC', 'music-press-quick-playlist'); ?></option>
        </select>

        <select name="parent" id="orderby" class="postform">
            <option selected value="none"><?php echo esc_html__('Order By', 'music-press-quick-playlist'); ?></option>
            <option class="level-0" value="0"><?php echo esc_html__('Date', 'music-press-quick-playlist'); ?></option>
            <option class="level-0" value="1"><?php echo esc_html__('Plays', 'music-press-quick-playlist'); ?></option>
        </select>

        <input type="text" name="playlist_title" size="30" value="" id="filter_limit" spellcheck="true"
               autocomplete="off" placeholder="Limit">

        <button id="filter_songs" class="button button-primary button-large">
            <?php echo esc_html__('Filter', 'music-press-quick-playlist'); ?>
        </button>

    </div>
    <div id="searchfield">
        <h3 class="sbsn"><?php echo esc_html__('Search by song name:','tdm'); ?></h3>
        <form>
            <input type="text" name="songautocomplete" class="biginput" id="autocomplete">
        </form>
    </div><!-- @end #searchfield -->
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
                );
                $songs = new WP_Query($query_args);
                if ($songs->have_posts()) : ?>

                    <?php
                    while ($songs->have_posts()) : $songs->the_post();
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
            <div id="msqp-publishing-action">
                <span class="spinner"></span>
                <input name="original_publish" type="hidden" id="original_publish" value="Publish">
                <input type="submit" name="publish" id="publish" class="button button-primary button-large"
                       value="Publish">
            </div>
        </div>

        <div class="centercontent">
            <button id="send_data" class="button button-primary button-large">
                <?php echo esc_html__('Add your Playlist') ?>
            </button>
        </div>

        <div class="rightcontent">
            <ul class="mp-listed" id="list-added">
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
<script>

    $(function () {

        function duplicatedataid() {
            $('att').each(function (i) {
                $('[id="' + this.id + '"]').slice(1).remove();
            });
        }
        var songarray = [
            // list songs
            <?php
            $query_args = array(
                'post_type' => 'mp_song',
                'post_status' => 'publish',
                'ignore_sticky_posts' => 1,
                'order' => 'title',
                'orderby' => 'DESC',
                'posts_per_page' => '',
            );
            $songs = new WP_Query($query_args);
            if ($songs->have_posts()) : ?>

            <?php
            while ($songs->have_posts()) : $songs->the_post();
            ?>
            {value: '<?php the_title(); ?>', data: '<?php the_ID(); ?>'},
            <?php
            endwhile;
            endif
            ?>
        ];
        $('#autocomplete').autocomplete({
            lookup: songarray,
            onSelect: function (suggestion) {
                var thehtml = '<li data-id="' + suggestion.data + '" class="playlist_item">' + suggestion.value + '</li>';
                $('#list-added').append(thehtml);
                $('#searchfield input').val('');
            }
        });

    });
</script>

