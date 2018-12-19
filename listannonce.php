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



/* ajouter des fonctions pour connecter*/
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




$sql = "SELECT * FROM annonce where login_vendeur = ?;";
$row = mNewQuery($sql,$model=2,array($_SESSION['login']));


if(isset($_POST['delete'])){
	

	$sql = "DELETE FROM public.utilisateur_consulte_annonce WHERE ref_annonce = ?;";
	$row =	mNewExec($sql, $model = 2,array($_POST['ref_annonce']));
	$sql = "DELETE FROM public.annonce WHERE ref_annonce = ?;";
	$row = 	mNewExec($sql, $model = 2,array($_POST['ref_annonce']));
	header('Location: listannonce.php');
	
}
require(ROOT . '/view/admin/listannonce.html');


?>

?>
