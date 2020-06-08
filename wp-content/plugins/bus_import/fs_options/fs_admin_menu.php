<?php


$FS_menu_options = array (
		array ( 'name' => THEMENAME,
			'id' => 'general_settings',
			'options' => array (
							array(  "type" => "open", "title" => __("Blog category", THEMESHORTNAME) ),
							array(	"name" => __("Number of sidebars", THEMESHORTNAME),
									"desc" => __("Enter the total number of sidebars.", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_number_of_sidebars",
									"type" => "text",
									"std" => "3",
							),
							array(	"name" => __("Home page image on pages", THEMESHORTNAME),
									"desc" => __("Should home page image be shown on every page?.", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_home_page_image",
									"type" => "radio",
									"options" => array(1 => 'yes', 0 => 'no'),
									"std" => "1",
							),
							array(	"name" => __("Home page image on post", THEMESHORTNAME),
									"desc" => __("Should home page image be shown on every post?.", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_home_post_image",
									"type" => "radio",
									"options" => array(1 => 'yes', 0 => 'no'),
									"std" => "1",
							),
							array(	"name" => __("Page sidebar 1", THEMESHORTNAME),
									"desc" => __("Select the default sidebar 1.", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_default_sidebar1",
									"type" => "sidebar_select",
									"std" => "1",
							),
							array(	"name" => __("Page sidebar 2", THEMESHORTNAME),
									"desc" => __("Select the default sidebar 2.", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_default_sidebar2",
									"type" => "sidebar_select",
									"std" => "2",
							),
							array(	"name" => __("Domestic sidebar", THEMESHORTNAME),
									"desc" => __("Select sidebar for domestic search", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_domestic_sidebar",
									"type" => "sidebar_select",
									"std" => "2",
							),
							array(	"name" => __("International sidebar", THEMESHORTNAME),
									"desc" => __("Select sidebar for international search", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_international_sidebar",
									"type" => "sidebar_select",
									"std" => "2",
							),
							array(  "type" => "close" ),							
							array(	"name" => __("Category manager", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_category_options",
									"desc" => __("Select options for categories.", THEMESHORTNAME),
									"type" => "category_options",
									"std" => ""
							),
					)
		),
	
		array ( 'name' => 'home page',
			'id' => 'home_page_settings',
			'options' => array (
							array(  "type" => "open", "title" => __("Home page/post", THEMESHORTNAME) ),							
							array(	"name" => __("page/post", THEMESHORTNAME),
									"id" => THEMESHORTNAME."_home_page_settings",
									"type" => "home_page_page_post",
									"std" => "",
							),
							array(  "type" => "close" ),
					)
		),
);

add_action('admin_menu', 'FS_create_menu');

if(is_admin())
{
	wp_enqueue_style('thickbox');
	wp_enqueue_style('fs_style_css', FS_OPTIONS_URL . 'jscss/style.css');
	wp_enqueue_style('color_picker_css', FS_OPTIONS_URL . 'jscss/colorpicker.css');
	
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('color_picker_js', FS_OPTIONS_URL . 'jscss/colorpicker.js');
	wp_enqueue_script('fs_functions', FS_OPTIONS_URL . 'jscss/fs_functions.js');
	wp_enqueue_script('fs_slider_manager', FS_OPTIONS_URL . 'jscss/fs_slider_manager.js');
	wp_enqueue_script('serialze_script', FS_OPTIONS_URL . 'jscss/serialize.js');
}

function FS_create_menu() {
	global $FS_menu_options, $wp_roles;
	$admin_role = get_role('administrator');
	$first = true;
	foreach($FS_menu_options as $options_page)
	{
		if($first)
		{
			add_menu_page($options_page['name'], $options_page['name'], THEMESHORTNAME . '_' . $options_page['id'], "fsmenu", 'render_menu_options');
			$first = false;
		}
		else
		{
			add_submenu_page("fsmenu", $options_page['name'], $options_page['name'], THEMESHORTNAME . '_' . $options_page['id'], $options_page['id'], 'render_menu_options');
		}
		// USER PERMISSIONS
		$admin_role->add_cap(THEMESHORTNAME . '_' . $options_page['id']);
	}

	add_action('admin_init', 'FS_register_mysettings');
}

function FS_register_mysettings() {
	
	global $FS_menu_options;
	
	foreach($FS_menu_options as $options_page)
		foreach($options_page['options'] as $option)
			if(isset($option['id']))
				register_setting(THEMESHORTNAME."-".$options_page['id']."-group", $option['id']);
}

function render_menu_options() {
	global $FS_menu_options;
	
	/* find the requested page in $FS_menu_options */
	$found = false;
	$options;
	$options_page;
	foreach($FS_menu_options as $options_page)
	{
		if($options_page['id'] == $_GET['page'])
		{
			$found = true;
			$options = $options_page['options'];
			break;
		}
	}	
	
	/* if it's not found, we take the default, i.e. first one */
	if(!$found)
	{
		$options_page = $FS_menu_options[0];
		$options = $options_page['options'];	
	}
    
	?>
	<div class="wrap">
	
		<h2><?php echo $options_page['name']; ?></h2>
		
		<form method="post" action="<?php echo  "options.php"; ?>">
		<?php settings_fields($TEMPLATESHORTNAME."-".$options_page['id']."-group"); ?>
		
		<?php 
		$alt_style = false;
		foreach ($options as $option)
		{
			$callback = 'render_menu_item_'.$option['type'];		
			if(function_exists($callback))
			{
				$option_value = get_option($option['id'], "");
				if($option_value != "")
					$option['std'] = $option_value;
				
				if($alt_style)
					$callback($option, 'alternate');
				else
					$callback($option, '');
					
				$alt_style = !$alt_style;
			}	
			else
			{
				echo '<tr>No function'. $callback .'()</tr>';
			}
		}
		
		?>
		<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes" />
		</p>
		</form>

	</div>

	<?php
}


//////////////////////////////////
// HOME PAGE PAGE/POST
//////////////////////////////////
function render_menu_item_home_page_page_post($option, $class)
{
	query_posts( $args );

	// The Loop
	$posts = get_posts();
	if ($posts) {
		$dropdown_posts .= '<select name="post_id" id="post_id">';
		foreach($posts as $post) {
			$dropdown_posts .= '<option value="' . $post->ID. '">' . $post->post_title . '</option>';
		}
		$dropdown_posts .= '</select>';
	}
	
	// Reset Query
	wp_reset_query();
	$current_values = json_encode(unserialize($option['std']));
	//var_dump($current_values);
	?>
	<script>
        jQuery(document).ready(function($) {
			var pages_dropdown = $('#dropdowns td').eq(0).html();
			var posts_dropdown = $('#dropdowns td').eq(1).html();
			var current_values = <?php echo $current_values; ?>;
			for(value in current_values) {
				var page_post = current_values[value].charAt(0);
				var page_post_id = current_values[value].substring(2);
				$('.dropdown_type').eq(value).val(page_post);
				if(page_post == 0) {
					$('.dropdown_selected').eq(value).html(pages_dropdown);
				} else {
					$('.dropdown_selected').eq(value).html(posts_dropdown);
				}
				$('.dropdown_selected').eq(value).find('select').val(page_post_id);
			}
			$('.dropdown_type').change(function() {
				var to_change = $(this).parents('td:first').find('.dropdown_selected');
				if($(this).val() == 0) {
					$(to_change).html(pages_dropdown);
				} else {
					$(to_change).html(posts_dropdown);
				}
			});
			var dropdown_values = new Array();
			$('form').submit(function (){
				for(i=0; i<4; i++) {
					dropdown_values[i] = $('.dropdown_type').eq(i).val() + ',' + $('.dropdown_selected select').eq(i).val();
				}
				$('#dropdown_values').val(serialize(dropdown_values));
			});
		});
    </script>
    <tr style="display: none;" id="dropdowns">
        <td><?php wp_dropdown_pages(); ?></td>
        <td><?php echo $dropdown_posts; ?></td>
        <td><input type="text" id="dropdown_values" name="<?php echo $option['id']; ?>" value="<?php echo $option['std']; ?>" /></td>
    </tr>
    <tr class="<?php echo $class; ?>">
        <td>
        	<h3 style="float: left; font-size: 12px;">1: </h3>
            <div style="float: left; margin: 7px 10px 0 10px;">
				<select name="dropdown_type" class="dropdown_type">
                	<option value="0">Page</option>
                	<option value="1">Post</option>
                </select>
            </div>
            <div style="float: left; margin: 7px 10px 0 0;" class="dropdown_selected"></div>
        </td>
    </tr>
    <tr class="<?php echo $class; ?>">
        <td>
        	<h3 style="float: left; font-size: 12px;">2: </h3>
            <div style="float: left; margin: 7px 10px 0 10px;">
				<select name="dropdown_type" class="dropdown_type">
                	<option value="0">Page</option>
                	<option value="1">Post</option>
                </select>
            </div>
            <div style="float: left; margin: 7px 10px 0 0;" class="dropdown_selected"></div>
        </td>
    </tr>
    <tr class="<?php echo $class; ?>">
        <td>
        	<h3 style="float: left; font-size: 12px;">3: </h3>
            <div style="float: left; margin: 7px 10px 0 10px;">
				<select name="dropdown_type" class="dropdown_type">
                	<option value="0">Page</option>
                	<option value="1">Post</option>
                </select>
            </div>
            <div style="float: left; margin: 7px 10px 0 0;" class="dropdown_selected"></div>
        </td>
    </tr>
    <tr class="<?php echo $class; ?>">
        <td>
        	<h3 style="float: left; font-size: 12px;">4: </h3>
            <div style="float: left; margin: 7px 10px 0 10px;">
				<select name="dropdown_type" class="dropdown_type">
                	<option value="0">Page</option>
                	<option value="1">Post</option>
                </select>
            </div>
            <div style="float: left; margin: 7px 10px 0 0;" class="dropdown_selected"></div>
        </td>
    </tr>
    <?php
}






function render_menu_item_title($option, $class)
{
	?>
    <tr class="<?php echo $class; ?>">
        <td colspan="3"><h2 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $option['name']; ?></h2></td>
    </tr>
    <?php
}

function render_menu_item_open($option, $class)
{ 
?>
	<div style="<?php echo $option['style']; ?>"><table class="widefat <?php echo $option['class']; ?>" style="margin-bottom:20px;"><thead><tr><th colspan="3"><strong><?php echo $option['title']; ?></strong></th></tr></thead>
<?php 
}

function render_menu_item_close($option, $class)
{ 
?>
	<tfoot><tr><th colspan="3">&nbsp;</th></tr></tfoot></table></div>
<?php 
}

function render_menu_item_text($option, $class)
{
	?>
	<tr valign="top" class="<?php echo $class; ?>">
	    <th scope="row" width="200px"><?php echo $option['name']; ?></th>
    	<td>			
			<input type="text" size="<?php echo $option['size']; ?>" name="<?php echo $option['id']; ?>" value="<?php echo htmlspecialchars($option['std']); ?>" />
            <br />
            <?php echo $option['desc']; ?>
        </td>
	</tr>
    <?php
}

function render_menu_item_textarea($option, $class)
{
	?>
	<tr valign="top" class="<?php echo $class; ?>">
	    <th scope="row" width="200px"><?php echo $option['name']; ?></th>
    	<td>
        	<?php echo $option['desc']; ?><br />
        	<textarea name="<?php echo $option['id']; ?>" style="width:400px; height:200px;" cols="" rows=""><?php echo htmlspecialchars($option['std']); ?></textarea>
        </td>
	</tr>
    <?php
}

function render_menu_item_select($option, $class)
{
	?>
	<tr valign="top" class="<?php echo $class; ?>">
	    <th scope="row" width="200px"><?php echo $option['name']; ?></th>
        <td>
	        <?php echo $option['desc']; ?><br />
            <select name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>">
            <?php 
            foreach ($option['options'] as $option_key => $option_name)
            { 
                ?>
                <option value="<?php echo $option_key; ?>" <?php echo ($option_key == $option['std'] ? 'selected="selected"' : ''); ?>><?php echo $option_name; ?></option>
                <?php
            }
            ?>
            </select>
        </td>
	</tr>
	<?php
}

function render_menu_item_category_select($option, $class)
{
	?>
	<tr valign="top" class="<?php echo $class; ?>">
	    <th scope="row" width="200px"><?php echo $option['name']; ?></th>
        <td>
            <?php echo $option['desc']; ?><br />
            <select style="width:240px;height:auto;" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" >
            <?php 
			if($option['allownone'] == 'true')
				echo '<option value="">None</option>';
			$args = array(
			    'type' => 'post',
				'hide_empty' => false
			);
			$categories = get_categories($args);
			$selected_ids = preg_split('/,/', $option['std'], -1, PREG_SPLIT_NO_EMPTY);
			foreach ($categories as $cat)
            { 
				$selected = (in_array($cat->term_id.'', $selected_ids) ? 'selected="selected"' : '');
                ?>
                <option value="<?php echo $cat->term_id; ?>" <?php echo $selected; ?>><?php echo $cat->name; ?></option>                
                <?php
            }
            ?>
            </select>   
            <br />
        </td>        
	</tr>
	<?php
}

function render_menu_item_radio($option, $class)
{
	?>
	<tr valign="top" class="<?php echo $class; ?>">
	    <th scope="row" width="200px"><?php echo $option['name']; ?></th>
        <td>
			<?php echo $option['desc']; ?><br />
            <?php 
			$index = 0;
            foreach ($option['options'] as $select_option => $select_caption)
            { 			
			    ?>
                <input type="radio" name="<?php echo $option['id']; ?>" id="<?php echo $option['id'].$index; ?>"
                	   value="<?php echo $select_option; ?>" <?php echo ($select_option == $option['std'] ? 'checked="checked"' : ''); ?>> <?php echo $select_caption; ?><br />
                <?php
				$index++;
            }
            ?>
        </td>
	</tr>
	<?php
}

function render_menu_item_image_select($option, $class)
{	
	?>
    <tr valign="top" class="<?php echo $class; ?>">
	    <th scope="row" width="200px"><?php echo $option['name']; ?></th>
        <td>
		<?php
			if(is_numeric($option['std'])) {
				$att = get_post($option['std']);
				$img_title = $att->post_title;
				$img = wp_get_attachment_image_src($option['std'], 'full');
				if($img)
					$img_url = $img[0];
			}
		?>
			<div class="upload_image_div" style="float: left;">
				<input type="hidden" class="upload_image" name="<?php echo $option['id']; ?>" value="<?php echo $option['std']; ?>" />
				<input type="text" class="upload_image_title" readonly="readonly" size="50" value="<?php echo $img_title; ?>" />
				<a href="#" class="button upload_image_button" onclick="return false;">Select</a>
				<a href="#" class="button" 
					onclick="jQuery(this).siblings('input.upload_image').val(''); 
							 jQuery(this).siblings('input.upload_image_title').val(''); 
							 jQuery(this).parent().siblings('.fs_image_preview').find('img').attr('src', ''); 
							 return false;">
						Clear
				</a><br />
				<p><?php echo $option['desc']; ?></p>
			</div>
            <div class="fs_image_preview" style="float:right; margin: 5px; border:1px solid #DFDFDF; height:100px; min-width:100px;">
            	<img height="100" src="<?php echo $img_url; ?>" />
            </div>
            <div style="clear: both;"></div>
        </td>
	</tr>
<?php
}

function render_menu_item_category_options($option)
{ 
	?>
	<h3><?php echo $option['name']; ?></h3>
    <?php echo $option['desc']; ?>
    <br />
    <input type="hidden" style="width:240px;" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" value="<?php echo htmlspecialchars($option['std']); ?>" />
    <table class="widefat fs_rollover_highlight" border="" id="<?php echo $option['id']; ?>_table">
        <thead><tr><th>Category</th><th>Sidebar 1</th><th>Sidebar 2</th><th>Heading</th><th></th></thead>
        <?php
        $args = array(
			'type' => 'post',
			'hide_empty' => false
		);
        $categories = get_categories($args);
        
        foreach($categories as $cat)
        {
            $category_options = fs_get_category_options($cat->term_id, $option['std']);
            
            echo '<tr data-catid="'.$cat->term_id.'"><td>'.$cat->name.'</td><td>';
            
            echo '<select name="cat'.$cat->term_id.'_sidebar_select1">';
            echo '<option value="0"'.($category_options['sidebar1'] == 0 ? ' selected="selected"' : '').'>None</option>';
            for($si = 1; $si <= get_option(THEMESHORTNAME . "_number_of_sidebars", 3); $si++)
                echo '<option value="'.$si.'"'.($category_options['sidebar1'] == $si ? ' selected="selected"' : '').'>Sidebar'.$si.'</option>';
            echo '</select>';

            echo '</td><td>';
            
            echo '<select name="cat'.$cat->term_id.'_sidebar_select2">';
            echo '<option value="0"'.($category_options['sidebar2'] == 0 ? ' selected="selected"' : '').'>None</option>';
            for($si = 1; $si <= get_option(THEMESHORTNAME . "_number_of_sidebars", 3); $si++)
                echo '<option value="'.$si.'"'.($category_options['sidebar2'] == $si ? ' selected="selected"' : '').'>Sidebar'.$si.'</option>';
            echo '</select>';

            echo '</td><td>';
            echo '<textarea rows="2" cols="30" name="cat'.$cat->term_id.'_heading" />'.$category_options['heading'].'</textarea>';
            echo '</td>';
        }
        ?>
    </table>
    <script>
    jQuery(document).find('form').submit( function () {  
        var table = jQuery('#<?php echo $option['id']; ?>_table');
		var our_arr = new Array();
		jQuery(table).find('tr').each(function () { 
            if(this.hasAttribute('data-catid'))
            {
                var display_sel = jQuery(this).find('select[name$="_display_select"]')[0];
                var lightbox = "no";
                jQuery(this).find('input[name$="_lightbox"]').each( function() { if(this.checked) lightbox = this.value; });
                var sidebar_sel1 = jQuery(this).find('select[name$="_sidebar_select1"]')[0];
                var sidebar_sel2 = jQuery(this).find('select[name$="_sidebar_select2"]')[0];
				var cat_arr = new Array();
				cat_arr['sidebar1'] = sidebar_sel1.options[sidebar_sel1.selectedIndex].value;
				cat_arr['sidebar2'] = sidebar_sel2.options[sidebar_sel2.selectedIndex].value;
				cat_arr['heading'] = jQuery('textarea[name$="_heading"]', this).val();
				our_arr[jQuery(this).attr('data-catid')] = cat_arr;
			}
        });
		jQuery('#<?php echo $option['id']; ?>').val(serialize(our_arr));
    });
    </script>
</div>
<?php
}

function render_menu_item_multiple_post_select($option, $class)
{ 
	global $wpdb;
	
	if(!isset($option['post_types']))
		$option['post_types'] = array('post', 'page');
	?>
	<tr valign="top" class="<?php echo $class; ?>">
		<th scope="row" width="200px"><?php echo $option['name']; ?></th>
        <td>
	        <div style="float: left;">
				<?php echo $option['desc']; ?>
                <br />
            	<input type="hidden" style="width:240px;" name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" value="<?php echo htmlspecialchars($option['std']); ?>" />
                
				<div id="<?php echo $option['id']; ?>_type_select_div" style=" <?php if(count($option['post_types']) == 1) echo 'display:none;'; ?>"> 
					Select type: 
					<select style="width:240px;" name="<?php echo $option['id']; ?>_select" id="<?php echo $option['id']; ?>_select"
							onchange="var divs = jQuery('#<?php echo $option['id']; ?>_item_divs > div').hide(); jQuery('#<?php echo $option['id']; ?>_' + jQuery(this).val() + '_div').show();">
						<?php foreach($option['post_types'] as $post_type) { ?>
						<option value="<?php echo $post_type; ?>"><?php echo $post_type; ?></option>
						<?php } ?>
					</select>
				</div>
				<div id="<?php echo $option['id']; ?>_item_divs">
					<?php $first = true; ?>
					<?php foreach($option['post_types'] as $post_type) { ?>
					<div id="<?php echo $option['id']; ?>_<?php echo $post_type; ?>_div" <?php if(!$first) echo 'style="display:none;"'; ?>>
						Select <?php echo $post_type; ?>:
						<select id="<?php echo $option['id']; ?>_<?php echo $post_type; ?>_select">

						<?php
						$first = false;
						$post_query = new WP_Query();
						$post_query->query( array('post_type' => $post_type, 'post_status' => 'publish', 'suppress_filters' => true, 'posts_per_page' => -1 ) );
						while ($post_query->have_posts()) : $post_query->the_post(); 
						
						if(isset($option['filter']['lang'])) {
							$p_lan = $wpdb->get_var('SELECT language_code FROM wp_icl_translations WHERE element_type="post_' . $post_type . '" AND element_id="' . get_the_id() . '"');
							if($p_lan != $option['filter']['lang'])
								continue;							
						}
						
						?>

							<option value="<?php the_ID(); ?>"><?php the_title(); ?></option>

						<?php endwhile; ?>

						</select>
					</div>
					<?php } ?>
				</div>
                <a href="#" class="button" onclick="addPagePostItem('<?php echo $option['id']; ?>'); return false;">Add item</a>&nbsp;               
            	<table class="widefat fs_rollover_highlight" border="" id="<?php echo $option['id']; ?>_table">
	            	<thead><tr><th>Controls</th><th>Type</th><th>Name</th></thead>
	            </table>
                <script>
					jQuery(document).find('form').submit( function (){ buildPagePostRes('<?php echo $option['id']; ?>'); } );
				
					function addPagePostItem(id) {
						var type = jQuery('#' + id + '_select option:selected').val();
						var opt = jQuery('#' + id + '_' + type + '_select option:selected');						
						addPagePostRow(id, type, opt.val(), opt.html());
					}					
					function addPagePostRow(id, type, pid, title) {
						var row = jQuery('<tr data-pid="' + pid + '"><td><a class="upButton"></a><a class="downButton"></a><a class="removeButton"></a></td><td>' + type + '</td><td>' + title + '</td></tr>');
						jQuery('.upButton', row).click( function() { var r = jQuery(this).parents('tr:first'); r.insertBefore(r.prev()); });
						jQuery('.downButton', row).click( function() { var r = jQuery(this).parents('tr:first'); r.insertAfter(r.next()); });
						jQuery('.removeButton', row).click( function() { jQuery(this).parents('tr:first').remove(); });						
						jQuery('#' + id + '_table').append(row);
					}					
					function buildPagePostRes(id) {
						var res = "";						
						jQuery('#' + id + '_table tr[data-pid]').each( function() { if(res != "") res += ","; res += jQuery(this).attr('data-pid'); });						
						jQuery('#' + id).val(res);
					}
					<?php 
						$ids = explode(",", $option['std']);
						foreach($ids as $id)
						{
							if(!is_numeric($id)) continue;
							$post = get_post($id);							
							echo 'addPagePostRow("'.$option['id'].'", "'.$post->post_type.'", "'.$id.'", "'.addslashes($post->post_title).'");'."\n";
						}
					?>
				</script>                
			</div>
		</td>
	</tr>
<?php
}	

function render_menu_item_separator($option)
{ ?>
	<tr valign="top"><td colspan="2"><hr /></td></tr>
<?php
}

function render_menu_item_color_picker($option, $class)
{
	?>
	<tr valign="top" class="<?php echo $class; ?>">
	    <!--<th scope="row" width="100"><?php echo $option['name']; ?></th>-->
		<th></th>
    	<td width="300">
        	<input type="text" style="float:left;" class="colorPickerField" size="10" name="<?php echo $option['id']; ?>" value="<?php echo $option['std']; ?>" />
			<div id="<?php echo $option['id']; ?>_colordiv" style="float:left; margin: 1px 15px; width: 20px; height: 20px; border: solid 1px #000000; background-color: #<?php echo $option['std']; ?>;" 
				onclick="jQuery('[name=<?php echo $option['id']; ?>]').click();"></div>
            <div style="clear:both;" />
            <?php echo $option['desc']; ?>
        </td>
	</tr>
    <?php
}

function render_menu_item_sidebar_select($option, $class)
{
	?>
	<tr valign="top" class="<?php echo $class; ?>">
	    <th scope="row" width="200"><?php echo $option['name']; ?></th>
        <td>
	        <?php echo $option['desc']; ?><br />
			<select name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>">
				<option value="0"'.($category_options['sidebar'] == 0 ? ' selected="selected"' : '').'>None</option>
				<?php for($si = 1; $si <= get_option(THEMESHORTNAME . "_number_of_sidebars", 3); $si++) { ?>
				<option value="<?php echo $si; ?>" <?php if($option['std'] == $si) echo ' selected="selected"'; ?>>Sidebar<?php echo $si; ?></option>
				<?php } ?>
			</select>
        </td>
	</tr>
	<?php
}


?>
