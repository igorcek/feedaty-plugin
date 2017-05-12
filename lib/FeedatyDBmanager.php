<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

class FeedatyDBmanager{

	private $wpdb;

	public function __construct(){
		global $wpdb;
		$this->wpdb = $wpdb;
	}

	/*
	-------------------------------------
	|
	| SAVE IN DB FUNCTIONS
	|
	|
	-------------------------------------
	*/
	/**
	*
	* Save Feedaty Credentials
	* @return esito
	*/
	public function saveGlobalFeedaty( $merchant,$secret,$orderStatus ){

		$safedata = $this->sanitizeGloabl( $merchant,$secret,$orderStatus );

		$esito = update_option("feedaty-merchant-code",sanitize_text_field($safedata['merchant']));
		$esito = update_option("feedaty-client-secret", sanitize_text_field($safedata['secret']));
		$esito = update_option("fdOrderStatus",intval($safedata['orderStatus']));

		return $esito;
	}


	/**
	* Save Feedaty Store Preferences
	*
	* @return esito
	*/
	public function saveStorePreferences( $storestyle,$store_enabled ) {

		$safedata = $this->sanitizeStoreopt($storestyle, $store_enabled);

		//store config
		$esito = update_option("wid-store-style", sanitize_text_field($safedata['wid-store-style']));
		$esito = update_option("wid-store-enabled", sanitize_text_field($safedata['wid-store-enabled']));
		
		return $esito;
	}


	/**
	* Save Feedaty Product Preferences
	*
	* @return esito
	*/
	public function saveProductPreferences( $prodstyle,$prod_position,$prod_enabled ){

		//SANITIZE INPUTS
		$safedata = $this->sanitizeProdopt( $prodstyle,$prod_position,$prod_enabled );
		
		//prod config
		$esito = update_option("product-badge-style", sanitize_text_field($safedata['product-badge-style']));
		$esito = update_option("prod-position", intval($safedata['prod-position']));
		$esito = update_option("prod-enabled", sanitize_text_field($safedata['prod-enabled']));
		
		return $esito;
	}

	/*
	-------------------------------------
	|
	| SANITIZE FUNCTIONS
	|
	|
	-------------------------------------
	*/

	/**
	* Function sanitizeCredentials
	*
	* @param $merchant 
	* @param $secret 
	* @param $orderStatus
	* 
	* @return data[] - array of sinitized data
	*/
	private function sanitizeGloabl( $merchant,$secret,$orderStatus ) {

		if ( strlen($orderStatus) > 2 || preg_match("/[^A-Za-z0-9]+/", $merchant) || preg_match("/[^A-Za-z0-9]+/", $secret) || preg_match("/[^0-9]+/", $orderStatus)) {

			return $safedata = array( 'merchant' => '', 'secret' => '', 'orderStatus' => '0');
		}
		else return $safedata = array( 'merchant' => $merchant, 'secret' => $secret, 'orderStatus' => $orderStatus); 
	}


	/**
	* Sanitize Store Options
	* @return $data[] - array of sanitized inputs
	*/
	private function sanitizeStoreopt( $storestyle,$store_enabled ) {

		if ( strlen($storestyle) > 55 || strlen($store_enabled) > 3 || preg_match("/[^A-Za-z0-9\-\_]+/", $storestyle) || preg_match("/[^A-Za-z]+/", $store_enabled)) {

			return $safedata = array( 'wid-store-style' => 'v3_merchant_small', 'wid-store-enabled' => 'yes');
		}
		else return $safedata = array( 'wid-store-style' => $storestyle, 'wid-store-enabled' => $store_enabled);


	}


	/**
	* Sanitize Prod Options
	* @return $data[] - array of sanitized inputs
	*/
	private function sanitizeProdopt ( $prodstyle,$prod_position,$prod_enabled ) {

		if(strlen($prodstyle) > 55 
			|| strlen($prod_position) > 2
			|| strlen($prod_enabled) > 3
			|| preg_match("/[^A-Za-z0-9\-\_]+/", $prodstyle) 
			|| preg_match("/[^0-9]+/", $prod_position)
			|| preg_match("/[^A-Za-z]+/", $prod_enabled)
		) 
		{
			return $data = array( 'product-badge-style' => 'v3_product_small', 'prod-position' => '0', 'prod-enabled' => 'yes' );
			
		}
		else return $data = array( 'product-badge-style' => $prodstyle, 'prod-position' => $prod_position, 'prod-enabled' => $prod_enabled );

	}


}
