<?php
require('./lib/init.php');
date_default_timezone_set("Europe/Paris");



session_start();
if(empty($_POST)) {
	$sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and annonce.ref_produit = '".$_GET['ref_produit']."';";
	$row = mQuery($sql);
	$value = $row[0];
	require(ROOT . '/view/front/annonce.html');
} 
?>
