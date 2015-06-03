<?php
global $wpdb;
global $blog_id;

$prefix=$wpdb->base_prefix;
define('BMMI_PHOTO_TBL', $prefix . $blog_id . 'bmmi_photos');

db_setup();

function db_setup()
{
	global $wpdb;


   	if($wpdb->get_var('show tables like "' . BMMI_PHOTO_TBL . '"') != BMMI_PHOTO_TBL)
   	{
		$setupSql = '
			CREATE TABLE ' . BMMI_PHOTO_TBL . ' (
			ID INT NOT NULL AUTO_INCREMENT ,
			imageurl VARCHAR( 255 ) NOT NULL ,
			imagetitle VARCHAR( 255 ) NOT NULL ,
			imagedescription text NOT NULL ,
			imagelink VARCHAR( 255 ) NOT NULL ,
 			postID int(11) NOT NULL DEFAULT 0,
 			imageorder int(11) NOT NULL DEFAULT 0,
			PRIMARY KEY ( ID )
			) ENGINE = MYISAM ;
        ';
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($setupSql);
	}
}
?>