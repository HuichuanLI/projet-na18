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

/*login partie*/
session_start();



if(empty($_SESSION['login'])){
  header('Location: log.php');
}

if(empty($_POST)) {
	
	$sql = "SELECT ville, cp, type_voie, num_voie, nom_voie, login FROM public.adresse where login = ?;";

	$address = mNewQuery($sql,$model=2,array($_SESSION['login']))[0];
	$_SESSION['address'] = $address;
} else{

	if($_SESSION['address'] == null){
		$sql = "INSERT INTO public.adresse(ville, cp, type_voie, num_voie, nom_voie, login) VALUES (?,?,?,?,?,?); ";	
	}else{
		$sql = "UPDATE public.adresse SET ville= ?, cp= ?, type_voie= ?, num_voie= ?, nom_voie= ? WHERE login= ?;";
	}

	$row = mNewExec($sql,$model=2,array($_POST['ville'],$_POST['cp'],$_POST['type_voie'],$_POST['num_voie'],$_POST['nom_voie'],$_SESSION['login']));
	if($row = "true"){
		header('Location: homepage.php?result=avec success');
	}else{
 		header('Location: homepage.php?result=problem');
	}
}
	$sql = "SELECT ville, cp, type_voie, num_voie, nom_voie, login FROM public.adresse where login = ?;";
	$address = mNewQuery($sql,$model=2,array($_SESSION['login']));	
	$_SESSION['address'] = $address;

require(ROOT . '/view/admin/address.html');	
?>
