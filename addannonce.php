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


if(empty($_POST)) {

	$sql = "SELECT ref_produit,nom_produit FROM public.produit";
	$result  = mQuery($sql);
	require(ROOT . '/view/admin/addannonce.html');
} else {

	if(empty($_POST['Ref_annonce']) || empty($_POST['debut']) || empty($_POST['ref_produit'])){
		header('Location: addannonce.php');
	}
	$sql ="INSERT INTO public.annonce(ref_annonce, date_mise_en_ligne, ref_produit, login_vendeur)VALUES ('".$_POST['Ref_annonce']."','".$_POST['debut']."','".$_POST['ref_produit']."' ,'".$_SESSION['login']."');";
	$result = mExec($sql);
	if($result == "true"){
		header('Location: listannonce.php');	
	}else{
		header('Location: listannonce.php?result=problem');
	}
	
}

?>
