<?php

if ( ! defined('ABSPATH')) exit;  // if direct access 


class class_music_quick_playlist_functions{
	
	public function __construct() {

		//add_action('add_meta_boxes', array($this, 'meta_boxes_question'));
		//add_action('save_post', array($this, 'meta_boxes_question_save'));

	}

	public function profile_navs(){


		if(isset($_GET['id'])){
			
			$user_id = sanitize_text_field($_GET['id']);
			//var_dump($user_id);
			}
		else{
			
			$user_id = get_current_user_id(); 
			}

//		$navs['post'] = array(
//							'title'=>__('Post', 'music-press-member'),
//							'html'=>apply_filters('music_quick_playlist_filter_profile_navs_post', $this->music_quick_playlist_filter_profile_navs_post($user_id)),
//							);
							
		$navs['about'] = array(
							'title'=>__('My Account', 'music-press-member'),
							'html'=>apply_filters('music_quick_playlist_filter_profile_navs_about', $this->music_quick_playlist_filter_profile_navs_about($user_id)),	
							);

		$navs['wishlist'] = array(
							'title'=>__('wishlist', 'music-press-member'),
							'html'=>apply_filters('music_quick_playlist_filter_profile_navs_wishlist', $this->music_quick_playlist_filter_profile_navs_wishlist($user_id)),
							);
							
		$navs['following'] = array(
							'title'=>__('Following', 'music-press-member'),
							'html'=>apply_filters('music_quick_playlist_filter_profile_navs_following', $this->music_quick_playlist_filter_profile_navs_following($user_id)),	
							);
		$navs = apply_filters('music_quick_playlist_filter_profile_navs', $navs);		

		return $navs;

		}		
	
	
	function music_quick_playlist_filter_profile_navs_post($user_id){
		ob_start();
		
		$posts_per_page = get_option('posts_per_page');
		
		//echo $user_id;
		
		if ( get_query_var('paged') ) {
		
			$paged = get_query_var('paged');
		
		} elseif ( get_query_var('page') ) {
		
			$paged = get_query_var('page');
		
		} else {
		
			$paged = 1;
		}
		

		$wp_query = new WP_Query(
			array (
				'post_type' => 'post',
				'orderby' => 'date',
				'order' => 'DESC',
				'author' => $user_id,
				'posts_per_page' => $posts_per_page,
				'paged' => $paged,
				
				) );
				
		
		?>
        <div class="user-posts">
        <?php
			
		if ( $wp_query->have_posts() ) :
		while ( $wp_query->have_posts() ) : $wp_query->the_post();
		
		?>
        	<div class="single">
            
            	<div class="title"><a href="<?php echo get_permalink(); ?>"><?php echo the_title(); ?></a></div>
            	<div class="excerpt"><?php echo get_the_excerpt(); ?></div>
            	<div class="date"><?php echo the_date(); ?></div>                
                             
            </div>
        <?php
			
		endwhile;
		
		//echo '</table>'; 
		?>
        <div class="paginate">
        <?php
		$big = 999999999; // need an unlikely integer
		echo paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, $paged ),
			'total' => $wp_query->max_num_pages
			) );
		?>
        </div>
        <?php


		wp_reset_query();
		
		else:
		?>
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <?php echo __('No post found.'); ?>
        <?php		
	
		
		endif;
			
			
		?>
		
        </div>
        
        
        <?php
		
		return ob_get_clean();
		}
	
	function music_quick_playlist_filter_profile_navs_about($user_id){
		ob_start();
		$class_music_quick_playlist_functions = new class_music_quick_playlist_functions();
		$contact_methods = $class_music_quick_playlist_functions->contact_methods();
		$user_gender = $class_music_quick_playlist_functions->user_gender();
		$user_relationship = $class_music_quick_playlist_functions->user_relationship();
		$user_data = get_userdata($user_id);

		$music_quick_playlist_basic_info = get_the_author_meta( 'music_quick_playlist_basic_info', $user_id );
		
		if(!empty($music_quick_playlist_basic_info['birth_date'])){
			$birth_date= $music_quick_playlist_basic_info['birth_date'];
			$birth_date = new DateTime($birth_date);
			$birth_date = $birth_date->format('d M, Y');
			}
		else{
			$birth_date = '';
			}
		
		if(!empty( $music_quick_playlist_basic_info['gender'])){
			$gender= $music_quick_playlist_basic_info['gender'];
			}
		else{
			$gender= '';
			}
		
		if(!empty( $music_quick_playlist_basic_info['relationship'])){
			$relationship= $music_quick_playlist_basic_info['relationship'];
			}
		else{
			$relationship= '';
			}
		
		if(!empty( $music_quick_playlist_basic_info['website'])){
			$website= $music_quick_playlist_basic_info['website'];
			}
		else{
			$website= '';
			}

		if(!empty( $music_quick_playlist_basic_info['introduce'])){
			$introduce= $music_quick_playlist_basic_info['introduce'];
			}
		else{
			$introduce= '';
			}
		
		$music_quick_playlist_contacts = get_the_author_meta( 'music_quick_playlist_contacts', $user_id );			
		$music_quick_playlist_work = get_the_author_meta( 'music_quick_playlist_work', $user_id );	
		$music_quick_playlist_education = get_the_author_meta( 'music_quick_playlist_education', $user_id );
		$music_quick_playlist_places = get_the_author_meta( 'music_quick_playlist_places', $user_id );

		if(!empty($user_gender[$gender])){
			
			$gender_info = $user_gender[$gender];
			$gender_title = $gender_info['title'];
			
			}

		if(!empty($user_relationship[$relationship])){
			
			$relationship_info = $user_relationship[$relationship];
			$relationship_title = $relationship_info['title'];	
			
			}

		?>
		<div class="basic-info">
        	<div class="container">
            
                <h5 class=""><?php echo __('My Account:', 'music-press-member'); ?></h5>
                
                <?php do_action('music_quick_playlist_action_before_basic_info'); ?>
                
 				<?php
                if(!empty($gender_title)):
				?>
                <div class="item gender">
                    <span class=""><?php echo __('Gender:', 'music-press-member'); ?> </span><span class=""><?php echo $gender_title; ?></span>
                </div> 
                <?php
                endif;
                if(!empty($relationship_title)):
				?>
                <div class="item relationship">
               	 <span class=""><?php echo __('Relationship:', 'music-press-member'); ?> </span><span class=""><?php echo $relationship_title; ?></span>
                </div>
                <?php
                endif;
				?>
                
                <div class="item username">
                	<label class=""><?php echo __('User Name', 'music-press-member'); ?> </label><span class=""><?php echo $user_data->user_login; ?></span>
                </div>

                <div class="item display_name">
                	<label class=""><?php echo __('Display Name', 'music-press-member'); ?> </label><span class=""><?php echo $user_data->display_name; ?></span>
                </div>
                
                <div class="item birth_date">
                	<span class=""><?php echo __('Birth date:', 'music-press-member'); ?> </span><span class=""><?php echo $birth_date; ?></span>
                </div>
                
                <div class="item website">
                	<span class=""><?php echo __('Website:', 'music-press-member'); ?> </span><span class=""><a href="<?php echo $website; ?>"><?php echo $website; ?></a></span>
                </div>

                <div class="item introduce">
                	<span class=""><?php echo __('Introduce:', 'music-press-member'); ?> </span>
                    <p class=""><?php echo $introduce; ?></p>
                </div>
                
                <?php do_action('music_quick_playlist_action_after_basic_info'); ?>
            
            </div>
            
            <div class="container">
            	
               <h5 class=""><?php echo __('Contacts', 'music-press-member'); ?></h5>
                <div class="contact-list">
                <?php
                if(!empty($music_quick_playlist_contacts))
				foreach($music_quick_playlist_contacts as $contacts){
					
					$username = $contacts['username'];
					$profile_link = $contacts['profile_link'];
					$network = $contacts['network'];
					foreach($contact_methods as $index=>$methods){
						
						$title = $methods['title'];
						$icon = $methods['icon'];
						$bg_color = $methods['bg_color'];
						
						if($network==$index && !empty($profile_link)){
							
							?><a style=" background-color:<?php echo $bg_color; ?>" class="item <?php echo $network; ?>" href="<?php echo $profile_link; ?>"><?php //echo $username; ?><?php echo $icon; ?></a><?php
							}
						
						}
					
					}
				
				
				?>
                </div>
            </div>
        
        </div>
        <?php
		return ob_get_clean();
		
		}
	
	
	function music_quick_playlist_filter_profile_navs_following($user_id)
    {
        ob_start();

        $music_quick_playlist_page_id = get_option('music_quick_playlist_page_id');
        $music_quick_playlist_page_url = get_permalink($music_quick_playlist_page_id);
        $total_following = (int)get_the_author_meta('total_following', $user_id);

        global $wpdb;
        $table = $wpdb->prefix . "music_quick_playlist_follow";
        $pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
        $limit = 10;
        $offset = ($pagenum - 1) * $limit;
        $follower_query = $wpdb->get_results("SELECT artist_id FROM $table WHERE follower_id = '$user_id' ORDER BY id DESC LIMIT $offset, $limit",ARRAY_A);
        $logged_user_id = get_current_user_id();

        if (!empty($total_following)):
            ?>
            <div class="tottal-following">
                <?php echo sprintf(__('Total following: %s', 'music-press-member'), $total_following); ?>
            </div>
            <?php
        endif;
        ?>

        <div class="follower-list">

            <?php

            $count = 1;

            if (!empty($follower_query)):
                foreach ($follower_query as $entry) {

                    $follower_id = $entry->follower_id;
                    $artist_id = $entry['artist_id'];
                    $datetime = $entry->datetime;

                    $music_quick_playlist_cover_id = get_field('artist_banner', $artist_id);

                    if (empty($music_quick_playlist_cover_id)) {

                        $music_quick_playlist_cover = music_quick_playlist_PLUGIN_URL . 'assets/front/images/cover.png';
                        $music_quick_playlist_cover = '<img src="' . $music_quick_playlist_cover . '" />';
                    } else {
                        $music_quick_playlist_cover = wp_get_attachment_url($music_quick_playlist_cover_id);
                        $music_quick_playlist_cover = '<img src="' . $music_quick_playlist_cover . '" />';
                        //$music_quick_playlist_cover = apply_filters('music_quick_playlist_filter_profile_cover', $music_quick_playlist_cover);
                    }
                    $follow_result = $wpdb->get_results("SELECT * FROM $table WHERE artist_id = '$artist_id' AND follower_id = '$logged_user_id'", ARRAY_A);
                    $artist_url = get_permalink($artist_id);
                    ?>
                    <div class="single">
                    <div class="cover"><a
                                href="<?php echo $artist_url; ?>"><?php echo $music_quick_playlist_cover; ?></a>
                    </div>
                    <div class="thumb"><a
                                href="<?php echo $artist_url; ?>"><?php  echo get_the_post_thumbnail( $artist_id, 'thumbnail'); ?></a>
                    </div>
                    <div class="name"><?php echo get_the_title($artist_id); ?></div>
                    <div artist_id="<?php echo $artist_id; ?>"
                         class="follow following"><?php echo esc_html_e('Following','music-press-member'); ?></div>
                    </div><?php

                    $count++;
                }
            else:
                echo esc_html_e('Nothing found.','music-press-member');
            endif;


            $total = $wpdb->get_var("SELECT COUNT(`id`) FROM $table WHERE author_id = '$user_id'");
            $num_of_pages = ceil($total / $limit);
            $page_links = paginate_links(array(
                'base' => add_query_arg('pagenum', '%#%'),
                'format' => '',
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
                'total' => $num_of_pages,
                'current' => $pagenum
            ));

            if ($page_links) {
                echo '<div class="paginate">' . $page_links . '</div>';
            }
            ?>
        </div>
        <?php
        return ob_get_clean();

    }
	
	function music_quick_playlist_filter_profile_navs_wishlist($user_id){
        ob_start();

        $music_quick_playlist_page_id = get_option('music_quick_playlist_page_id');
        $music_quick_playlist_page_url = get_permalink($music_quick_playlist_page_id);
        $total_following = (int)get_the_author_meta('total_following', $user_id);

        global $wpdb;
        $table = $wpdb->prefix . "music_quick_playlist_wishlist";
        $pagenum = isset($_GET['pagenum']) ? absint($_GET['pagenum']) : 1;
        $limit = 10;
        $offset = ($pagenum - 1) * $limit;
        $follower_query = $wpdb->get_results("SELECT song_id FROM $table WHERE member_id = '$user_id' ORDER BY id DESC LIMIT $offset, $limit",ARRAY_A);
        $logged_user_id = get_current_user_id();

        ?>

        <div class="wishlist-list">

            <?php

            $count = 1;

            if (!empty($follower_query)):
                foreach ($follower_query as $entry) {
                    $song_id = $entry['song_id'];

                    $song_url = get_permalink($song_id);
                    ?>
                    <div class="song_item_wishlist">
                    <a href="<?php echo $song_url; ?>"><?php echo get_the_title($song_id); ?></a>
                    </div><?php
                    $count++;
                }
            else:
                echo esc_html_e('Nothing found.','music-press-member');
            endif;


            $total = $wpdb->get_var("SELECT COUNT(`id`) FROM $table WHERE member_id = '$user_id'");
            $num_of_pages = ceil($total / $limit);
            $page_links = paginate_links(array(
                'base' => add_query_arg('pagenum', '%#%'),
                'format' => '',
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',
                'total' => $num_of_pages,
                'current' => $pagenum
            ));

            if ($page_links) {
                echo '<div class="paginate">' . $page_links . '</div>';
            }
            ?>
        </div>
        <?php
        return ob_get_clean();
		
		}
	
	
	public function contact_methods() {
		
		
		$methods['facebook'] = array(
									'title'=>'Facebook',
									'icon'=>'<i class="fa fa-facebook"></i>',
									'bg_color'=>'#4968aa',
									
									);
									
		$methods['twitter'] = array(
									'title'=>'Twitter',
									'icon'=>'<i class="fa fa-twitter" aria-hidden="true"></i>',
									'bg_color'=>'#55acee',
									
									);									
									
		$methods['google_plus'] = array(
									'title'=>'Google+',
									'icon'=>'<i class="fa fa-google-plus-official" aria-hidden="true"></i>',
									'bg_color'=>'#e7463a',
									
									);									
									
		$methods['linkedin'] = array(
									'title'=>'Linkedin',
									'icon'=>'<i class="fa fa-linkedin" aria-hidden="true"></i>',
									'bg_color'=>'#55acee',
									
									);									
									
		$methods['pinterest'] = array(
									'title'=>'Pinterest',
									'icon'=>'<i class="fa fa-pinterest-p" aria-hidden="true"></i>',
									'bg_color'=>'#cb1f26',
									
									);	
									
		$methods['youtube'] = array(
									'title'=>'Youtube',
									'icon'=>'<i class="fa fa-youtube-play" aria-hidden="true"></i>',
									'bg_color'=>'#cc181e',
									
									);											
		
		
		return apply_filters('music_quick_playlist_contact_methods', $methods);
		
		}	
	
	
	
	public function user_gender() {
		
		
		$gender['male'] = array(
									'title'=>__('Male', 'music-press-member'),
									'icon'=>'<i class="fa fa-male"></i>',

									
									);
									
		$gender['female'] = array(
									'title'=>__('Female', 'music-press-member'),
									'icon'=>'<i class="fa fa-female" aria-hidden="true"></i>',
									);									
									
		$gender['others'] = array(
									'title'=>__('Others', 'music-press-member'),
									'icon'=>'<i class="fa fa-google-plus-official" aria-hidden="true"></i>',

									
									);									
									
											
		
		
		return apply_filters('music_quick_playlist_user_gender', $gender);
		
		}	
	
	
	public function user_relationship() {
		
		
		$relations['single'] = array(
									'title'=>__('Single', 'music-press-member'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);
									
		$relations['engaged'] = array(
									'title'=>__('Engaged', 'music-press-member'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);
									
		$relations['in_relationship'] = array(
									'title'=>__('In a relationship', 'music-press-member'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);
								
		$relations['married'] = array(
									'title'=>__('Married', 'music-press-member'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);								
								
		$relations['separated'] = array(
									'title'=>__('Separated', 'music-press-member'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);								
								
		$relations['divorced'] = array(
									'title'=>__('Divorced', 'music-press-member'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);								
		$relations['widowed'] = array(
									'title'=>__('Widowed', 'music-press-member'),
									'icon'=>'<i class="fa fa-facebook"></i>',
									);									
											
		
		
		return apply_filters('music_quick_playlist_user_relationship', $relations);
		
		}		
	
	
	
	
	
	
	
	
	
	public function get_pages_list(){
		$array_pages[''] = __('None', 'music-press-member');
		
		foreach( get_pages() as $page )
		if ( $page->post_title ) $array_pages[$page->ID] = $page->post_title;
		
		return $array_pages;
	}
	

} new class_music_quick_playlist_functions();