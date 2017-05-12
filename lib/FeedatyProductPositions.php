<?php

Class FeedatyProductPositions {
/**
* @array of badge product positions
*/

	protected $prodPositions = array(
		"woocommerce_before_single_product",
		"woocommerce_before_single_product_summary",
		"woocommerce_single_product_summary",
		"woocommerce_before_add_to_cart_form",
		"woocommerce_before_variations_form",
		"woocommerce_before_add_to_cart_button",
		"woocommerce_before_single_variation",
		"woocommerce_single_variation",
		"woocommerce_after_single_variation",
		"woocommerce_after_add_to_cart_button",
		"woocommerce_after_variations_form",
		"woocommerce_after_add_to_cart_form",
		"woocommerce_product_meta_start",
		"woocommerce_product_meta_end",
		"woocommerce_share",
		"woocommerce_after_single_product_summary",
		"woocommerce_after_single_product"
	);

	public function return_prod_pos($id) {

    	return $this->prodPositions[$id];
	}
}