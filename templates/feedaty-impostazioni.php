<?php 
	if ( ! defined( 'ABSPATH' ) ) {
		echo "permission denied";
		exit;
	}
	if(get_option('feedaty-setup')==false){
		do_action('feedaty-setup');
	}

	$fdOrderStatus = get_option('fdOrderStatus');

?>

<h1>Pagina di setup per integrare Feedaty</h1>
<?php if(isset($file))
 	echo "<div class='updated fade'>
		<b>CSV creato con successo.</b>	
		<p>Scarica <a href='".$file."' target='_blank' download>qui</a> il csv per Feedaty</p>
		</div> ";
	 if (isset($errori))
		echo $errori; ?>
	
<h1 class='prova'>Credenziali di accesso Feedaty</h1>
<form method='post' action="#">
	<label>MerchantCode</label>
	<input type = 'number' name= 'merchantCode' value = '<?php echo get_option('feedaty-merchant-code');?>' />
	<br />

	<label>ClientSecret</label>
	<input type = 'text' name= 'clientSecret' value = '<?php echo get_option('feedaty-client-secret');?>'/>
	<br />

	<label>Invio Ordini</label>
	<select name="fdOrderStatus">
		<option value="0" <?php if($fdOrderStatus === '0') echo 'selected="selected"';?> >Complete</option>
		<option value="1" <?php if($fdOrderStatus === '1') echo 'selected="selected"';?> >Pending</option>
		<option value="2" <?php if($fdOrderStatus === '2') echo 'selected="selected"';?> >Processing</option>
	</select>
	<br />
	
	<input type = 'submit' name = 'submit' value='Salva' />
</form> <br/>

<h1>Invia gli ordini a Feedaty tramite CSV</h1>
<p><b>Indicare l'intervallo di date</b></p>
<form method='post' action='#'>
	<label>Data inizio</label>
	<input type='date' name='inizio' placeholder='gg/mm/aaaa' /><br/>
	<label>Data fine </label>
	<input type='date' name='fine' placeholder='gg/mm/aaaa' /> <br/>
	<input type='submit' name= 'submit-csv' value='crea CSV' />
 </form><br/>

<h1>Modifica la visualizzazione delle recensioni</h1>
<p><b>Scrivi qui il tuo CSS</b>
<form name='css-feedaty-form' action='#' method='post'>
 	<textarea rows="10" cols="40" name='css-content'>
 		<?php echo $cssManager->getCss()?>
 	</textarea><br/>
 	<input type='submit' name='submit-css' value='salva CSS'/> 
</form><br/>