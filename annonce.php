<?php
require('./lib/init.php');
date_default_timezone_set("Europe/Paris");



session_start();
if(empty($_POST)) {


	$sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and annonce.ref_produit = ?;";
	
	$row = mNewQuery($sql,$model=2,array($_GET['ref_produit']));

	$sql = "SELECT * FROM solde_intermediate WHERE prix_original <> prix_maintenant and ref_produit = ?;";
	
	$result = mNewQuery($sql,$model=2,array($_GET['ref_produit']));
	
	$result = $result[0];
	$value = $row[0];
	require(ROOT . '/view/front/annonce.html');
} 
?>
