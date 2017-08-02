<?php 
/* CTS START HERE */
function cst_start(){
	if(isset($_POST['submit'])){
		if(isset($_FILES)){
			$filesUploaded=save_files($_FILES);
		}
		$result=cts_save_setting_values($_POST);
	}
	include("cts-settings.php");
}

/* ADD SECTION */
function cst_add_section(){
	$name=$key=$description=$secsid='';
	$type=1;
	$result='';
	if(isset($_POST['submit'])){
		$name=$_POST['cts-section-name'];
		$key=$_POST['cts-section-key'];
		$description=$_POST['cts-section-description'];
		$result=cts_save_section($_POST);
		if($result['sts']==1){
			$name=$key=$description=$secsid='';
		}
		$result=$result['msg'];
	}else{
		if(isset($_REQUEST['action'])){
			$action=$_REQUEST['action'];
			$secsid=$_REQUEST['secsid'];
			if($action==0){
				$result = delete_section($secsid);
				$secsid='';
			}elseif($action==1){
				$cts_section=get_sections($secsid);
				if($cts_section){
					$name=$cts_section[0]->name;
					$key=$cts_section[0]->key;
					$description=$cts_section[0]->description;				
				}
			}
		}
	}
	include("cts-sections.php");
}

/* DELETE SECTION */
function delete_section($sid=0){
	global $wpdb;
	$table=$wpdb->prefix .'cts_sections';
	if($sid){
		$wpdb->delete($table, array('id' => $sid));
		$name=$key=$description=$secsid='';
		$msg= '<span class="success">Section has been deleted.</span>';
	}
	return $msg ;
}

/* GET SECTIONS INFORMATION */
function get_sections($secid=''){
	global $wpdb;
	$table=$wpdb->prefix .'cts_sections';
	$query = ($secid) ? "SELECT * FROM $table where `id`='$secid'" : "SELECT * FROM $table";
	$rows = $wpdb->get_results($query);
	return $rows;
}
/* GETTING FIELD FROM TABLE */
function cts_get_field($id=0,$table='',$key=''){
	global $wpdb;
	$result='';
	$table=$wpdb->prefix . $table;
	$query = ($key) ? "SELECT $id FROM $table where `key`='$key'" : "SELECT $id FROM $table";
	$rows = $wpdb->get_results($query);
	if(!empty($rows)){
		foreach($rows as $row)
		{
			$result=$row->id;
		}
	}
	return $result;
}

/* GET SETTIGN BY SECITON */
function cts_section_fields($key=''){
	$result='';
	if($key){
		$sid=cts_get_field('id','cts_sections',$key);
		$result = get_section_fields($sid);
	}else{
		$result=get_setting();
	}
	return $result;
}

/* SAVING SETTING SECTIONS */
function cts_save_section($post=array()){
	$key=trim($post['cts-section-key']);
	$msg='';
	$sts=0;
	global $wpdb;
	$table_name=$wpdb->prefix . 'cts_sections';
	if(!$key):
		$msg= '<span class="error">Please enter name</span>';
		$sts=0;
	endif;
	if(!$msg) {
		if($post['cts-section-id']){
			$wpdb->update($table_name,array( 'name' => $post['cts-section-name'], 'key' => $post['cts-section-key'], 'description' => $post['cts-section-description']),array('id' => $post['cts-section-id']));
			$sts=1;
			$msg= '<span class="success">Setting has been  updated.</span>';
		}else{
			if(!check_section($key)){
				$wpdb->insert( $table_name, array( 'name' => $post['cts-section-name'], 'key' => $post['cts-section-key'], 'description' => $post['cts-section-description'] ));
				$msg='<span class="success">Setting Section has been added</span>';
				$sts=1;
			}else{
				$msg='<span class="error">This Section already exist.</span>';
				$sts=0;
			}
		}	
	}
	return array('sts'=>$sts,'msg'=>$msg);
}
/* UPDATING VALUE OF SETTING */
function update_cts($key='', $val=''){
	global $wpdb;
	$table=$wpdb->prefix .'cts';	
	//$val=htmlentities($val);
	$wpdb->update($table,array('value' => $val),array('key' => $key));
}
/* SAVING ALL FILES IN FOLDER AND DB */
function save_files($files=array()){	
	if ( ! function_exists( 'wp_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
	}
	foreach($files as $file_key => $file){
		$uploadedfile = $file;
		$upload_overrides = array( 'test_form' => false );
		$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
		if ( $movefile && !isset( $movefile['error'] ) ) {
			//echo "File is valid, and was successfully uploaded.\n";
			$file_url=$movefile['url'];
			update_cts($file_key,$file_url);
		} else {
			echo $movefile['error'];
		}
	}
}
/* SAVING ALL SETTING VALUES */
function cts_save_setting_values($post=array()){
	$result='<span class="success">Settings updated successfully.</span>';
	foreach($post as $key =>  $value){
		$value=htmlspecialchars($value);
		update_cts($key,$value);
	}
	return $result;
}

function cst_add_setting(){
	$name=$key=$description=$ctsid='';
	$type=1;
	$sid=0;
	$result='';
	if(isset($_POST['submit'])){
		$name=$_POST['cts-name'];
		$key=$_POST['cts-key'];
		$type=$_POST['cts-type'];
		$description=$_POST['cts-description'];
		$sid=$_POST['cts-section'];
		$result=add_setting($_POST);
		if($result['sts']==1){
			$name=$key=$description=$ctsid='';
			$type=1;
			$sid=0;
		}
		$result=$result['msg'];
	}else{
		if(isset($_REQUEST['action'])){
			$action=$_REQUEST['action'];
			$ctsid=$_REQUEST['ctsid'];
			if($action==0){
				$result = delete_cts($ctsid);
				$ctsid='';
			}elseif($action==1){
				$cts_key=get_cts_key($ctsid);
				$get_setting=get_setting($cts_key);
				if($get_setting){
					$name=$get_setting[0]->name;
					$type=$get_setting[0]->type;
					$key=$get_setting[0]->key;
					$description=$get_setting[0]->description;	
					$sid=$get_setting[0]->section_id;
				}
			}
		}
	}
	$sections=get_sections();
	include("cts-setting-fields.php");
}
/* DELETING CTS SETTING */
function delete_cts($ctsid=''){
	global $wpdb;
	$table=$wpdb->prefix .'cts';
	if($ctsid){
		$wpdb->delete($table, array('id' => $ctsid));
		$name=$key=$description=$ctsid='';
		$type=1;
		$msg= '<span class="success">Setting has been deleted.</span>';
	}
	return $msg ;
}

/* GETTING KEY FOR CTS ID */
function get_cts_key($ctsid=''){
	global $wpdb;
	$result='';
	$table=$wpdb->prefix .'cts';
	$rows = $wpdb->get_results( "SELECT `key` FROM $table where `id`=$ctsid");
	$result=$rows[0]->key;
	return $result;
}

function check_key($key=''){
	global $wpdb;
	$result=false;
	$table=$wpdb->prefix .'cts';
	$rows = $wpdb->get_results( "SELECT * FROM $table where `key`='$key'");
	if(!empty($rows)){
		$result=true;
	}
	return $result;
}
/* CHECKING SECTION FOR ALREADY EXISTING OR NOT */
function check_section($key=''){
	global $wpdb;
	$result=false;
	$table=$wpdb->prefix .'cts_sections';
	$rows = $wpdb->get_results( "SELECT * FROM $table where `key`='$key'");
	if(!empty($rows)){
		$result=true;
	}
	return $result;
}
/* Add setting */
function add_setting($post=array()){
	$key=trim($post['cts-key']);
	$msg='';
	$sts=0;
	global $wpdb;
	$table_name=$wpdb->prefix . 'cts';
	if(!$key):
		$msg= '<span class="error">Please enter name.</span>';
		$sts=0;
	elseif($post['cts-section']<1):
		$msg= '<span class="error">Please select section.</span>';
		$sts=0;		
	endif;
	if(!$msg) {
		if($post['cts-id']){
			$wpdb->update($table_name,array( 'name' => $post['cts-name'], 'key' => $post['cts-key'], 'type' => $post['cts-type'], 'value' => '', 'description' => $post['cts-description'],'section_id' => $post['cts-section']),array('id' => $post['cts-id']));
			$sts=1;
			$msg= '<span class="success">Setting has been  updated.</span>';
		}else{
			if(!check_key($key)){
				$wpdb->insert( $table_name, array( 'name' => $post['cts-name'], 'key' => $post['cts-key'], 'type' => $post['cts-type'], 'value' => '', 'description' => $post['cts-description'],'section_id' => $post['cts-section'] ));
				$msg='<span class="success">Setting Field has been added</span>';
				$sts=1;
			}else{
				$msg='<span class="error">This setting field already exist.</span>';
				$sts=0;
			}
		}	
	}
	return array('sts'=>$sts,'msg'=>$msg);
}
/* GET SETTING(s) */ 
function get_setting($key=''){
	global $wpdb;
	$table=$wpdb->prefix . 'cts';
	$query = ($key) ? "SELECT * FROM $table where `key`='$key'" : "SELECT * FROM $table";
	$rows = $wpdb->get_results( $query );
	return $rows;
}
/* GETTING FIELDS FOR SECTION */
function get_section_fields($sid=0){
	global $wpdb;
	$table=$wpdb->prefix . 'cts';
	$query = "SELECT * FROM $table where `section_id`='$sid'";
	$rows = $wpdb->get_results( $query );
	return $rows;	
}
/* Checking cts table in database */
function check_table($table=''){
	global $wpdb;
	$result=true;
	$table_name = $wpdb->prefix . $table;
	if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		$result=false;
	}
	return $result; 
}
function cts_create_table($table=''){
	global $wpdb;
	/* CREATING MAIN CTS TABLE */
	$table_name = $wpdb->prefix . $table;
	$charset_collate = $wpdb->get_charset_collate();
	$sql = "CREATE TABLE $table_name (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`section_id` INT(11) NULL DEFAULT NULL,
	`name` VARCHAR(255) NULL DEFAULT NULL,
	`key` VARCHAR(255) NULL DEFAULT NULL,
	`type` INT(11) NULL DEFAULT NULL,
	`value` LONGTEXT NULL,
	`description` LONGTEXT NULL,
	PRIMARY KEY (`id`)
	)$charset_collate;";
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
	
	/* CREATING SECTION TABLE */
	if(!check_table('cts_sections')){
		$table_name = $wpdb->prefix . 'cts_sections';
		$charset_collate = $wpdb->get_charset_collate();
		$sql = "CREATE TABLE $table_name (
		`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		`name` VARCHAR(255) NULL DEFAULT NULL,
		`key` VARCHAR(255) NULL DEFAULT NULL,
		`description` LONGTEXT NULL,
		PRIMARY KEY (`id`)
		)$charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );		
	}
}

/* CREATING SHORTCODE FOR USER */

add_shortcode( 'cts', 'cts_get_value' );
function cts_get_value($atts){
		$atts = shortcode_atts( array(
		'key' => ''
	), $atts, 'cts' );
	
	echo cts_setting_value($atts['key']);
}
?>