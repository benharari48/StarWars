<?php
/**
* Plugin Name: StarWars
* Plugin URI: https://www.your-site.com/
* Description: Test by Ben Harari. <br> Add this shortcode to your page "[myStarWars]"
* Version: 0.1
* Author: Ben Harari
* Author URI: https://www.your-site.com/
**/


/**
* StarWars
*/
class StarWars
{
	
	function __construct()
	{

		add_action( 'wp_ajax_StarWarsData', [$this,'getData'] );    // If called from admin panel

		add_action( 'wp_ajax_nopriv_StarWarsData', [$this,'getData'] );    // If called from front end

		add_action( 'wp_enqueue_scripts', [$this,'StarWarsScripts'] );

		add_action( 'wp_enqueue_scripts', [$this,'StarWarsStyle'] );

		add_shortcode('myStarWars', [$this,'StarWarsHtml']);

	}

	public function StarWarsHtml() { 
	  
	  	ob_start();

		include 'html/index.php';

		$buffer = ob_get_clean();

		return $buffer;

	}
	public function getData()
	{

		try {
			
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://swapi.dev/api/starships/',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			));

			$response = curl_exec($curl);

			if(!$response) return 'could not connect to API';

			curl_close($curl);

			echo $response;

			exit();

		} catch (Exception $e) {
			
			echo $e;

			exit();


		}

	}
	public function StarWarsScripts() {

		wp_register_script( 'vue-js', 'https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js', false ,'3.3.1', true );
		wp_enqueue_script( 'vue-js' );

		wp_register_script( 'vuetify-js', 'https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js', false ,'3.3.1', true );
		wp_enqueue_script( 'vuetify-js' );

		wp_register_script( 'master-js',  plugin_dir_url(__FILE__).'/html/js/master.js', array( ), '3.3.1' , true );
		wp_enqueue_script( 'master-js' );

		wp_localize_script( 'master-js', 'myData',
			array( 
				'url' => admin_url( 'admin-ajax.php' )
			)
		);

	}
	public function StarWarsStyle() {

		wp_register_style( 'googleapis-css','https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900'   );
		wp_enqueue_style( 'googleapis-css' );

		wp_register_style( 'materialdesignicons-css','https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css'   );
		wp_enqueue_style( 'materialdesignicons-css' );

		wp_register_style( 'vuetify-css','https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css'   );
		wp_enqueue_style( 'vuetify-css' );

	}


}
new StarWars();