<?php
if ( ! defined( 'ABSPATH' ) ) {
	echo "permission denied";
	exit;
}
?>
<div>
	<div>
		<?php
			$codice = $badge[$widget_type]['html_embed'];
			echo "<div>".str_replace("__insert_ID__",$id,$codice)."</div><br/>";
		?>
		<div>
			<?php echo $rich_snippet?>
		</div>	
	</div>	
</div>