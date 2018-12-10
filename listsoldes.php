<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2018.6
*@copyright Gpl
*/

require('./lib/init.php');
date_default_timezone_set("Europe/Paris");


session_start();

if(empty($_SESSION['login'])){
  header('Location: log.php');
}

if($_SESSION['admin'] == false){
	$admin = "false";
}else{
	$admin = "true";
}


if($_SESSION['vendeur'] == false){
	$vendeur = "false";
}else{
	$vendeur = "true";
}




$sql = "SELECT * FROM annonce,utilisateur_achete_produit where annonce.ref_produit = utilisateur_achete_produit.ref_produit and annonce.login_vendeur = '".$_SESSION['login']."';";
$row = mQuery($sql);

require(ROOT . '/view/admin/listsoldes.html');


?>

