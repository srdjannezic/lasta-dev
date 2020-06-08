<?php
function ajax_submit() {
	global $wpdb;	
	// GET POSTS
	$posts = get_posts();
	if ($posts) {
		$dropdown_posts .= '<select name="post_id" id="post_id">';
		foreach($posts as $post) {
			$dropdown_posts .= '<option value="' . $post->ID. '">' . $post->post_title . '</option>';
		}
		$dropdown_posts .= '</select>';
	}
	wp_reset_query();
	// GET PAGES
	$dropdown_args = array('echo' => 0);
	$pages = wp_dropdown_pages($dropdown_args);
	$post_pages = array($dropdown_posts, $pages);
	die(json_encode($post_pages));
}
add_action('wp_ajax_ajax_submit', 'ajax_submit');