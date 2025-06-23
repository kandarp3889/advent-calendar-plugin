<?php


if( ! class_exists( 'mishaUpdateChecker' ) ) {

	class mishaUpdateChecker{

		public $plugin_slug;
		public $version;
		public $cache_key;
		public $cache_allowed;
		

		public function __construct() {

			$this->plugin_slug = 'advance-calendar-plugin-mainkpunt';
			$this->version ='1.0.0';
			$this->cache_key = 'misha_custom_upds';
			$this->cache_allowed = false;

			// add_filter( 'plugins_api', array( $this, 'info' ), 20, 3 );
			add_filter( 'site_transient_update_plugins', array( $this, 'update' ) );
			add_action( 'upgrader_process_complete', array( $this, 'purge' ), 10, 2 );

		}

		public function request(){

			$remote = get_transient( $this->cache_key );

			if( false === $remote || ! $this->cache_allowed ) {
				$key=get_option('WWKEY_custome_plugin_api_key');
				if($key!="")
				{
					$domain=get_site_url();
					$url="https://app.stauss.de/api/plugin?slug=".$this->plugin_slug."&key=".$key."&domain=".$domain;
				
					$remote = wp_remote_get($url,
						array(
							'timeout' => 10,
							'headers' => array(
								'Accept' => 'application/json'
							)
						)
					);
					

					

					if($remote['body']=='false')
					{
						$url="https://app.stauss.de/api/plugin?slug=".$this->plugin_slug;
						$remote = wp_remote_get($url,
							array(
								'timeout' => 10,
								'headers' => array(
									'Accept' => 'application/json'
								)
							)
						);
					}

				}
				else
				{
					$url="https://app.stauss.de/api/plugin?slug=".$this->plugin_slug;
					$remote = wp_remote_get($url,
						array(
							'timeout' => 10,
							'headers' => array(
								'Accept' => 'application/json'
							)
						)
					);


					
				}
				

				if(
					is_wp_error( $remote )
					|| 200 !== wp_remote_retrieve_response_code( $remote )
					|| empty( wp_remote_retrieve_body( $remote ) )
				) {
					return false;
				}

				set_transient( $this->cache_key, $remote, DAY_IN_SECONDS );

			}

			$remote = json_decode( wp_remote_retrieve_body( $remote ) );

			return $remote;

		}

		public function update( $transient ) 
		{

			if ( empty($transient->checked ) ) {
				return $transient;
			}

			$remote = $this->request();



			if(!empty($remote) &&  version_compare( $this->version, $remote->version, '<' ) && version_compare( $remote->requires, get_bloginfo( 'version' ), '<' ) && version_compare( $remote->requires_php, PHP_VERSION, '<' )) 
			{

				$res = new stdClass();
				$res->slug = $this->plugin_slug;
				$res->plugin = plugin_basename( __DIR__ )."/index.php"; // misha-update-plugin/misha-update-plugin.php
				$res->new_version = $remote->version;
				$res->tested = $remote->tested;
				$res->package = $remote->download_url;

				$transient->response[ $res->plugin ] = $res;

		    }
		    else
		    {

		    	return false;

		    }

			return $transient;

		}

		public function purge(){

			if (
				$this->cache_allowed
				&& 'update' === $options['action']
				&& 'plugin' === $options[ 'type' ]
			) {
				// just clean the cache when new plugin version is installed
				delete_transient( $this->cache_key );
			}

		}


	}

	new mishaUpdateChecker();

}

function prefix_plugin_update_message( $data, $response ) {
$obj= new mishaUpdateChecker();
$remote = $obj->request();

			/*echo $remote->download_url;
			exit();*/
			if($remote->download_url=="") {
				
				echo  'Version '.$remote->version.' is a available for update but please provide a valid auth key for update a plugin <a href="'.get_site_url().'/wp-admin/options-general.php?page=Advent_calender">Update plugin key</a>';
	    }
	  

	
}
add_action( 'in_plugin_update_message-'.plugin_basename( __DIR__ ).'/index.php', 'prefix_plugin_update_message', 10, 2 );

?>