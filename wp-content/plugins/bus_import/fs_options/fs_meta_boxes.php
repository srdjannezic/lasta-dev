<?php

$meta_prefix = '_' . THEMESHORTNAME;

$FS_meta_boxes = array (
	"id" => $meta_prefix . '-options',
	"name" => THEMENAME . " - post/page options",
	"area" => array ("page", "post"),
	"options" => array (
			array( "name" => "<strong>Show Title: </strong>",
			"desc" => "Show title inside of post?",
			"id" => $meta_prefix."_show_title",
			"type" => "radio",
			"options" => array(1 => 'yes', 0 => 'no'),
			"std" => "1"
		),
		array( "name" => "<strong>Show featured image: </strong>",
			"desc" => "Show featured image inside of post?",
			"id" => $meta_prefix."_show_featured",
			"type" => "radio",
			"options" => array(1 => 'yes', 0 => 'no'),
			"std" => "1"
		),
		array( "name" => "<strong>Sidebar 1</strong>",
			"desc" => "Select sidebar 1",
			"id" => $meta_prefix."_sidebar_type1",
			"type" => "sidebar_select",
			"std" => "0"
		),
		array( "name" => "<strong>Sidebar 2</strong>",
			"desc" => "Select sidebar 2",
			"id" => $meta_prefix."_sidebar_type2",
			"type" => "sidebar_select",
			"std" => "0"
		),
		array( "name" => "<strong>Home page big image: </strong>",
			"desc" => "Show featured home page image?",
			"id" => $meta_prefix."_show_home_page_image",
			"type" => "radio",
			"options" => array(0 => 'inherit', 1 => 'yes', 2 => 'no'),
			"std" => "0"
		),
	)
);

add_action('admin_menu', 'fs_add_meta_boxes');
add_action('save_post', 'save_postdata');

function fs_add_meta_boxes() {  
	global $FS_meta_boxes;  
  	
	if(function_exists('add_meta_box'))
		foreach($FS_meta_boxes['area'] as $area)		
	    	add_meta_box($FS_meta_boxes['id'], $FS_meta_boxes['name'], 'fs_render_meta_boxes', $area, 'normal', 'high');
	
	wp_enqueue_script('fs_functions', FS_OPTIONS_URL . 'fs_functions.js');
}  

function fs_render_meta_boxes() {
	global $post, $FS_meta_boxes;  
   
	foreach($FS_meta_boxes['options'] as $option) {  
		$callback = 'render_meta_box_'.$option['type'];
		if(function_exists($callback))
		{
			$meta_box_value = get_post_meta($post->ID, $option['id'], true);
			if($meta_box_value != "")
				$option['std'] = $meta_box_value;
			
			echo '<div class="alt" style="border:1px solid #DFDFDF; margin: 10px 0; padding: 10px;">';
			$callback($option);
			echo '</div>';
			echo "\n\n\n";
		}
   }
   echo '<input type="hidden" name="'.$FS_meta_boxes['id'].'_noncename" id="'.$FS_meta_boxes['id'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';	
}

function save_postdata( $post_id ) {
    global $post, $FS_meta_boxes;
	
    if(!wp_verify_nonce( $_POST[$FS_meta_boxes['id'].'_noncename'], plugin_basename(__FILE__))) {
	   	return $post_id;
	}
		
	foreach($FS_meta_boxes['options'] as $option) {    	
		
		if ( 'page' == $_POST['post_type'] ) {
			if ( !current_user_can( 'edit_page', $post_id ))
				return $post_id;
		}
		else {  
			if ( !current_user_can( 'edit_post', $post_id ))  
				return $post_id;  
		}
		
		$data = "";
     	if(isset($_POST[$option['id']]))
			$data = $_POST[$option['id']];
		
	 	if(get_post_meta($post_id, $option['id']) == "")
   			add_post_meta($post_id, $option['id'], $data, true);
		else// if($data != get_post_meta($post_id, $option['id'], true))
			update_post_meta($post_id, $option['id'], $data);
		//elseif($data == "")
		//	delete_post_meta($post_id, $option['id'], get_post_meta($post_id, $option['id'], true));
   	}
}

function render_meta_box_title($option)
{
	echo'<p>'.$option['name'].'</p>';
	echo'<p><label for="'.$option['id'].'">'.$option['desc'].'</label></p>';
}

function render_meta_box_text($option)
{
	echo'<p>'.$option['name'].'</p>';
	echo'<input type="text" name="'.$option['id'].'" value="' . $option['std'] . '" size="'.$option['size'].'" /><br />';     
	echo'<p><label for="'.$option['id'].'">'.$option['desc'].'</label></p>';
}

function render_meta_box_checkbox($option)
{	
	if($option['std'] == 'true')
		$cs = 'checked="checked"';
	echo '<p>'.$option['name'].'</p>';
	echo '<p><input type="checkbox" name="'.$option['id'].'" value="true" '. $cs .' />&nbsp;';
	echo '<label for="'.$option['id'].'">'.$option['desc'].'</label><br/></p>';
}

function render_meta_box_radio($option)
{	
	echo '<p>'.$option['name'].'</p>';
	echo '<p><label for="'.$option['id'].'">'.$option['desc'].'</label></p>';
    foreach ($option['options'] as $select_option => $select_caption)
    { 			
        ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="<?php echo $option['id']; ?>"
               value="<?php echo $select_option; ?>" <?php echo ($select_option == $option['std'] ? 'checked="checked"' : ''); ?> /> <?php echo $select_caption; ?><br />
        <?php
    }
}

function render_meta_box_image_select($option)
{	
	?>
    <div style="float: left;">
    <p><?php echo $option['name']; ?></p>
    <p><?php echo $option['desc']; ?></p>
	<p><select name="<?php echo $option['id']; ?>_select" id="<?php echo $option['id']; ?>_select" onchange="imageSelectChanged('<?php echo $option['id']; ?>');">
	<option value="">None</option>
	<option value="" <?php if($option['std'] != "" && !is_numeric($option['std'])) echo ' selected="selected"'; ?>>Custom URL...</option>
		
    <?php
	$args = array( 
		'post_parent' => null,
		'post_type'   => 'attachment', 
		'post_mime_type' => 'image'
	);
	$images = get_children($args);
	$selected_image_url = '';
	foreach($images as $image_post) 
	{		
		$image_url = wp_get_attachment_url($image_post->ID, 'full');
		$selected = '';
		if(is_numeric($option['std']) && $option['std'] == $image_post->ID)
		{
			$selected = 'selected="selected"';
			$selected_image_url = $image_url;
		}
		?>
		<option value="<?php echo $image_post->ID; ?>" image_url="<?php echo $image_url; ?>" <?php echo $selected; ?>><?php echo $image_post->post_title; ?></option>
        <?php
	}
	if($option['std'] != "" && !is_numeric($option['std']))
	{
		$selected_image_url = $option['std'];		
	}
	?>
	</select>
    <br />
	<label for="<?php echo $option['id']; ?>">Select the image (from Media Library) in the combobox<br />or enter the image url in the text field below.</label></p>
    
  	<p>
    	<input type="text" id="<?php echo $option['id']; ?>" name="<?php echo $option['id']; ?>" value="<?php echo $option['std']; ?>" <?php if($option['std'] == "" || is_numeric($option['std'])) echo 'style="display:none;"'; ?>
    		size="100" onblur="imageInputChanged('<?php echo $option['id']; ?>');"/>
    </p>
    </div>
	<div id="<?php echo $option['id']; ?>_image_div" style="float:right;top:5px;right:5px; border:1px solid #DFDFDF; margin:5px; height:100px;">
		<img height="100" src="<?php echo $selected_image_url; ?>" />
	</div><div style="clear: both;"></div>
<?php
}

function render_meta_box_sidebar_select($option)
{	
	?>
    <div style="float: left;">
	    <p><?php echo $option['name']; ?></p>
		<p>
        	<input type='hidden' name="<?php echo $option['id']; ?>" id="<?php echo $option['id']; ?>" value="<?php echo $option['std']; ?>"/>
        	<select name="<?php echo $option['id']; ?>_select" id="<?php echo $option['id']; ?>_select" onchange="document.getElementById('<?php echo $option['id']; ?>').value = this.options[this.selectedIndex].value;" >
				<option value="-1" <?php if($option['std'] == -1) echo ' selected="selected"'; ?>>None</option>
	        	<option value="0" <?php if($option['std'] == 0) echo ' selected="selected"'; ?>>Inherit</option>
		
    			<?php
				$num_sidebars = (int)get_option(THEMESHORTNAME."_number_of_sidebars");
				for($si = 1; $si <= $num_sidebars; $si++)
					echo '<option value="'.$si.'" '.($option['std'] == $si ? ' selected="selected"' : '').'>Sidebar'.$si.'</option>';
				?>
			</select>
    	</p>
		<p>
        	<label for="<?php echo $option['id']; ?>">
				<?php echo $option['desc']; ?>
            </label>
		</p>
    </div>	<div style="clear: both;"></div>
<?php
}
?>
