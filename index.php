<?php

/**
 *
 * @link              https://www.stauss.de
 * @since             1.0.0
 * @package           Advent_calender
 *
 * @wordpress-plugin
 * Plugin Name:       Advent Calender
 * Plugin URI:        https://www.stauss.de
 * Description:       Calender with 24 magic doors.
 * Version:           1.0.0
 * Author:            Dodiya vijay
 * Author URI:        https://www.stauss.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       adcent-calander
 * Domain Path:       /languages
 */




function Advent_calender_register_settings() {
    
    add_option( 'Advent_calender_option_name', 'This is my option value.');
    register_setting( 'Advent_calender_options_group', 'Advent_calender_option_name', 'Advent_calender_callback' );
   
}
 add_action( 'admin_init', 'Advent_calender_register_settings' );


 function Advent_calender_register_options_page() {
    $aa=add_options_page('Advent Calender', 'Advent Calender', 'manage_options', 'Advent_calender', 'Advent_calender_options_page');
    
    //add_action('admin_print_scripts-settings_page_Advent_calender', 'include_require_script');
    add_action('admin_print_styles-settings_page_Advent_calender', 'include_require_style');
    
}
add_action('admin_menu', 'Advent_calender_register_options_page');

function include_require_script()
{
    wp_register_script('prefix_bootstrap', plugin_dir_url(__FILE__) . 'assets/js/bootstrap.min.js', array('jquery'));
    wp_enqueue_script('prefix_bootstrap');
    wp_enqueue_script('my_custom_table',plugin_dir_url(__FILE__) . 'assets/js/jquery.dataTables.min.js');
    wp_enqueue_script('my_custom_buttons', plugin_dir_url(__FILE__) . 'assets/js/dataTables.buttons.min.js');
    wp_enqueue_script('my_custom_ssjip',plugin_dir_url(__FILE__) . 'assets/js/jszip.min.js');
    wp_enqueue_script('my_custom_make', plugin_dir_url(__FILE__) . 'assets/js/pdfmake.min.js');
    wp_enqueue_script('my_custom_fonts',plugin_dir_url(__FILE__) . 'assets/js/vfs_fonts.js');
    wp_enqueue_script('my_custom_h5buttiond',plugin_dir_url(__FILE__) . 'assets/js/buttons.html5.min.js');
    wp_enqueue_script('my_custom_script', plugin_dir_url(__FILE__) . 'assets/js/admin.js');
    

}
add_action('admin_footer', 'include_require_script');
function include_require_style()
{   
    wp_enqueue_style('my_custom_font', plugin_dir_url(__FILE__) . 'assets/css/font-awesome.min.css'); 
    wp_enqueue_style('my_custom_style', plugin_dir_url(__FILE__) . 'assets/css/admin.css'); 
    wp_register_style('prefix_bootstrap',  plugin_dir_url(__FILE__) . 'assets/css/bootstrap.min.css');
    wp_enqueue_style('prefix_bootstrap');
    wp_enqueue_style('my_custom_datatable', plugin_dir_url(__FILE__) . 'assets/css/jquery.dataTables.min.css'); 
    wp_enqueue_style('my_custom_datatablebt', plugin_dir_url(__FILE__) . 'assets/css/buttons.dataTables.min.css'); 
    wp_enqueue_style('font_icon', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'); 


}
//add_action('admin_enqueue_scripts', 'include_require_style');

function ac_load_js() {
	wp_register_script( 'web_js', plugin_dir_url( __FILE__ ) . 'assets/js/web.js', array('jquery'), null, true );

}
add_action( 'wp_enqueue_scripts', 'ac_load_js');



function Advent_calender_options_page()
{   
    require_once plugin_dir_path( __FILE__ ) .'admin/Admin_class.php';
    $run = new Admin_class();
    $run->Admin_run($_POST);
}
include plugin_dir_path( __FILE__ ) .'includes/db_create.php';
include plugin_dir_path( __FILE__ ) .'includes/db_handler.php';

require_once plugin_dir_path( __FILE__ ) .'public/ac_calander_view.php';
register_activation_hook( __FILE__, 'ac_create_db' );

include plugin_dir_path( __FILE__ ) .'updater.php';


