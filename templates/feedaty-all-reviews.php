<?php
	if ( ! defined( 'ABSPATH' ) ) {
		echo "permission denied";
		exit;
	}
?> 

	 <img class='logo-recensioni' src='<?php echo plugins_url()."/feedaty-plugin".'/img/rsz_1sigillo_qualita.png';?>' />
	
	<?php 

	if(count($recensioni) > 0) {
		foreach ( $recensioni as $recensione ) {
			$data_recensione = $recensione->Released;
			$data_recensione = str_replace("/Date(","", $data_recensione);
			$data_recensione = str_replace(")/", "", $data_recensione);
			$data_recensione = date("d/m/Y", substr($data_recensione,0,10));
			$user = new WP_User ( $recensione->CustomerID );
			foreach ( $recensione->ProductsReviews as $review ) {
				include $FEEDATY_PERCORSOPLUGIN . '/templates/recensioniProdotto.php';
			}
		}
	}
	else
		echo "Non ci sono recensioni disponibili su questo prodotto";
		?>
