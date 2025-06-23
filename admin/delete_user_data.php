<?php


include('../../../../wp-load.php');

$id = $_GET['id'];
$table = $table_prefix.'advents_calander_users';
if(isset($_POST['id']) && is_array($_POST['id']))
{
	$ids= implode(",",$_POST['id']);
	$wpdb->query("DELETE from $table where id IN($ids)");
}
if(isset($_GET['id']))
{
	$wpdb->delete( $table, array( 'id' => $id ) );
}
$redirect =  admin_url( "options-general.php?page=Advent_calender&deleted=true" );
header("Location:$redirect");
