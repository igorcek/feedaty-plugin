<?php

Class FeedatyOrderStatuses {
	/**
	* @array of order statuses
	*
	*/
	protected $orderStatuses = array ( 
			
		"woocommerce_order_status_completed",
		"woocommerce_order_status_pending",
		"woocommerce_order_status_processing",

	);

	public function fd_return_orderStatus($id) {

	return $this->orderStatuses[$id];
	}


}