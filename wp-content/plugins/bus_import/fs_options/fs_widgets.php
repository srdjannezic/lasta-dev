<?php

if (class_exists ('WP_Widget'))
{
	//////////////////////////////////
	// AKTUELNO
	//////////////////////////////////
	class WP_Widget_AKTUELNO extends WP_Widget
	{
		function WP_Widget_AKTUELNO ()
		{
			$this->WP_Widget ('aktielnosti', 'Aktuelnosti', $widget_ops);
		}
		
		function update ($new_instance, $old_instance)
		{
			return $new_instance;
		}
		
		function form ($instance)
		{			
			$cat = esc_attr($instance['cat']);
			$cat_name = $this->get_field_name('cat');
			$cat_id = $this->get_field_id('cat');
	?>
			<p>Choose news category</p>
			<?php
			$args = array(
			'orderby'            => 'name', 
			'order'              => 'ASC',
			'selected'           => $cat,
			'name'               => $cat_name,
			'id'                 => $cat_id,
			'taxonomy'           => 'category',
			);
			wp_dropdown_categories($args);
		}
		
		function widget($function_args, $instance)
		{
			extract($function_args);
			
			echo $before_widget;
			?>
			<div class="widget_title_wrapper"><div class="widget_title">Aktuelnosti</div></div>
            <div class="widget_padding">
			<?php
			$total_news = 6;
			$args = array(
				'cat'				=> $instance['cat'],
				'orderby'			=> 'date',
				'order'				=> 'DESC',
				'posts_per_page'	=> $total_news
			);
			query_posts($args);
			// The Loop
			$count = 1;
			echo '<ul class="activity_title">';
			while ( have_posts() ) : the_post();
				$url = get_permalink();
				if(has_post_thumbnail() && $count == 1) {
				?>
				<a href="<?php echo $url; ?>"><?php the_post_thumbnail('widget_activities'); ?></a>
				<?php
				}
				echo '<li' . (($total_news == $count) ? ' class="last_activity_title"' : '') . '>';
				echo '<a href="' . $url . '">' . get_the_title() . '</a>';
				echo '</li>';
                $count++;
			endwhile;
			echo '</ul>';
            echo '<hr/><a style="font-size: 12px; display: block; margin-bottom: 5px;" href="' . get_bloginfo('url') . '/category/vesti/">Arhiva vesti</a>';
			
			// Reset Query
			wp_reset_query();
			echo '</div>';
			echo $after_widget;		
		}
	}
	//////////////////////////////////
	// TEXT WIDGET
	//////////////////////////////////
	class WP_Widget_CUSTOM_TEXT_LASTA extends WP_Widget
	{
		function WP_Widget_CUSTOM_TEXT_LASTA ()
		{
			$this->WP_Widget ('custom_text_lasta', 'Text', $widget_ops);
		}
		
		function update ($new_instance, $old_instance)
		{
			return $new_instance;
		}
		
		function form ($instance)
		{			
			$title = esc_attr($instance['title']);
			$text = esc_attr($instance['text']);
			$title_name = $this->get_field_name('title');
			$title_id = $this->get_field_id('title');
			$text_name = $this->get_field_name('text');
			$text_id = $this->get_field_id('text');
	?>
			<p>Choose news category</p>
            <input type="text" name="<?php echo $title_name; ?>" id="<?php echo $title_id; ?>" value="<?php echo $instance['title']; ?>" />
            <textarea style="width: 225px; height: 200px;" name="<?php echo $text_name; ?>" id="<?php echo $text_id; ?>" /><?php echo $instance['text']; ?></textarea>
            <?php
		}
		
		function widget($function_args, $instance)
		{
			extract($function_args);
			
			echo $before_widget;
			?>
			<div class="widget_title_wrapper"><div class="widget_title"><?php echo $instance['title']; ?></div></div>
            <div class="widget_padding"><div class="custom_text_desc"><?php echo $instance['text']; ?></div></div>
            <?php
			echo $after_widget;		
		}
	}
	//////////////////////////////////
	// CUSTOM MENU
	//////////////////////////////////
	class WP_Widget_CUSTOM_MENU extends WP_Widget
	{
		function WP_Widget_CUSTOM_MENU ()
		{
			$this->WP_Widget ('custom_menu_lasta', 'Menu', $widget_ops);
		}
		
		function update ($new_instance, $old_instance)
		{
			return $new_instance;
		}
		
		function form ($instance)
		{			
			$menu_var = esc_attr($instance['menu_var']);
			$menu_name = $this->get_field_name('menu_var');
			$menu_id = $this->get_field_id('menu_var');
			$menus = get_terms('nav_menu', array('hide_empty' => true ));
			echo '<p>Select a menu: </p>';
			echo '<select name="' . $menu_name . '" id="' . $menu_id . '">';
			foreach($menus as $menu_v) {
				echo '<option value="' . $menu_v->name . '"' . (($menu_var == $menu_v->name) ? 'selected="selected"' : '') . '>' . $menu_v->name . '</option>';
			}
			echo '</select>';
		}
		
		function widget($function_args, $instance)
		{
			extract($function_args);
			
			echo '<li class="widget widget_sub_nav">';
			$menu_options = array(
				'depth' => '1',
				'menu_id'   => 'sub_nav2',
				'menu' => $instance['menu_var'],
			);
			wp_nav_menu($menu_options);
			echo $after_widget;		
		}
	}
	//////////////////////////////////
	// CUSTOM IMAGE
	//////////////////////////////////
	class WP_Widget_CUSTOM_IMAGE_LASTA extends WP_Widget
	{
		function WP_Widget_CUSTOM_IMAGE_LASTA ()
		{
			$this->WP_Widget ('custom_image_lasta', 'Image', $widget_ops);
		}
		
		function update ($new_instance, $old_instance)
		{
			return $new_instance;
		}
		
		function form ($instance)
		{
			$link = esc_attr($instance['link']);
			$link_name = $this->get_field_name('link');
			$link_id = $this->get_field_id('link');
			$img_name = $this->get_field_name('img' . $i);
			$img_id = $this->get_field_id('img' . $i);
			
			echo '<p>Choose news category</p>';
			?>
			<input type="text" name="<?php echo $link_name; ?>" id="<?php echo $link_id; ?>" value="<?php echo $instance['link']; ?>" />
			<?php
			echo '<p>Select image:</p>';
			global $wpdb;
			$pictures = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status != 'trash' AND (post_mime_type = 'image/jpeg'
						 OR post_mime_type = 'image/gif' OR post_mime_type = 'image/png')"));
			echo '<select name="' . $img_name . '" id="' . $img_id . '">';
			echo '<option value="none"' . (($picture->ID == esc_attr($instance['img' . $i])) ? ' selected="selected"' : '') . '>none</option>';
			foreach($pictures as $picture)
			{
				$the_img = wp_get_attachment_image_src( $picture->ID,"full" );
				$the_img_link = $the_img[0];
				echo '<option value="' . $picture->ID . '"' . (($picture->ID == esc_attr($instance['img' . $i])) ? ' selected="selected"' : '') . '>' . $picture->post_title . '</option>';
				}
			echo '</select>';
		}
		
		function widget($function_args, $instance)
		{
			extract($function_args);
			
			echo $before_widget;
			if($instance['link'] != '') {
				echo '<a class="custom_widget_image" href="' . $instance['link'] . '">' . wp_get_attachment_image($instance['img' . $i], 'widget_custom_image') . '</a>';
			} else {
				echo wp_get_attachment_image($instance['img' . $i], 'widget_custom_image');
			}
			echo $after_widget;		
		}
	}
	//////////////////////////////////
	// SUB NAV
	//////////////////////////////////
	class WP_Widget_LASTA_SUB_NAV extends WP_Widget
	{
		function WP_Widget_LASTA_SUB_NAV ()
		{
			$this->WP_Widget ('lasta_sub_nav', 'Sub Menu', $widget_ops);
		}
		
		function update ($new_instance, $old_instance)
		{
			return $new_instance;
		}
		
		function form ($instance)
		{
			echo 'no options';
		}
		
		function widget($function_args, $instance)
		{
			extract($function_args);
			
			echo '<li class="widget widget_sub_nav">';
			$menu_options = array(
				'depth' => '2',
				'menu_id'   => 'sub_nav',
				'theme_location' => 'primary-menu',
			);
			wp_nav_menu($menu_options);
			echo $after_widget;		
		}
	}
	//////////////////////////////////
	// SEARCH LASTA
	//////////////////////////////////
	class WP_Widget_SEARCH_LASTA extends WP_Widget
	{
		function WP_Widget_SEARCH_LASTA ()
		{
			$this->WP_Widget ('search_lasta', 'Search', $widget_ops);
		}
		
		function update ($new_instance, $old_instance)
		{
			return $new_instance;
		}
		
		function form ($instance)
		{
			$domestic = esc_attr($instance['domestic']);
			$international = esc_attr($instance['international']);
			$season = esc_attr($instance['season']);
			$domestic_name = $this->get_field_name('domestic');
			$domestic_id = $this->get_field_name('domestic');
			$international_name = $this->get_field_name('international');
			$international_id = $this->get_field_name('international');
			$season_name = $this->get_field_name('season');
			$season_id = $this->get_field_name('season');?>
			<p>Choose what is visible:</p>
            <label for="<?php echo $domestic_name; ?>"><input type="checkbox" name="<?php echo $domestic_name; ?>" id="<?php echo $domestic_id; ?>" <?php if($domestic) { echo 'checked="checked"'; } ?> /> - Domestic</label><br />
            <label for="<?php echo $international_name; ?>"><input type="checkbox" name="<?php echo $international_name; ?>" id="<?php echo $international_id; ?>" <?php if($international) { echo 'checked="checked"'; } ?> /> - International</label><br />
            <label for="<?php echo $season_name; ?>"><input type="checkbox" name="<?php echo $season_name; ?>" id="<?php echo $season_id; ?>" <?php if($season) { echo 'checked="checked"'; } ?> /> - Season</label>
            <?php
		}
		
		function widget($function_args, $instance)
		{
			extract($function_args);
			global $wpdb;
			$domestic_1 = $_GET['f'];
			$domestic_2 = $_GET['t'];
			$international_1 = $_GET['if'];
			$international_2 = $_GET['it'];
			$season_get = $_GET['sef'];
			$domestic_cities = $wpdb->get_results( "SELECT id, naziv FROM lb1706wp_lasta_grad WHERE domaci = 1 ORDER BY naziv");
			foreach($domestic_cities as $domestic_city) 
			{
				$cities_var1 .= '<option value="' . $domestic_city->id . '"' . (($domestic_1 == $domestic_city->id) ? 'selected="selected"' : '') . '>' . $domestic_city->naziv . '</option>';
				$cities_var2 .= '<option value="' . $domestic_city->id . '"' . (($domestic_2 == $domestic_city->id) ? 'selected="selected"' : '') . '>' . $domestic_city->naziv . '</option>';
			}
			$internationals = $wpdb->get_results( "SELECT id, naziv FROM lb1706wp_lasta_grad WHERE medjunarodni = 1 ORDER BY naziv");
			foreach($internationals as $international) 
			{
				$international_var1 .= '<option value="' . $international->id . '"' . (($international_1 == $international->id) ? 'selected="selected"' : '') . '>' . $international->naziv . '</option>';
				$international_var2 .= '<option value="' . $international->id . '"' . (($international_2 == $international->id) ? 'selected="selected"' : '') . '>' . $international->naziv . '</option>';
			}
			$seasonal = $wpdb->get_results( "SELECT id, naziv FROM lb1706wp_lasta_grad WHERE sezonski = 1 ORDER BY naziv");
			foreach($seasonal as $season) 
			{
				$season_var .= '<option value="' . $season->id . '"' . (($season_get == $season->id) ? 'selected="selected"' : '') . '>' . $season->naziv . '</option>';
			}
			echo $before_widget;
			?>
			<div class="widget_title_wrapper"><div class="widget_title2">Redovi vožnje</div></div>
            <div class="widget_padding2">
            	<div class="j_tab_wrapper">
                    <div class="search_tabs_wrapper">
                        <ul class="search_tabs j_tab_tabs">
                            <?php if($instance['domestic']) { ?><li <?php echo (isset($_GET["f"]) || (!isset($_GET["if"]) && !isset($_GET["sef"]) && !isset($_GET['f']))) ? "class='active'" : "" ;?>>Domaći</li><?php } ?>
                            <?php if($instance['international']) { ?><li <?php echo (isset($_GET['if'])) ? "class='active'": '';?>>Međunarodni</li><?php } ?>
                            <?php if($instance['season']) { ?><li <?php echo (isset($_GET['sef'])) ? "class='active'": '';?>>Sezonski</li><?php } ?>
                        </ul>
                    </div>
                    <div class="clear"></div>
                    <ul class="search_content j_tab_content">
                        <!-------------------------- DOMESTIC SEARCH FORM ------------------------------->
                        <li <?php echo (isset($_GET["f"]) || (!isset($_GET["if"]) && !isset($_GET["sef"]) && !isset($_GET['f']))) ? "class='active'" : "" ;?>>
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="30" height="25" valign="top" class="search_desc">OD:</td>
                                    <td valign="top" style="padding-left: 5px;">
                                        <select name="domestic" id="domestic_1" class="search_select j_domestic_dd1">
                                            <option value="">Izaberite grad</option>
                                            <?php echo $cities_var1; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr style="border-bottom: solid 1px #ccc;">
                                    <td width="30" height="25" valign="top" class="search_desc">DO:</td>
                                    <td valign="top" style="padding-left: 5px;"> 
                                    	<div class="j_domestic_dd2_holder" <?php echo ((isset($_GET["f"]) || (!isset($_GET["if"]) && !isset($_GET["sef"]) && isset($_GET["f"])))) ? '' : "style='display:none;'"  ;?>>
                                            <select name="domestic" id="domestic_2" class="search_select j_domestic_dd2">
                                                <option value="">Izaberite grad</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                	<td colspan="3">
                                    	<div class="adv_hidden">uključi datum i vreme</div>
                                    	<table cellpadding="0" cellspacing="0" class="domestic_adv_hidden">
                                            <tr>
                                                <td valign="top" colspan="3" style="border-bottom: solid 1px #ccc; padding: 5px 0 5px 5px;">
                                                    <div id="datepicker"></div>
                                                    <input type="hidden" class="j_date_selected" value="<?php echo (isset($_GET['date'])) ? $_GET['date'] : $curr_date;?>" />
                                                </td>
                                            </tr>
                                            <tr style="border-bottom: solid 1px #ccc;">
                                                <td valign="top" colspan="2" style="padding: 5px 0;">
                                                    <label>
                                                        Vreme polaska:
                                                        <select name="time" class="j_time">
                                                           <option value=""> CEO DAN </option><?php 
                                                            for ($i=1;$i<=24;$i++)
                                                                {?>
                                                                    <option value="<?php echo $i;?>" <?php echo (isset($_GET['time']) && $_GET['time'] == $i) ? "selected='selected'": '';?>><?php echo $i;?> : 00 h</option><?php 
                                                                }?>
                                                        </select>
                                                    </label>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
									<td colspan="2" align="center" style="padding: 10px 0 0 0;">
                                        <input type="button" class="form_button j_submit_domestic_form" value="Traži"/>
									</td>
                                </tr>
                            </table>
                        </li>
                        <!-------------------- INTERNATIONAL SEARCH FORM --------------------------------->
                        <li <?php echo (isset($_GET['if'])) ? "class='active'": '';?>>
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="30" height="25" valign="top" class="search_desc">OD:</td>
                                    <td valign="top" style="padding-left: 5px;">
                                        <select name="international" id="international_1" class="search_select j_international_dd1">
                                            <option value="">Izaberite mesto</option>
                                            <?php echo $international_var1; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr style="border-bottom: solid 1px #ccc;">
                                    <td width="30" height="25" valign="top" class="search_desc">DO:</td>
                                    <td valign="top" style="padding-left: 5px;"> 
                                    	<div class="j_international_dd2_holder" <?php echo ((isset($_GET["if"]))) ? '' : "style='display:none;'"  ;?>>
                                            <select name="international" id="international_2" class="search_select j_international_dd2">
                                                <option value="">Izaberite mesto</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
									<td colspan="2" align="center" style="padding: 10px 0 0 0;">
                                        <div class="clear"></div>
                                        <input type="button" class="form_button j_submit_international_form" value="Traži"/>
									</td>
                                </tr>
                            </table>
                        </li>
                        <!--------------------SEASON SEARCH FORM ------------------------------------>
                        <li <?php echo (isset($_GET['sef'])) ? "class='active'": '';?>>
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="30" height="25" valign="top" class="search_desc">OD:</td>
                                    <td valign="top" style="padding-left: 5px;">
                                        <select name="season" id="season" class="search_select j_season_dd1">
                                            <option value="">Izaberite ponudu</option>
                                            <?php echo $season_var; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr style="border-bottom: solid 1px #ccc;">
                                    <td width="30" height="25" valign="top" class="search_desc">DO:</td>
                                    <td valign="top" style="padding-left: 5px;">
                                        <div  class="j_seasone_dd2_holder" <?php echo (isset($_GET['sef'])) ? '': 'style="display:none;"';?>>
                                            <select name="season" id="seasone_2" class="search_select j_season_dd2">
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
									<td colspan="2" align="center" style="padding: 10px 0 0 0;">
                                        <div class="clear"></div>
                                        <input type="button" class="form_button j_submit_season_form" value="Traži"/>
									</td>
                                </tr>
                            </table>
                        </li>
                        <li>
                        </li>
                    </ul>
                    <!-- SAVE DESTINATION CITY SO ON PAGE LOAD HE CAN BE SELECTED IN DD -->
                    <input type="hidden" value="<?php if(isset($_GET['t'])){echo $_GET['t'];}else if(isset($_GET['set'])){ echo $_GET['set'];}?>" class="j_destination_city"/>
            	</div>
            </div>
			<?php
			echo $after_widget;		
		}
	}
}

add_action("widgets_init", "fs_init_widget");

function fs_init_widget()
{
	register_widget ('WP_Widget_AKTUELNO');
	register_widget ('WP_Widget_CUSTOM_TEXT_LASTA');
	register_widget ('WP_Widget_CUSTOM_IMAGE_LASTA');
	register_widget ('WP_Widget_SEARCH_LASTA');
	register_widget ('WP_Widget_LASTA_SUB_NAV');
	register_widget ('WP_Widget_CUSTOM_MENU');
	
	$num_sidebars = get_option(THEMESHORTNAME."_number_of_sidebars", 3);
	for($i = 1; $i <= $num_sidebars; $i++) {
	
		register_sidebar(array('name' => 'Sidebar ' . $i,
								'before_widget' => '<li class="widget">',
								'after_widget' => '</li>',
								'before_title' => '',
								'after_title' => ''
						)
		);		
	}
} 
?>