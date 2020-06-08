<?php

function fs_init_shortcodes()
{
	add_shortcode('hiddencontent', 'fs_hiddencontent_shortcode_handler');
	add_shortcode('visiblecontent', 'fs_visiblecontent_shortcode_handler');
	add_shortcode('button', 'fs_button_shortcode_handler');
	add_shortcode('dropcap', 'fs_dropcap_shortcode_handler');
	add_shortcode('pullquoteleft', 'fs_pullquoteleft_shortcode_handler');
	add_shortcode('pullquoteright', 'fs_pullquoteright_shortcode_handler');
	add_shortcode('onehalf', 'fs_onehalf_shortcode_handler');
	add_shortcode('onehalflast', 'fs_onehalflast_shortcode_handler');
	add_shortcode('onethird', 'fs_onethird_shortcode_handler');
	add_shortcode('onethirdlast', 'fs_onethirdlast_shortcode_handler');
	add_shortcode('twothirds', 'fs_twothirds_shortcode_handler');
	add_shortcode('twothirdslast', 'fs_twothirdslast_shortcode_handler');
	add_shortcode('googlemap', 'fs_googlemap_shortcode_handler');
	add_shortcode('contactform', 'fs_contactform_shortcode_handler');
	add_shortcode('spacing', 'fs_spacing_shortcode_handler');
	
	// TABS
	add_shortcode('tabslist', 'fs_tabslist_shortcode_handler');
	add_shortcode('li', 'fs_li_shortcode_handler');
	
	// LASTA CUSTOM BOXES
	add_shortcode('add_custom_boxes', 'fs_add_custom_boxes_shortcode_handler');
	
	// LISTS
	add_shortcode('bullet_list', 'fs_bulletList_shortcode_handler');
	add_shortcode('number_list', 'fs_numberList_shortcode_handler');
	add_shortcode('letter_list', 'fs_letterList_shortcode_handler');
	add_shortcode('check_list', 'fs_checkList_shortcode_handler');
	add_shortcode('arrow_list', 'fs_arrowList_shortcode_handler');
	add_shortcode('box_list', 'fs_boxList_shortcode_handler');
	
	add_shortcode('code', 'fs_code_shortcode_handler');	
}

//LASTA CUSTOM
function fs_add_custom_boxes_shortcode_handler($atts, $content=null, $code="")
{

$to_be_returned .= '<ul class="homepage_boxes">';
$home_page_array = explode(',', $content);
$count = 0;
foreach($home_page_array as $home_page) {
    $page_post_var = get_page($home_page);
	$to_be_returned .= '<li' . (($count++ % 2 == 1) ? ' style="margin-right: 0;"' : '') .'>'
            .' <h2><a href="' . get_permalink($home_page) . '">' . $page_post_var->post_title . '</a></h2>';
			$post_img = get_the_post_thumbnail($home_page, 'homepage_boxes');
            if($post_img) {
                $to_be_returned .= '<a href="' . get_permalink($home_page) . '">' . $post_img . '</a>';
            }
            $to_be_returned .= '<p>' . $page_post_var->post_excerpt . '</p>' . '<a class="read_more_button" href="' . get_permalink($home_page) . '">Detaljnije</a></li>';
}
	$to_be_returned .= '</ul><div class="clear"></div>';
	return $to_be_returned;
}


// TABS
function fs_tabslist_shortcode_handler($atts, $content=null, $code="")
{
	$tabs = explode(',', esc_attr($atts['tabs']));
	$tablist = "<div class='tabs_wrapper j_tab_wrapper'><div class='tab_list_wrapper'><ol class='tab_list j_tab_tabs'>";
	foreach($tabs as $tab) {
		$tablist .= "<li>" . $tab . "</li>";
	}
	$tablist .= "</ol></div><div class='clear'></div><ol class='tab_content j_tab_content'>" . do_shortcode($content) . "</ol></div>";
	return $tablist;
}
function fs_li_shortcode_handler($atts, $content=null, $code="")
{
	$tablist = '<li>' . do_shortcode($content) . '</li>';
	return $tablist;
}

// SPACING
function fs_spacing_shortcode_handler($atts, $content=null, $code="")
{
	$values = explode(',', esc_attr($atts['pixels']));
	if (count($values) > 2) {
		$padding = $values[0] ."px " . $values[1] ."px " . $values[2] ."px " . $values[3] ."px";
	} else {
		$padding = $values[0] ."px " . $values[1] ."px";
	}
	return "<div style='padding: " . $padding . "; display: inline-block;'>" . do_shortcode($content) . "</div>";
}


// HIDDEN CONTENT
function fs_hiddencontent_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="hiddenContent"><div class="hiddenContent_head"><div class="slide_status_icon"></div> '.esc_attr($atts['title']).'</div><div class="hidden_content_pad_mar"><div class="hidden_content_content"><p>' . do_shortcode($content) . '</p></div></div></div>';
}
// VISIBLE CONTENT
function fs_visiblecontent_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="hiddenContent visibleContent"><div class="hiddenContent_head"><div class="slide_status_icon"></div> '.esc_attr($atts['title']).'</div><div class="hidden_content_pad_mar"><div class="hidden_content_content"><p>' . do_shortcode($content) . '</p></div></div></div>';
}


function fs_button_shortcode_handler($atts, $content=null, $code="")
{
	return '<a class="button" href="'.$atts['link'].'">' . do_shortcode($content) . '</a>';
}

////////////////////////////
// LISTS
///////////////////////////
function fs_bulletList_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="bullet_list list_text">' . do_shortcode($content) . '</div>';
}
function fs_numberList_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="number_list list_text">' . do_shortcode($content) . '</div>';
}
function fs_letterList_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="letter_list list_text">' . do_shortcode($content) . '</div>';
}
function fs_checkList_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="check_list list_text">' . do_shortcode($content) . '</div>';
}
function fs_arrowList_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="arrow_list list_text">' . do_shortcode($content) . '</div>';
}
function fs_boxList_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="box_list list_text">' . do_shortcode($content) . '</div>';
}



function fs_dropcap_shortcode_handler($atts, $content=null, $code="")
{
	return '<span class="dropCap">' . do_shortcode($content) . '</span>';
}
function fs_pullquoteleft_shortcode_handler($atts, $content=null, $code="")
{
	return '<span class="pullQuoteLeft">' . do_shortcode($content) . '</span>';
}
function fs_pullquoteright_shortcode_handler($atts, $content=null, $code="")
{
	return '<span class="pullQuoteRight">' . do_shortcode($content) . '</span>';
}




function fs_onehalf_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="oneHalf">' . do_shortcode($content) . '</div>';
}
function fs_onehalflast_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="oneHalfLast">' . do_shortcode($content) . '</div><div class="clear"></div>';
}
function fs_onethird_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="oneThird">' . do_shortcode($content) . '</div>';
}

function fs_onethirdlast_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="oneThirdLast">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function fs_twothirds_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="twoThird">' . do_shortcode($content) . '</div>';
}

function fs_twothirdslast_shortcode_handler($atts, $content=null, $code="")
{
	return '<div class="twoThirdLast">' . do_shortcode($content) . '</div><div class="clear"></div>';
}

function fs_googlemap_shortcode_handler($atts, $content=null, $code="")
{
	$a = shortcode_atts( array(
		'lat' => "18.003393",
		'lng' => "-76.788687",
		'zoom' => "30",
		'height' => 300
	), $atts );

	$par = "?title=".get_bloginfo("name").'&height='.$a['height'].'&lat='.$a['lat'].'&lng='.$a['lng'].'&zoom='.$a['zoom'];;

	return '<iframe src="'.get_bloginfo("template_url").'/includes/map.php'.$par.'" frameborder="0" style="width: 100%; height: '.$a['height'].'px;">Please upgrade your browser</iframe><br />';
}

function fs_contactform_shortcode_handler($atts, $content=null, $code="")
{	
	return '<form action="" method="post" id="contactform">'."\n"

		.'		<input type="hidden" name="blogname" value="'.get_bloginfo("name").'" />'."\n"

		.'		<div class="validate_entry">'."\n"
		.'			<input type="text" name="name" value="" size="22" tabindex="1" title="Your name*" />'."\n"
		.'			<div class="validate_message" style="display:none">'."\n"
		.'				<div class="validate_ok" style="display:none">'."\n"
		.'					<img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />OK'."\n"
		.'				</div>'."\n"
		.'				<div class="validate_error_empty" style="display:none">'."\n"
		.'					<img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />Enter text'."\n"
		.'				</div>'."\n"
		.'			</div>'."\n"
		.'		</div>'."\n"

		.'		<div class="validate_email">'."\n"
		.'			<input type="text" name="email" value="" size="22" tabindex="2" title="Your e-mail*" />'."\n"
		.'			<div class="validate_message" style="display:none">'."\n"
		.'				<div class="validate_ok" style="display:none">'."\n"
		.'					<img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />OK'."\n"
		.'				</div>'."\n"
		.'				<div class="validate_error_empty" style="display:none">'."\n"
		.'					<img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />Enter text'."\n"
		.'				</div>'."\n"
		.'				<div class="validate_error_email" style="display:none">'."\n"
		.'					<img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />Bad email'."\n"
		.'				</div>'."\n"
		.'			</div>'."\n"
		.'		</div>'."\n"
		
		.'		<input type="text" name="company_name" value="" size="22" tabindex="3" title="Company name" />'."\n"

		.'		<div class="validate_entry">'."\n"
		.'			<input type="text" name="contact-number" value="" size="22" tabindex="4" title="Contact number*" />'."\n"
		.'			<div class="validate_message" style="display:none">'."\n"
		.'				<div class="validate_ok" style="display:none">'."\n"
		.'					<img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />OK'."\n"
		.'				</div>'."\n"
		.'				<div class="validate_error_empty" style="display:none">'."\n"
		.'					<img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />Enter text'."\n"
		.'				</div>'."\n"
		.'			</div>'."\n"
		.'		</div>'."\n"

		.'        <input type="text" name="email" value="" size="22" tabindex="5" title="Contact number 2" />		'."\n"
		
		.'		<div class="validate_entry">'."\n"
		.'            <textarea name="message" cols="100%" rows="10" tabindex="6" title="Message*"></textarea>'."\n"
		.'            <div class="validate_message" style="display:none">'."\n"
		.'                <div class="validate_ok" style="display:none">'."\n"
		.'                    <img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />OK'."\n"
		.'                </div>'."\n"
		.'                <div class="validate_error_empty" style="display:none">'."\n"
		.'                    <img src="'.get_bloginfo('template_url').'/images/error.jpg" alt="" />Enter text'."\n"
		.'                </div>'."\n"
		.'            </div>'."\n"
		.'        </div>'."\n"

		.'		<button type="button" class="validate_button_contact" tabindex="7"'
		.' onclick="sendContactRequest(\'contactform\', \''.get_bloginfo('template_url').'/fs_options/mailsender.php\', \''.get_option(THEMESHORTNAME."_contact_email", "").'\', \'.validate_button_contact\', \'#sending_mail\', \'#mail_success\')">Send message</button>'."\n"
		.'		<div id="sending_mail" style="display:none; height: 29px; margin-top: 7px;"><p>Sending...</p></div>'
		.'		<div id="mail_success" style="display:none; height: 29px; margin-top: 7px;"><p>Message sent.</p></div>'		
		.'	</form>';
}

function fs_code_shortcode_handler($atts, $content=null, $code="")
{
	return '<code>'.$content.'</code>';
}



fs_init_shortcodes();

?>
