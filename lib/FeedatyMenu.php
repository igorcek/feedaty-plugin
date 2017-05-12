<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
class FeedatyMenu {

	/*
	* Feedaty Settings Menu
	*
	*/
	public function feedaty_menu() {

		add_menu_page( 
			'Feedaty', 
			'Feedaty', 
			'manage_options', 
			'impostazioni-feedaty', 
			array($this,'feedaty_options'),
			plugins_url().'/feedaty-plugin/img/feedaty1.png'
		);

		add_submenu_page(
			'impostazioni-feedaty', 
			'Feedaty Global', 
			'Feedaty Global',
    		'manage_options', 
    		'impostazioni-feedaty'
    	);
    

		add_submenu_page( 
			'impostazioni-feedaty', 
			'Feedaty Product Badge', 
			'Feedaty Product Badge',
    		'manage_options', 
    		'feedaty_product_settings',
    		array($this,'feedaty_product_settings')
    	);


    	add_submenu_page( 
			'impostazioni-feedaty', 
			'Feedaty Store Badge', 
			'Feedaty Store Badge',
    		'manage_options', 
    		'feedaty_store_settings',
    		array($this,'feedaty_store_settings')
    	);
	}

	/*
	* Feedaty Setup Preferences
	*
	*/
	public function feedaty_options() {
		global $FEEDATY_PERCORSOPLUGIN; 
		$cssManager = new FeedatyFileManager();
		$dbManager = new FeedatyDBmanager();

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		// submit global preferences
		if(isset($_POST['submit'])){
			
			$esito = $dbManager->saveGlobalFeedaty( $_POST['merchantCode'], $_POST['clientSecret'],$_POST['fdOrderStatus'] );
			if($esito)
				echo "<div class='updated fade'> Impostazioni salvate con successo </div>";
		}

		//submit CSV
		if(isset($_POST['submit-csv'])){
			$creatorCSV = new FeedatyGeneratorCSV($_POST['inizio'], $_POST['fine']);
			$creation = $creatorCSV->creaCSV();
			$file = $creation['filename'];
			$errori = $creation['errori'];
		}

		//submit CSS
		if(isset($_POST['submit-css'])){
			$cssManager->saveCSS($_POST['css-content']);	
			echo "<div class='updated fade'> CSS salvato con successo </div>";		
		}
		echo '<div class="wrap">';
		include $FEEDATY_PERCORSOPLUGIN."/templates/feedaty-impostazioni.php";
		echo '</div>';

	}


	/*
	* Feedaty Store Preferences
	*
	*/
	public function feedaty_store_settings() {
		global $FEEDATY_PERCORSOPLUGIN;
		$dbManager = new FeedatyDBmanager();

		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if(isset($_POST['submit-store-preferences'])){
			

			//save widget configuration in db
			$esito = $dbManager->saveStorePreferences( $_POST['wid-store-style'],$_POST['wid-store-enabled'] );

			if($esito) echo "<div class='updated fade'>Impostazioni salvate con successo</div>";
		}

		echo '<div class="wrap">';
			include $FEEDATY_PERCORSOPLUGIN."/templates/feedaty-store-settings.php";
		echo '</div>';
	}



	/*
	* Feedaty Widget Preferences
	*
	*/
	public function feedaty_product_settings() {
		
		global $FEEDATY_PERCORSOPLUGIN;
		$dbManager = new FeedatyDBmanager();
		
		if ( !current_user_can( 'manage_options' ) )  {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}

		if(isset($_POST['submit-product-preferences'])){
			

			//save widget configuration in db
			$esito = $dbManager->saveProductPreferences( $_POST['product-badge-style'],$_POST['prod-position'],$_POST['prod-enabled'] );

			if($esito) echo "<div class='updated fade'>Impostazioni salvate con successo</div>";
		}

		echo '<div class="wrap">';
			include $FEEDATY_PERCORSOPLUGIN."/templates/feedaty-product-settings.php";
		echo '</div>';
	}



}