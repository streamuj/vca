<?php

include('header.php');

if(!empty($_GET['vps'])) {
	$paquet = new Paquet();
	$paquet -> add_action('vpsBackupAdd', array($_GET['vps']));
	$paquet -> send_actions();
}

?>