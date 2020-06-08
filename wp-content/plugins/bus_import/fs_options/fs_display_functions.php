<?php
// Custom pagination
function display_pagination_nav($query_string, $posts_per_page, $current_page, $range = 3) 
{
	$my_query = new WP_Query($query_string ."&posts_per_page=-1");
	$num_posts = $my_query->post_count;
			
	$num_pages = ceil($num_posts/$posts_per_page);
	
	if($num_pages < 2)
		return;
	
	echo '<ul id="pagination">';
	if($current_page - $range > 1)
		echo '<li><a href="'.get_pagenum_link(1).'">&laquo; First</a></li>';
	if($current_page > 1)
		echo '<li><a href="'.get_pagenum_link($current_page - 1).'">&laquo; Previous</a></li>';
	
	for ($i = max($current_page - $range, 1); $i <= min($current_page + $range, $num_pages); $i++)
	{
		if($i == $current_page)
			echo '<li class="current">'.$i.'</li>';
		else
			echo '<li><a href="'.get_pagenum_link($i).'" class="inactive" >'.$i.'</a></li>';	
	}
	
	if($current_page < $num_pages && $showitems < $num_pages) 
		echo '<li><a href="'.get_pagenum_link($current_page + 1).'">Next &raquo;</a></li>';
	if($current_page + $range - 1 < $num_pages)
		echo '<li><a href="'.get_pagenum_link($num_pages).'">Last &raquo;</a></li>';
	
	echo '</ul>'."\n";
}