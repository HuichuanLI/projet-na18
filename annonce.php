<?php
require('./lib/init.php');
date_default_timezone_set("Europe/Paris");



session_start();
if(empty($_POST)) {


	$sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and annonce.ref_produit = '".$_GET['ref_produit']."';";
	$row = mQuery($sql);
	$sql = "SELECT * FROM solde_intermediate WHERE prix_original <> prix_maintenant and ref_produit = '".$_GET['ref_produit']."';";
	$result = mQuery($sql);
	$result = $result[0];
	$value = $row[0];
	require(ROOT . '/view/front/annonce.html');
} 
?>
