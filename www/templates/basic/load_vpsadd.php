<?php

include('../../config.php');
include('../../functions.php');
include('../../libs/Paquet.class.php');

$paquet = new Paquet();
$paquet -> send_actions();

echo '<div class="center">'._('Creation in progress').'</div>';
echo '<script type="text/javascript">'.
		'$("#popupTitle").html("'._('Create a new Vps').'");'.
		'</script>';
?>
