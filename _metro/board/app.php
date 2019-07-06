<?php
header('Content-Type: text/xml');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
?>
<clock>
	<timestring>
		It is <?php echo date('H:i:s')?> on <?php echo date('M d, Y')?>
	</timestring>
</clock>