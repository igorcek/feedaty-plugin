<?php 
	if ( ! defined( 'ABSPATH' ) ) {
		echo "permission denied";
		exit;
	}
 	$product = new WC_Product($_GET['pid']);
 ?> 
 <div>
 <?php echo $product->post->post_title;
 ?>
 <span><?php echo $data_recensione; ?></span>
   <span class="stars"><?php $this->showStars($review->Rating); ?></span><br>
 <span><i><?php echo $review->Review;?></i></span><br/></br>
  </div>
   
  