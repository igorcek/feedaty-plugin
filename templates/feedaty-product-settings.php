<?php 
	if ( ! defined( 'ABSPATH' ) ) {
		echo "permission denied";
		exit;
	}

	$feedatyCurl = new FeedatyCurlCaller;
	$feedatyWidgets = $feedatyCurl->getWidgets();
	$widgets = json_decode(json_encode($feedatyWidgets),true);

	//query prod for settings
	$prod_style = get_option('product-badge-style') ;
	$prod_position = get_option('prod-position') ;
	$prod_enable = get_option('prod-enabled');

?>

<h1>Pagina di setup per Widgets Product Feedaty</h1>
<form method='post' action="#">
<div class="">

<table class="form-table">
<tbody>

	<!-- STYLE PRODUCT DIV-->
	<tr>
		<th scope="row">
			<label>Product Badge </label>
		</th>
		<td>
			<div class="post-body">
				<table>
				<?php 
					foreach($widgets as $k=>$v) {
						if ($v['type'] == "product") {
							if ( $prod_style === $k) {
								echo "<tr><td><input type ='radio' name='product-badge-style' id='".esc_attr($v['name'])."' value='".esc_attr($k)."' checked /></td>";
							}
							else {
								echo "<tr><td><input type ='radio' name='product-badge-style' id='".esc_attr($v['name'])."' value='".esc_attr($k)."'/></td>";

							}
							echo '<td><img src="'.esc_url($v['thumb']).'"><br /></td></tr>';
						}
					}
				?>
				</table>
				<br />
				<!-- TODO: test every position and comment out breack positions -->
				<label>Position</label>
				<select name="prod-position" >
  					<option value="0" <?php if($prod_position == "0") echo 'selected="selected"';?>>Before single product</option>
  					<option value="1" <?php if($prod_position == "1") echo 'selected="selected"';?>>Before single product summary</option>
  					<option value="2" <?php if($prod_position == "2") echo 'selected="selected"';?>>Single product summary</option>
  					<option value="3" <?php if($prod_position == "3") echo 'selected="selected"';?>>Before add to cart form</option>
  					<option value="4" <?php if($prod_position == "4") echo 'selected="selected"';?>>Before variations form</option>
  					<option value="5" <?php if($prod_position == "5") echo 'selected="selected"';?>>Before add to cart button</option>
  					<option value="6" <?php if($prod_position == "6") echo 'selected="selected"';?>>Before single variation</option>
  					<option value="7" <?php if($prod_position == "7") echo 'selected="selected"';?>>Single variation</option>
  					<option value="8" <?php if($prod_position == "8") echo 'selected="selected"';?>>After single variation</option>
  					<option value="9" <?php if($prod_position == "9") echo 'selected="selected"';?>>After add to cart button</option>
  					<option value="10" <?php if($prod_position == "10") echo 'selected="selected"';?>>After variations form</option>
  					<option value="11" <?php if($prod_position == "11") echo 'selected="selected"';?>>After add to cart form</option>
  					<option value="12" <?php if($prod_position == "12") echo 'selected="selected"';?>>Product meta start</option>
  					<option value="13" <?php if($prod_position == "13") echo 'selected="selected"';?>>Product meta end</option>
  					<option value="14" <?php if($prod_position == "14") echo 'selected="selected"';?>>Woocommerce share</option>	
  					<option value="15" <?php if($prod_position == "15") echo 'selected="selected"';?>>After single product summary</option>
  					<option value="16" <?php if($prod_position == "16") echo 'selected="selected"';?>>After single product</option>
				</select>
				<br />		

				<label>Enabled</label>
				<select name="prod-enabled">
  					<option value="yes" <?php if($prod_enable == "yes") echo 'selected="selected"';?> >Yes</option>
  					<option value="no" <?php if($prod_enable == "no") echo 'selected="selected"';?> >No</option>
				</select>
				<br />
			</div>
		</td>
	</tr>

	<tr>
	<td><input type = 'submit' name = 'submit-product-preferences' value='Salva' /></td>
	</tr>
</div>
</tbody>
</table>
</form>