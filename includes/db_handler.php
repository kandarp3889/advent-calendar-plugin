<?php
class db_handler
{
    public function insert_form_data($formdata)
    {   if(!filter_var($formdata['email'], FILTER_VALIDATE_EMAIL) && $formdata['name'] !="" )  return '0';
        
        global $wpdb;
        $post_id = $wpdb->get_results("SELECT * FROM ". $wpdb->prefix."advents_calander_users WHERE email = '".$formdata['email']."' AND time  like '%".date('Y-m-d')."%'");

        if(!empty($post_id)) return '1';

       
        $terms="1";
        $rule = "1";
        $table = $wpdb->prefix.'advents_calander_users';
        $data = array(
                        'id' => null,
                        'name' => $formdata['name'],
                        'email' => $formdata['email'],
                        'terms' =>$terms,
                        'rule' => $rule,
                        'dayid' => $formdata['dayid'],
                        'time' =>date("Y-m-d H:i:s")
                    );
        $format = array('%s','%s');
        $wpdb->insert($table,$data,$format);
        $my_id = $wpdb->insert_id;
        
        if($my_id){
            $post =  get_page_by_title( 'unique_post_for_advert_calender', OBJECT, 'adevert_calender');
            $meta = get_post_meta( $post->ID, 'advents_day-'.$formdata['dayid'], true ); 
            return $meta;                               
        }
        else
        { 
              return $my_id;
        }

    }
}


function handel_form()
{   $data = $_POST;
    $ajax = new db_handler();
    $response = $ajax->insert_form_data($data);
    echo ltrim($response);
    die();
}
add_action( 'wp_ajax_nopriv_ac_form_data', 'handel_form' );
add_action('wp_ajax_ac_form_data', 'handel_form');