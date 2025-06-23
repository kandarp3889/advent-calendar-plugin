<?php

class Front_View {

	public function Load_Css_Js() {
		wp_enqueue_style( 'load-fa', plugin_dir_url( __DIR__ ) . 'assets/css/font-awesome.min.css' );
		wp_enqueue_style( 'load-custome-css', plugin_dir_url( __DIR__ ) . 'assets/css/web.css' );
		wp_enqueue_style( 'load-magic-css', plugin_dir_url( __DIR__ ) . 'magic-master/dist/magic.min.css' );
        wp_enqueue_style( 'dashicons-css','/wp-includes/css/dashicons.min.css' );
        

	}

	public function index() {
		?>
        <div class="advents_calender">
            <div class="calender_header">
			<?php
			$post =  get_page_by_title( 'unique_post_for_advert_calender', OBJECT, 'adevert_calender');
             $path = wp_upload_dir();
			 
			 $metaImg1 = get_post_meta( $post->ID, 'image_day-999', true );
			?>
			<?php
			if($metaImg1 != '')
			{
				?>
				<img class="merry" src="<?php echo esc_url($path['baseurl']). '/2021/11/'.$metaImg1 ?>">
				<?php
			}
			else
			{
				?>  <img class="merry" src="<?php echo plugin_dir_url( __DIR__ ); ?>assets/images/Merry.svg"> <?php
			}
              ?>  
                <h3 class="subheding">Jeden Tag im Advent ein ganz besonderes Geschenk für Dich.</h3>
            </div>
            <div class="main_calender_box">
				<?php
                for ( $i = 1; $i <= 24; $i ++ ) {

					$meta = get_post_meta( $post->ID, 'advents_day-' . $i, true );
                    $metaImag = get_post_meta( $post->ID, 'image_day-' . $i, true );
                    if($metaImag)
                    {
                        $imgPath = esc_url($path['baseurl']). '/2021/11/'.$metaImag;
                    }
                    else
                    {
                        $imgPath = plugin_dir_url( __DIR__ ) . 'assets/images/Tuer' . $i . '.svg';
                    }
					$is_admin = current_user_can( 'manage_options' );
					if ( $meta != "" || $is_admin ) {
					if ( $i == date( 'd' )  || $is_admin ) {
							echo '<div class="innerc box"  id="box' . $i . '" data="' . $i . '"><div class=" magictime  openedbox" style="background-image:URL(\'' .$imgPath.'\');cursor:pointer;"></div></div>';
						} else {
							
							echo '<div id="box' . $i . '"  class="box openblankbox" style="background-image:URL(\'' .$imgPath.'\')"></div>';
						}
					} else {

                        if ($i == date( 'd' )) 
                        {
                            echo '<div class="innerc box"  id="box' . $i . '" data="' . $i . '"><div class=" magictime  openedbox" style="background-image:URL(\'' .$imgPath.'\');cursor:pointer;"></div></div>';
                        }
                        else
                        {
                            echo '<div id="box' . $i . '"  class="box openblankbox" style="background-image:URL(\'' .$imgPath.'\')"></div>';
                        }
						
					}
				}
				?>
            </div>
        </div>
        <div class="snowflakes" aria-hidden="true">
			<?php for ( $i = 1; $i <= 400; $i ++ ) { ?>
                <div class="snowflake" style="color:#fff;">
                    ❅
                </div>

			<?php } ?>
        </div>

        <div class="promopopup" style="display:none;">
            <div class="promobox">
                <form action="" id="ac-userform" onsubmit="return false;" method="post">
                    <div class="promcode_header">
                        Nur noch einen Schritt bis zu Deinem Geschenk <span class="dashicons dashicons-dismiss promoclose"></span>
                    </div>
                    <div class="content">
                        <input type="text" value="" required class="form-control promocode user_name" name="user_name"
                               placeholder="Bitte gib Deinen Namen ein">

                        <input type="email" value="" required class="form-control promocode user_email"
                               name="user_email" placeholder="Bitte gib Deine Email ein.">
                        <input type="hidden" value="" class="dayid" name="dayid">
                        <input type="hidden" value="<?php echo get_site_url(); ?>" class="requesturl" name="requesturl">
                        <div class="checkboxdiv">

                            <div class="iunputbox">
                                <input type="checkbox" name='meiner' required>
                            </div>
                            <div class="inputcontyent">
                                Ich stimme der Verarbeitung meiner personenbezogenen Daten zu und habe die
                                Datenschutzerklärung gelesen
                            </div>
                            <div class="iunputbox">
                                <input type="checkbox" name='meiner' id="meiner">
                            </div>
                            <div class="inputcontyent">
                                Ich willige ein, in regelmäßigen Abständen Angebote per E-Mail zu erhalten. Dies kann
                                ich jederzeit wieder abbestellen.
                            </div>
                        </div>


                    </div>
                    <div class="Footer">
                        <button type="submit" class="btnget_offer">Zu Deinem Geschenk</button>
                    </div>
                </form>
            </div>
            <div class="promoboxsucess" style="display:none">
                <div class="promcode_header">
                    Hinter Deinem Adventstürchen befindet sich: <span class="dashicons dashicons-dismiss promosucessclose"></span>
                </div>
                <div class="content promosucess">

                </div>

            </div>

        </div>
        </div>
		<?php
	}

	public function Run_view() {
		$this->Load_Css_Js();
		$this->index();
	}
}

add_shortcode( 'advents_calander', 'advents_calander_function' );
function advents_calander_function() {
	$runview = new  Front_View();
	$runview->Run_view();
}

function load_js() {
    ?>


<script src="<?php echo  plugin_dir_url(__DIR__) . 'assets/js/web.js';?>" id='jquerycalender-js'></script>

<?php
}
add_action( 'wp_footer', 'load_js');