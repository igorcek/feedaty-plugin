<?php 
	if ( ! defined( 'ABSPATH' ) ) {
		echo "permission denied";
		exit;
	}
	$feedatyCurl = new FeedatyCurlCaller;
	$feedatyWidgets = $feedatyCurl->getWidgets();
	$widgets = json_decode(json_encode($feedatyWidgets),true);

	//query for mercant badge settings
	$store_style = get_option('wid-store-style');
	$store_enable = get_option('wid-store-enabled');

?>

<h1>Pagina di setup per Widgets Store Feedaty</h1>
<form method='post' action="#">
<div class="">

<table class="form-table">
<tbody>

	<!-- STYLE STORE DIV -->
	<tr>
		<th scope="row">
			<label>Store Badge </label>
		</th>
		<td>
			<div class="post-body">

				<table>
				<?php 
					
					foreach($widgets as $k=>$v) {

						if ($v['type'] == "merchant") {
							if ( $store_style === $k) {
								echo "<tr><td><input type = 'radio' name='wid-store-style' id='".esc_attr($v['name'])."' value='".esc_attr($k)."' checked /></td>";
							}
							else {
								echo "<tr><td><input type = 'radio' name='wid-store-style' id='".esc_attr($v['name'])."' value='".esc_attr($k)."' /></td>";
							}
								echo "<td><img src='".esc_url($v['thumb'])."'><br /></td></tr>";
							
						}
					}
				?>
				</table>
				<br />

				<label>Enabled</label>
				<select name="wid-store-enabled">
  					<option value="yes" <?php if($store_enable == "yes") echo 'selected="selected"';?> >Yes</option>
  					<option value="no" <?php if($store_enable == "no") echo 'selected="selected"';?> >No</option>
				</select>
				<br />
			</div>
		</td>
	</tr> 
<tr>
	<td><input type = 'submit' name = 'submit-store-preferences' value='Salva' /></td>
	</tr>
</div>
</tbody>
</table>
</form>