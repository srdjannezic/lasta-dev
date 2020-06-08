<?php

// $blog_catoptions = fs_get_category_options(get_option(THEMESHORTNAME."_blog_category"), get_option(THEMESHORTNAME."_category_options"));
// $blog_catoptions['lightbox'];

function fs_get_category_options($cat_id, $data)
{
	$def = array('display' => 0, 
				 'lightbox' => 'no', 
				 'sidebar' => 0, 
				 'sidebar_pos' => 'left',
				 'posts_per_page' => '10',
				 'heading' => '',
				 'share' => 'yes',
				 'author' => 'yes');
	if($data == "")
		return $def;
	
	$cat_arr = unserialize($data);
	return $cat_arr[$cat_id];	
}