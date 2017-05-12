<?php 

class FeedatySetup{
	public function startSetup(){
		$param = array (
				'post_type' => 'page',
				'post_title' => 'Recensioni',
				'post_content' => '[feedaty-recensioni view=all]',
				'post_author' => 1,
				'post_status' => 'publish',
				'comment_status' => 'closed',
				'ping_status' => 'closed',
				'post_name' => 'recensioni',
				'guid' => '/recensioni/',
		);
		$post = wp_insert_post($param,true);
		update_post_meta ( $post, '_wp_page_template', 'default' );
		update_option('feedaty-setup', true);
		
		//setup standard configurations
		update_option("wid-store-style","v3_merchant_small");
		update_option("wid-store-enabled","yes");
		update_option("product-badge-style","v3_product_small");
		update_option("prod-position","0");
		update_option("prod-enabled","yes");
	}

	public function registra_widgets(){	
		register_widget ( 'FeedatyWidget_Home' );	
	}
	
	public function addTabFeedatyRecensioni($tabs){		
		$tabs['test_tab'] = array(
				'title' 	=> "Recensioni Feedaty",
				'priority' 	=> 50,
				'callback' 	=> array($this, 'populateTabRecensioni')
		);
		
		return $tabs;
	}
	
	public function populateTabRecensioni(){
		$render = new FeedatyVisualizzatoreRecensioni();
		echo $render->renderAllReviews();
	}
	
}
?>
