<?php
if ( ! defined( 'ABSPATH' ) ) {
	echo "permission denied";
	exit;
}
?>
<div class='elenco-recensioni'>
<?php $curl = new FeedatyCurlCaller();?>

<?php dynamic_sidebar('feedaty-average-view');?>


</div>