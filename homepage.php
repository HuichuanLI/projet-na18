<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/
require('./lib/init.php');
session_start();
if(empty($_SESSION['login'])){
  header('Location: log.php');
}


$sql = "SELECT * FROM UTILISATEUR_ACHETE_PRODUIT, PRODUIT WHERE PRODUIT.ref_produit = UTILISATEUR_ACHETE_PRODUIT.ref_produit AND UTILISATEUR_ACHETE_PRODUIT.login = '".$_SESSION['login']."';";
$row = mQuery($sql);

if($_SESSION['admin'] == false){
	$admin = "false";
}else{
	$admin = "true";
}

include(ROOT.'/view/admin/homepage.html');
