<?php

class FeedatyVisualizzatoreRecensioni {
	
	public function getDataSchedaProdotto($feedaty_id) {
		$totalData = $this->fdGetProductData ( $feedaty_id );
		if ($totalData != null) {
			$data ['rating_count'] = $totalData ['Product'] ['RatingsCount'];
			$data ['average'] = $totalData ['Product'] ['AvgRating'];
			$data ['totalFeedbacks'] = $totalData ['TotalFeedbacks'];
		} 
		else {
			$data ['rating_count'] = 0;
			$data ['average'] = 0;
			$data ['totalFeedbacks'] = 0;
		}
		return $data;
	}

	public function getDataRecensioni($feedaty_id) {
		$totalData = $this->fdGetProductData ( $feedaty_id );
		if ($totalData != null) {
			$data ['feedbacks'] = $totalData ['Feedbacks'];
		} else {
			$data ['feedbacks'] = 0;
		}
		return $data;
	}

	public function showStars($n) {
		global $FEEDATY_PERCORSOPLUGIN;
		$residui = 5 - $n;
		$starpiena = plugins_url()."/feedaty-plugin"."/img/starArancio.png";
		$starvuota = plugins_url()."/feedaty-plugin"."/img/stella_grigia.png";
		while ( $n ) {
			echo "<img src='{$starpiena}' />";
			$n --;
		}
		while ( $residui ) {
			echo "<img src='{$starvuota}' />";
			$residui --;
		}
	}

	public function renderTemplateReviews() {

		global $FEEDATY_PERCORSOPLUGIN;
		global $product;
		$id = $product->id;
		$curl = new FeedatyCurlCaller ();
		$recensioni = $curl->getDataRecensioni ( $id )->Data->Reviews;
		if(count($recensioni)==0){
			return;
		}
		include $FEEDATY_PERCORSOPLUGIN."/templates/feedaty-reviews-container.php";
	}
	
	public function renderAllReviews($atts = null){
		$id = $atts ['id'];		
		$i = 0;		
		if($id == null)
			$id = $_GET['pid'];	
		global $product;
		global $FEEDATY_PERCORSOPLUGIN;
		if (! $id)	
			$id = $product->id;
		$curl = new FeedatyCurlCaller ();
		$recensioni = $curl->getDataRecensioni ( $id )->Data->Reviews;
		include $FEEDATY_PERCORSOPLUGIN."/templates/feedaty-all-reviews.php";
	}
}
