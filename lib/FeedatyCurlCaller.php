<?php 
if ( ! defined( 'ABSPATH' ) ) exit;

class FeedatyCurlCaller {


	private $merchantCode;
	private $clientSecret;
	private $HOST_NAME;


	/**
	* Function Construct
	*
	*/
	public function __construct() {
		$this->HOST_NAME = "http://api.feedaty.com";
		$this->merchantCode = get_option('feedaty-merchant-code');
		$this->clientSecret = get_option('feedaty-client-secret');
	}


	/**
	* Function callCurl
	* @param $path
	* @param $dati
	* @param $header
	* @param $type
	*
	* @return $response
	*/
	private function callCurl($path, $dati, $header, $type = 'post'){
		$url = $path;
		if($type == 'get'){
			$url .= '?'.$dati;
		}
		$ch = curl_init($url);

		if($type == 'post'){
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $dati);
		}

		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		return $response;
	}
	

	/**
	* Function getProductRichSnippet
	* @param $pid
	*
	* @return $content
	*/
	public function getProductRichSnippet($pid){

		$content = json_decode(get_transient("ProdSnip".$this->merchantCode.$pid));

		if($content === NULL || false === $content  || strlen($content) === 0)
		{

			$path = 'http://white.zoorate.com/gen';
			$dati = array(
				'w' => 'wp',
				'MerchantCode' => $this->merchantCode,
				't' => 'microdata',
				'version' => 2,
				'sku' => $pid,
			);
			$header = array('Content-Type: text/html',
				'User-Agent: WPFeedaty'
			);
			$dati = $this->serializeData($dati);
			$path.='?'.$dati;
			$ch = curl_init($path);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, '250');
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, '250');
			$content = curl_exec($ch);
			$http_resp = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);

			if (strlen($content) > 50 && $http_resp == "200")
				set_transient("ProdSnip".$this->merchantCode.$pid,json_encode($content),(int) 60 * 60 * 6);
			else $content = "";
		}

		return $content;
	}
	

	/**
	* Funcion getMerchantRichSnippet
	*
	* @return $content
	*/
	public function getMerchantRichSnippet(){

		$content = json_decode(get_transient("StoreSnip".$this->merchantCode));

		if($content === NULL || false === $content  || strlen($content) === 0)
		{

			$path = 'http://white.zoorate.com/gen';
			$dati = array(
				'w' => 'wp',
				'MerchantCode' => $this->merchantCode,
				't' => 'microdata',
				'version' => 2,
			);
			$header = array('Content-Type: text/html',
				'User-Agent: WPFeedaty'
			);
			$dati = $this->serializeData($dati);
			$path.='?'.$dati;
			$path = str_replace("=2&", "=2", $path);
			$ch = curl_init($path);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, '250');
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, '250');
			$content = curl_exec($ch);
			$http_resp = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			curl_close($ch);
			
			if (strlen($content) > 50 && $http_resp == "200")
				set_transient("StoreSnip".$this->merchantCode,json_encode($content),(int) 60 * 60 * 6);
			else $content = "";
			
		}

		return $content;

	}
	

	/**
	* Function getWidgets
	*
	* @return $response - an array with all widgets
	*/
	public function getWidgets(){

		$content = json_decode(get_transient("Badges"));

		if($content === NULL || false === $content  || count($content) === 0) {

			$path = 'http://widget.zoorate.com/go.php';
			$dati = array('function' => 'feed_be',
					'action' => 'widget_list',
					'merchant_code' => $this->merchantCode,
					'lang' => 'it'
			);
			$header = array('Content-Type: application/json',
				'User-Agent: WPFeedaty'
			);
			$dati = $this->serializeData($dati);
			$content = $this->callCurl($path, $dati, $header, 'get');

			//24 hours of cache
			set_transient("Badges",json_encode($content),(int) 60 * 60 * 24);

		}

		return $content;

	}
	

	/**
	* Function recuperaOrdini
	*
	* @param $accessToken
	*
	* @return $responce
	*/
	function recuperaOrdini($accessToken){
		$ch = curl_init('api.feedaty.com/Orders/Get');
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $dati);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json',
				'Authorization: Oauth '.$accessToken->AccessToken
		));
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , true);
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		return $response;
	}


	/**
	* Function inviaDatiOrdineFeedaty
	*
	* @param $order_id
	*
	*/
	function inviaDatiOrdineFeedaty($order_id){

		$token = $this->getRequestToken();
		$accessToken = $this->getAccessToken($token);

		$response = $this->sendOrder($accessToken, $order_id);

		if($response->Success){
			echo "<div class ='update notice notice-success is-dismissible'>
					Dati inviati a Feedaty correttamente
					</div>";
		}

	}
	

	/**
	* Function serializeItems
	*
	* @param $items
	*
	* @return $return - serialized data for curl post
	*/
	private function serializeItems($items){
		$return = "[";
		$i = count($items);
		foreach ($items as $item){
			$product = new WC_Product($item['item_meta']['_product_id'][0]);
			$serial = "";
			$serial .= '{';
			$serial .= '"SKU": "'.$product->id.'", ';	
			$serial .= '"Name": "'.$item['name'].'", ';
			$serial .= '"ThumbnailURL": "'.wp_get_attachment_url(get_post_thumbnail_id($product->id)).'", ';
			$serial .= '"URL": "'.get_permalink($product->id).'"';
			$serial .= '}';
			$return .= $serial;
			if($i != 1)
				$return .= ",";
			$i--;
		}
		$return .= "]";
		return $return;
	}
	

	/**
	* Function sendOrder
	*
	* @param $accessToken
	* @param $order_id
	* 
	* @return $response
	*/
	function sendOrder($accessToken, $order_id){
		$order = new WC_Order($order_id);

		$user_id = $order->billing_email;

		$items = $order->get_items();
		$header = array('Content-Type: application/json', 'Authorization: Oauth '.$accessToken->AccessToken );

		$dati = '[{
				"ID": "'.$order->id.'",
				"Date": "'.$order->post->post_date.'",
				"CustomerID": "'.$user_id.'",
				"CustomerEmail": "'.$order->billing_email.'",
				"Products": '.$this->serializeItems($items);
		$dati.=	'}]';

		$response = $this->callCurl($this->HOST_NAME."/Orders/Insert", $dati, $header);

		return $response;
	}
	

	/**
	* Function getAccessToken
	*
	* @param $token
	*
	* @param $response
	*/
	function getAccessToken($token){
		$encripted_code = $this->encriptToken($token);
		$campi = array('oauth_token' => $token->RequestToken,
				'grant_type'=>'authorization'
		);
		$header = array('Content-Type: application/x-www-form-urlencoded',
				'Authorization: Basic '.$encripted_code,
				'User-Agent: WPFeedaty'
		);
		$dati = $this->serializeData($campi);
		$response = $this->callCurl($this->HOST_NAME."/OAuth/AccessToken", $dati, $header);
		return $response;
	}
	

	/**
	* Function serializeData
	* 
	* @param $campi
	* 
	* @return $dati
	*/
	private function serializeData($campi){
		$dati = '';
		foreach($campi as $k => $v){
			$dati .= $k . '=' . urlencode($v) . '&';
		}
		rtrim($dati, '&');
		return $dati;
	}
	

	/**
	* Function encriptToken
	*
	* @param $token
	*
	* @return $base64_sha_token
	*/
	private function encriptToken($token){
		$sha_token = sha1($token->RequestToken.$this->clientSecret);
		$base64_sha_token = base64_encode($this->merchantCode.":".$sha_token);
		return $base64_sha_token;	
	}
	

	/**
	* Function getRequestToken
	*
	* @return $response - OAuth/RequestToken
	*/
	function getRequestToken(){
		$campi= array('MerchantCode' => $this->merchantCode,
				'ClientSecret' => $this->clientSecret

		);
		$dati = $this->serializeData($campi);
		$header = array('Content-Type: application/x-www-form-urlencoded',
		'Content-Length: ' . strlen($dati)
 		);
		$response = $this->callCurl($this->HOST_NAME."/OAuth/RequestToken", $dati, $header);
		return $response;
	}
	

	/**
	* Function getDataRecensioni
	*
	* @param $sku - Product id 
	* 
	* @return $response
	*/
	public function getDataRecensioni($sku){
		$token = $this->getRequestToken();
		$accessToken = $this->getAccessToken($token);
		$header = array('Content-Type: application/x-www-form-urlencoded',
						'Authorization: OAuth '.$accessToken->AccessToken
		);
		$campi = array(
				'sku' => $sku,
				'retrieve' =>'onlyproductreviews'
		);
		$dati = $this->serializeData($campi);
		$response = $this->callCurl($this->HOST_NAME.'/Reviews/Get/', $dati, $header, 'get');
		return $response;
	}
	

	/**
	* Function fdGetProductData
	* 
	* @param $id
	*
	* @return $data 
	*/
	public function fdGetProductData($id) {

		$content = json_decode(get_transient("ProductData".$this->merchantCode.$id));

		if($content === NULL || false === $content  || strlen($content) === 0) {
			$ch = curl_init();
			$url = 'http://'.'widget.zoorate.com/go.php?function=feed&action=ws&task=product&merchant_code='.$this->merchantCode.'&ProductID='.$id;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);
			$content = trim(curl_exec($ch));
			curl_close($ch);
			set_transient("ProductData".$this->merchantCode.$pid,json_encode(json_decode($content, true)),(int) 60 * 60 * 24);
			//$data = json_decode($content, true); 

			//if($data['Product']==null) return null;

		}
		return $content;
	}
}

// TODO: for v2.0.5 we implements these changes, report in readme.txt file these changes
// - check if transients for fdGetProductData works fine
// - implement a control on http status code for microdata and widget responses