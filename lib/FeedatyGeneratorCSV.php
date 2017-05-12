<?php 
if ( ! defined( 'ABSPATH' ) ) exit;
class FeedatyGeneratorCSV{
	private $dataInizio;	
	private $dataFine;
	
	public function __construct($inizio,$fine){		
		$this->dataInizio = $inizio;
		$this->dataFine = $fine;
	}
	
	public function plugin_path() {
		return untrailingslashit ( plugin_dir_path ( __FILE__ ) );
	}
	
	public function creaCSV(){
		global $FEEDATY_PERCORSOPLUGIN;
		$filename = "feedatyCSV".$this->dataInizio.$this->dataFine.".csv";
		$path = $FEEDATY_PERCORSOPLUGIN."/feedatyCSV/".$filename;		
		$header = $this->getIntestazione();
		file_put_contents($path,implode(",",$header)."\n");
		$error = $this->getLineCSV($path);
		return array("filename" => plugins_url()."/feedaty-plugin/feedatyCSV/".$filename,
					"errori" => $error);
	}
	
	private function filtraPerData($orders){
		$inizio = new DateTime($this->dataInizio);
		$fine = new DateTime($this->dataFine);
		$return = array();
				foreach($orders as $order){
			$ordine = new WC_Order($order->ID);
			$data_ordine = new DateTime($ordine->order_date);
			if($data_ordine->getTimestamp() > $inizio->getTimestamp()
				&& $data_ordine->getTimestamp() < $fine->getTimestamp())
				$return[] = $order;
		}
		return $return;
	}
	
	private function getLineCSV($path){
		$orders = get_posts(array('post_type' => 'shop_order',								
				'post_status' => 'wc_completed',								
				'posts_per_page' => -1
		));

		$error = "";
		$data = array();
		
		if (!empty($this->dataInizio) && !empty($this->dataFine)) {
			$orders = $this->filtraPerData($orders);
		}
		foreach($orders as $order){
			$ordine = new WC_Order($order->ID);
			$user =new WP_User( $ordine->user_id);
			if($ordine->post->post_status != 'wc-completed')
				continue;
			if($ordine->user_id == 0){
				$email = $ordine->billing_email;
				$user_id = $email;
			}			
			else {	
				$email = $user->data->user_email;				
				$user_id = $email;		
			}
						$items = $ordine->get_items();
			foreach($items as $item){			$product = new WC_Product($item['item_meta']['_product_id'][0]);
			$data = array($ordine->id, $user_id, $email, $ordine->order_date, $product->id, $item['name'],get_permalink($product->id),wp_get_attachment_url(					get_post_thumbnail_id($product->id)) );
			file_put_contents($path,implode(",",$data)."\n", FILE_APPEND);
		}
	}
	return $error;
	}
	
	private function getIntestazione(){
		return array("Order ID","UserID","E-mail","Date","Product ID","Name","Url","Image");
	}
}
?>