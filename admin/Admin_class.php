<?php 


class Admin_class
{
    public function index($postdata)
    {      
            if(isset($postdata['promocode']))
            {   global $wpdp;
                $postid="";
                $post =  get_page_by_title( 'unique_post_for_advert_calender', OBJECT, 'adevert_calender');
                        
                if(empty($post))
                {
                    $my_post = array(
                        'post_title'    => "unique_post_for_advert_calender",
                        'post_content'  => "",
                        'post_status'   => 'publish',
                        'post_author'   => 1,
                        'post_type'     => "adevert_calender",
                    );
                    $postid = wp_insert_post( $my_post );
                }
                else
                {
                    $postid=$post->ID;
                } 
                if ( get_post_meta($postid, 'advents_day-'.$postdata['dayid'],true )) {
                    
                    update_post_meta( $postid,  'advents_day-'.$postdata['dayid'],wp_kses_post($postdata['promocode']));
                }
                else
                {
                    add_post_meta( $postid, 'advents_day-'.$postdata['dayid'], wp_kses_post($postdata['promocode']) , true );
                }  
                
            }

            if(isset($_FILES['dImage']['name']))
            {   
                global $wpdp;
                $postid="";
                $post =  get_page_by_title( 'unique_post_for_advert_calender', OBJECT, 'adevert_calender');
                if(empty($post))
                {
                    $my_post = array(
                        'post_title'    => "unique_post_for_advert_calender",
                        'post_content'  => "",
                        'post_status'   => 'publish',
                        'post_author'   => 1,
                        'post_type'     => "adevert_calender",
                    );
                    $postid = wp_insert_post( $my_post );
                }
                else
                {
                    $postid=$post->ID;
                } 
                if ( get_post_meta($postid, 'image_day-'.$postdata['dayid2'],true )) {
                    $path = wp_upload_dir();

                    // $target = '../assets'.basename($_FILES['dImage']['name']);
                    $target = $path['path'].'/'. basename($_FILES['dImage']['name']);
                    if(move_uploaded_file($_FILES['dImage']['tmp_name'], $target)) {
                        update_post_meta( $postid,  'image_day-'.$postdata['dayid2'],wp_kses_post($_FILES['dImage']['name']));
                    }
                }
                else
                {
                    $path = wp_upload_dir();

                    $target = $path['path'].'/'. basename($_FILES['dImage']['name']);
                    // $target = plugin_dir_url( __DIR__ ).'assets/images/'.basename($_FILES['dImage']['name']);
                    if(move_uploaded_file($_FILES['dImage']['tmp_name'], $target)) {
                        add_post_meta( $postid, 'image_day-'.$postdata['dayid2'], wp_kses_post($_FILES['dImage']['name']) , true );
                    }
                    
                }  
                
            }
    }

  

    public function Setting_page()
    {


    ?>
        <h1 style="text-align:center;margin-top:40px;margin-bottom:0px;">Adventskalender </h1>
        <div style="text-align:center;margin-top:0px;margin-bottom:80px;"> Shortcode: [advents_calander]</div>
        <?php 
        
        if(isset($_GET['deleted']))
        {
            echo '<div class="delete_msg">Datensatz wurde gelöscht.</div>';

        }
        ?>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item active">
                <a class="nav-link active" id="key-tab" data-toggle="tab" href="#key" role="tab" aria-controls="key"
                aria-expanded="true">Plugin key</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-expanded="true">Adventskalender</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                aria-selected="false">Nutzerdaten</a>
            </li> 
            </ul>
        <div class="tab-content" id="myTabContent">
             <div class="tab-pane fade active  in" id="key" role="tabpanel" aria-labelledby="key-tab"> 
              <div class="wrap">
    <br>
        <form id="version_form" name="version_form" enctype="multipart/form-data" action="<?php echo plugin_dir_url( __FILE__ ) ?>save_key.php" method="post">
        <table class="wp-list-table widefat fixed striped table-view-list toplevel_page_usernotification view" style="width:50%">
            <tr>
                <th style="width:30%">Add Plugin Api Key<b></b></th>
                <td><input type="text" name="plugin_key" id="playstore_version" value="<?php echo get_option('WWKEY_custome_plugin_api_key'); ?>" class="form-control" style="width:100%"></td>
            </tr>
            
            <tr>
                <td colspan="2"><br><input type="submit" id="save_data" value="Save"></td>
            </tr>
        </table>
      </form>
       
         <!--<input type="submit" name="Submit" id="save" value="Save" />-->

</div>

            </div>
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab"> 
                <?php
						$post =  get_page_by_title( 'unique_post_for_advert_calender', OBJECT, 'adevert_calender');
                        $path = wp_upload_dir();
						
						$metaImg1 = get_post_meta( $post->ID, 'image_day-999', true );	?>
				<div class="main_box" style="background-repeat: no-repeat;background-attachment: fixed;background-position: center;background-image:url(<?php echo esc_url($path['baseurl']). '/2021/11/'.$metaImg1 ?>);">
						
					 <!--  <i class="editImage 1234" data-id="999" data-image="<?php // echo esc_url($path['baseurl']). '/2021/11/'.$metaImg1 ?>">Edit Profile</i>
						<br>-->
						<?php

                       
                        // print_r($path);
                        // echo $_SERVER['DOCUMENT_ROOT'];
                        for($i=1;$i<=24;$i++)
                        {
                            
                            $meta = get_post_meta( $post->ID, 'advents_day-'.$i, true );
                            $metaImg = get_post_meta( $post->ID, 'image_day-'.$i, true );

                                if($metaImg)
                                {
                                    echo '<div id="box'.$i.'"  class="box" style="background-image:URL(\''.esc_url($path['baseurl']). '/2021/11/'.$metaImg.'\')">';
                                    echo '<i class="editImage 1234" data-id="'.$i.'" data-image="'.esc_url($path['baseurl']). '/2021/11/'.$metaImg.'"">Bild bearbeiten</i><br>';
                                }
                                else
                                {
                                    echo '<div id="box'.$i.'"  class="box" style="background-image:URL(\''.plugin_dir_url( __DIR__ ) . 'assets/images/Tuer'.$i.'.svg\')">';
                                    echo '<i class="editImage 1234" data-id="'.$i.'" data-image="'.plugin_dir_url( __DIR__ ) . 'assets/images/Tuer'.$i.'.svg">Bild bearbeiten</i><br>';
                                }
                                
                                if($meta != "") { 
                                    echo '<i class="editbox opendbox" data-id="'.$i.'">Geschenk ändern</i></div>';
                                    echo '<textarea style="display:none;" id="boxcontent'.$i.'">'.$meta.'</textarea>';   
                               
                                }
                                else
                                {
                                    echo '<i class="editbox" data-id="'.$i.'">Geschenk hinzufügen</i></div>';
                                }
                        }
                        ?>
                </div>
                <div class="promopopup" style="display:none;">
                    <div class="promobox">
                        <form action="" method="post"> 
                            <div class="promcode_header">
                            Geschenk eingeben<i class="fa fa-times-circle promoclose" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                            <?php 
                            wp_editor( '', 'promocode', $settings = array('textarea_rows'=> '10') );
                            ?>

                            <input type="hidden" value="" class="dayid" name ="dayid">
                            </div>                            
                            <div class="Footer">
                            <button class="btn btn-primary">Speichern</button>
                            </div>
                        </form>
                    </div>
                        
                </div>
                <div class="propEditImage" style="display:none;">
                    <div class="promobox">
                        <form action="" method="post" enctype="multipart/form-data"> 
                            <div class="promcode_header">
                            Geschenk eingeben<i class="fa fa-times-circle promoclose" aria-hidden="true"></i>
                            </div>
                            <div class="content">
                                <center>
                                    <img src="" id="old_img" width="150px">
                                    <input type="file" name="dImage">
                                </center>
                            <input type="hidden" value="" class="dayidIm" name ="dayid2">
                            </div>                            
                            <div class="Footer">
                            <button class="btn btn-primary">update</button>
                            </div>
                        </form>
                    </div>
                        
                </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <form id="custom123" method="post" action="<?php echo plugin_dir_url( __FILE__ ); ?>delete_user_data.php">
            <table id="userdata" width="100%">
                <thead>
                    <tr>
                        <td><input type="checkbox" id="checkAll" onclick="toggle(this);"></td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Zeit</td>
                        <td>Ausgewählter Tag</td>
                        <td>Handlung</td>
                    </tr>
                </thead>
                <tbody>
                <?php
                global $wpdb;
                $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}advents_calander_users", OBJECT );
                foreach($results as $key=>$value)
                {
                    echo '<tr><td><input type="checkbox" name="id[]" value="'.$value->id.'"></td>';
                    echo '<td>'.$value->name.'</td>';
                    echo '<td>'.$value->email.'</td>';
                    echo '<td>'.$value->time.'</td>';
                    echo '<td>Tag '.$value->dayid.'</td>';
                    /*echo '<td><a href="'.plugin_dir_url( __FILE__ ).'delete_user_data.php?id='.$value->id.'"><span class="dashicons dashicons-trash"></span></a></td></tr>';*/


                    echo '<td><a onclick="javascript:confirmationDelete(jQuery(this));return false;" href="'.plugin_dir_url( __FILE__ ).'delete_user_data.php?id='.$value->id.'"><span class="dashicons dashicons-trash"></span></a></td></tr>';
                    
                }
                ?>
                </tbody>
            </table>
            <input type="submit" value="Delete selected" onclick="check(this)">
            </form>
        </div>
            
        
<?php
    }

    public function Admin_run($post)
    {   

        $this->index($post);
        $this->Setting_page();
    }




}


function lh_add_livechat_js_code() {
?>

<script type="text/javascript">
    function confirmationDelete(anchor)
    {
       var conf = confirm('Are you sure want to delete this record?');
       if(conf)
          window.location=anchor.attr("href");
    }
</script>
    
<?php
}
add_action( 'admin_footer', 'lh_add_livechat_js_code' ); // For back-end


/*add_action( 'wp_ajax_savedataversion', 'my_KEY_save' );

add_action( 'wp_ajax_nopriv_savedataversion', 'my_KEY_save' );

function my_KEY_save() 
{
  
    global $wpdb;
    update_option( 'WWKEY_custome_plugin_api_key',$_POST['plugin_key'] );
    exit();
    
}*/

