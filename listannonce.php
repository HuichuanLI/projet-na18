<?php
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




$sql = "SELECT * FROM annonce where login_vendeur = '".$_SESSION['login']."';";
$row = mQuery($sql);


if(isset($_POST['delete'])){
	

	$sql = "DELETE FROM public.utilisateur_consulte_annonce WHERE ref_annonce = '".$_POST['ref_annonce']."';";
	$row = mExec($sql);
	$sql = "DELETE FROM public.annonce WHERE ref_annonce = '".$_POST['ref_annonce']."';";
	$row = mExec($sql);
	header('Location: listannonce.php');
	
}
require(ROOT . '/view/admin/listannonce.html');


?>

?>
