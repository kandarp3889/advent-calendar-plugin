<?php 

include('../../../../wp-load.php');


update_option( 'WWKEY_custome_plugin_api_key',$_POST['plugin_key'] );

$redirect =  admin_url( "options-general.php?page=Advent_calender" );

header("Location:$redirect");
