<?php
function query_Table($tablename,$condition="",$custom_query="")
{
    global $wpdb;
	if($custom_query != "")
	{
    	$posts_qry = $wpdb->get_results($custom_query);
	}
	else
	{
    	$posts_qry = $wpdb->get_results("SELECT * FROM $tablename $condition");
	}
	return json_encode($posts_qry);
}

function query_GetFieldInfo($tablename,$condition="",$field)
{
    global $wpdb;
	$fvalue = "";
	$output = $wpdb->get_results("SELECT * FROM $tablename $condition");
	foreach ($output as $name => $value)
	{
		$fvalue = $value->$field;
	}
	return $fvalue;
}


function count_POST($table_name,$conditionqry="",$parameters="")
{
	global $wpdb;
	$pcount = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM " . $table_name . " " . $conditionqry,$parameters));
	return $pcount;
}
?>