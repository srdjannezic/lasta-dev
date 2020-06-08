<?php
/**
 * Plugin Name: Bus Lines Management
 * Plugin URI: 
 * Version: 1.0
 * Author: Srdjan Nezic
 * Author URI: 
 */
$theme_data = get_theme_data(get_stylesheet_directory_uri() . '/style.css');

define('THEMENAME', $theme_data['Title']);
define('THEMESHORTNAME', preg_replace('/[^a-zA-Z0-9]+/', "", strtolower($theme_data['Name'])));
define('FS_OPTIONS_PATH', plugin_dir_path( __FILE__ ) . 'fs_options/'); 
define('FS_OPTIONS_URL', plugin_dir_path( __FILE__ ) . 'fs_options/');

include(FS_OPTIONS_PATH . 'fs_helper_functions.php');
include(FS_OPTIONS_PATH . 'fs_admin_menu.php');
include(FS_OPTIONS_PATH . 'fs_meta_boxes.php');
include(FS_OPTIONS_PATH . 'fs_widgets.php');
include(FS_OPTIONS_PATH . 'fs_display_functions.php');
include(FS_OPTIONS_PATH . 'fs_shortcodes.php');
include(FS_OPTIONS_PATH . 'fs_ajax_calls.php');
include(FS_OPTIONS_PATH . 'import/lasta_import.php');
include FS_OPTIONS_PATH . "fs_lasta_buses.php";


function register_new_buttons($buttons) {
	// register buttons
	array_push($buttons, "|", "crystalmedia");
	array_push($buttons, "|", "add_list");
	array_push($buttons, "|", "add_custom_boxes");
	array_push($buttons, "|", "add_tabs");
	array_push($buttons, "|", "add_hidden_content");
	array_push($buttons, "|", "add_spacing");
	array_push($buttons, "|", "add_dropcap");
	array_push($buttons, "|", "add_pullquote");
	array_push($buttons, "|", "add_button");
	return $buttons;
}



global $wp_roles;
$role = get_role('administrator');
$role ->add_cap("manage_lasta_buses");
$role ->add_cap("manage_import_xsl");
$role ->add_cap("excerpt_content_word_limit");


add_filter( 'login_errors', create_function('$a', "return null;") );