<?php

include('header.php');

if(!empty($_GET['vps'])) {
	$paquet = new Paquet();
	$paquet -> add_action('vpsDelete',	array($_GET['vps']));
	$paquet -> send_actions();
}

?>