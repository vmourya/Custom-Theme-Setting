<?php
/*
	Plugin Name: Custom Theme Setting
	Plugin URI: http://vijaymourya.in/wp/cts
    Description: This plugin allow you to make custom fields with various types to set custom theme options.
    Author: Vijay Mourya
    Version: 1.0
    Author URI: http://vijaymourya.in
*/
include("cts-functions.php");
function custom_theme_setting() {
	$table='cts';
	/* CHECK FOR SETTING TABLE AND CREATE IF NOT EXIST */
	if(!check_table($table)){
		cts_create_table($table);
	}
	/* ADDING CST MENU */
	$page_title='Custom Theme Setting';
	$menu_title='Custom Theme Setting';
	$capability=1;
	$menu_slug='custom-theme-setting';
	$function='cst_start';
	$position ='60.1';
	$icon_url='';	
	add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	
	/* ADDING CST SUB MENU TO ADD NEW SETTING */
	$add_setting_title='Setting Values';
	$add_setting_slug='custom-theme-setting.php';
	$add_setting_title='Setting Values';
	$value_function='cst_add_setting';
	add_submenu_page( 'custom-theme-setting', 'Setting fields', 'Setting fields', 'manage_options', 'cts-add-setting', 'cst_add_setting' );
	
	add_submenu_page( 'custom-theme-setting', 'Setting Sections', 'Setting Sections', 'manage_options', 'cts-add-section', 'cst_add_section' );
	cts_init();
}
add_action('admin_menu', 'custom_theme_setting');

function cts_init(){
	define( 'CTS_DIR', plugin_dir_url(__FILE__) );
	cts_include_scripts();
	cts_inlude_styles();
}
function cts_include_scripts(){
	wp_enqueue_script('cts-cleditor', CTS_DIR .'cts-files/editor/jquery.cleditor.min.js');
	wp_enqueue_script('cts-function', CTS_DIR .'cts-files/js/cts-function.js');
}
function cts_inlude_styles(){
	wp_enqueue_style('cts-cleditor-style', CTS_DIR .'cts-files/editor/jquery.cleditor.css');
	wp_enqueue_style('cts-style', CTS_DIR .'cts-files/css/cts-style.css');
}
function cts_setting($key=''){
	$result=array();
	$data=get_setting($key);
	foreach($data as $row){
		$result[$row->key]=htmlspecialchars_decode(stripslashes($row->value));
	}
	return $result;
}
function cts_setting_value($key=''){
	$result='';
	if($key){
		$data=get_setting($key);
		$result=htmlspecialchars_decode(stripslashes($data[0]->value));
		
	}
	return $result;
}
?>