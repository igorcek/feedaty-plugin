<?php
if ( ! defined( 'ABSPATH' ) ) exit;
class FeedatyProductBadge {


	public function return_prod_badge() {

		global $FEEDATY_PERCORSOPLUGIN;
		global $product;
		$id = $product->id;
		
		$curl = new FeedatyCurlCaller ();
		$rich_snippet = $curl->getProductRichSnippet($id);

		$badge = json_decode(json_encode($curl->getWidgets()), true);

		if(count($badge)== 0 || get_option('prod-enabled') == "no" || $rich_snippet == "" ){
			return;
		}
		
		
		$widget_type = get_option('product-badge-style');

		

		include $FEEDATY_PERCORSOPLUGIN."/templates/feedaty-badge-products.php";
	}

}