<?php
/*
UPDATED VERSION 1.0
by Rhod

DO ALTER AS SETS AND NOT JUST ADD NEW FIELDS INSIDE THE $alterSql variable.
*/

	global $wpdb;
	if($wpdb->get_var('show tables like "' . BMMI_PHOTO_TBL . '"') == BMMI_PHOTO_TBL)
   	{
		$alterSql = '
			ALTER TABLE ' . BMMI_PHOTO_TBL . ' 
			ADD thumburl VARCHAR( 255 ) NOT NULL AFTER imageurl';
		$wpdb->query($alterSql);
	}

?>