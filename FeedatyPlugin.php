<?php


/**
 * Plugin Name: FeedatyPlugin
 * Description: Questo plugin permette l'interazione tra WooCommerce e la piattaforma di recensioni certificate Feedaty.
 * Version: 2.0.6
 * Author: Zoorate
 * Author URI: http://zoorate.com
 * Requires : woocommerce
 * Requires at least: 3.0.0
 * Tested up to: 4.7.2
 * 
 * @author Zoorate
 */


$FEEDATY_PERCORSOPLUGIN = plugin_dir_path( __FILE__ );

// Exit if accessed directly
if (! defined ( 'ABSPATH' )) exit (); 


if (! class_exists ( 'FeedatyPlugin' )) :

	/**
	 * Main plugin Class
	 *
	 * @version 2.0.6
	 */

	class FeedatyPlugin {

		/**
		 *
		 * @var string
		 */
		public $version = '2.0.6';
		public $id = 'feedaty-plugin';

		/**
		 *
		 * @var self L'istanza singola della classe
		 */
		protected static $_instance = null;

		// protected $plugin_path;



		/**
		 * Recupera l'oggetto
		 *
		 * @static
		 *
		 * @return FeedatyPluginPlugin
		 */

		public static function instance() {

			if (is_null ( self::$_instance )) self::$_instance = new self ();

			return self::$_instance;

		}

		

		/**
		 * Cloning is forbidden.
		 */

		public function __clone() {

			_doing_it_wrong ( __FUNCTION__, __ ( 'Cheatin&#8217; huh?', 'woocommerce' ), '2.1' );

		}

		

		/**
		 * Unserializing instances of this class is forbidden.
		 */

		public function __wakeup() {

			_doing_it_wrong ( __FUNCTION__, __ ( 'Cheatin&#8217; huh?', 'woocommerce' ), '2.1' );

		}

		protected function __construct() {

			$this->register_autoload ();
			$this->init ();

		}

		protected function register_autoload() {

			if (function_exists ( "__autoload" )) spl_autoload_register ( "__autoload" );

			spl_autoload_register ( array ($this,'autoload' ) );

		}


		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */

		public function plugin_path() {

			return untrailingslashit ( plugin_dir_path ( __FILE__ ) );

		}

		

		/**
		 * An example of a project-specific implementation.
		 *
		 * After registering this autoload function with SPL, the following line
		 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
		 * from /path/to/project/src/Baz/Qux.php:
		 *
		 * new \Foo\Bar\Baz\Qux;
		 *
		 * @param string $class
		 *        	The fully-qualified class name.
		 * @return void
		 */

		public function autoload($class) {

			$path = $this->plugin_path () . '/lib/';

			// project-specific namespace prefix
			$prefix = '';

			// base directory for the namespace prefix
			$base_dir = $path;

			// does the class use the namespace prefix?
			$len = strlen ( $prefix );

			// no, move to the next registered autoloader
			if (strncmp ( $prefix, $class, $len ) !== 0) return;

			// get the relative class name
			$relative_class = substr ( $class, $len );

			// replace the namespace prefix with the base directory, replace namespace
			// separators with directory separators in the relative class name, append
			// with .php

			$file = $base_dir . str_replace ( '\\', '/', $relative_class ) . '.php';

			// if the file exists, require it
			if (file_exists ( $file )) require $file;

		}


		public function addCss() {

			wp_register_style ( 'cw-star-viewer', plugins_url().'/feedaty-plugin/css/style.css' );
			wp_enqueue_style ( 'cw-star-viewer' );

		}



		/**
		 * Inizializza il plugin dopo che Wordpress l'ha fatto.
		 */		

		public function init() {	

			$vSetup = new FeedatySetup ();

			$menu = new FeedatyMenu ();

			$product_positions = new FeedatyProductPositions();

			$orderStatus = new FeedatyOrderStatuses();

			$productbadge = new FeedatyProductBadge ();

			$visualizzatore = new FeedatyVisualizzatoreRecensioni ();

			$curl = new FeedatyCurlCaller ();

			add_action ( 'widgets_init', array ($vSetup,'registra_widgets'));

			add_filter ( 'woocommerce_product_tabs', array ($vSetup, 'addTabFeedatyRecensioni') );

			add_action ('admin_notices', array ($this,'getMessaggioAttivazione'));
			add_action ( 'feedaty-setup', array ($vSetup,'startSetup' ) );
			add_action ( "wp_enqueue_scripts", array ($this,'addCss' ) );
			add_action ( 'admin_menu', array ($menu,'feedaty_menu' ) );

			add_action ( "woocommerce_product_meta_start", array ($visualizzatore,'renderTemplateReviews' ) );

			//hook for orders
			add_action ( $orderStatus->fd_return_orderStatus(get_option('fdOrderStatus')) , array ($curl,'inviaDatiOrdineFeedaty' ) );

			//hook per badge product
			add_action($product_positions->return_prod_pos(get_option('prod-position')), array ($productbadge,'return_prod_badge') );

			
		}


		public function getMessaggioAttivazione(){

			if(get_option('feedaty-setup') == false){

				echo "<div class='updated fade'> Plugin Feedaty attivato con successo. Inserisci il 
				<b>MerchantCode</b> e il <b>ClientSecret</b> nella pagina di <a href='/wp-admin/admin.php?page=impostazioni-feedaty'>impostazioni.</a> <br/>
				<b>Nota:</b> questa operazione è fondamentale per il funzionamento del plugin</div>";

			}

		}

	}

endif;

FeedatyPlugin::instance ();





