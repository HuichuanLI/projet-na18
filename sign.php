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



if(empty($_POST)) {
	require(ROOT . '/view/front/sign.html');
} else {
	
	if(empty($_POST['login']) || empty($_POST['nom']) || empty($_POST['prenom']) || empty($_POST['mail']) || empty($_POST['password1'])){
		  header('Location: sign.php?result=empty');
	}
	$login = $_POST['login'];
	$nom = $_POST['nom'];
	$prenom = $_POST['prenom'];
	$mail = $_POST['mail'];
	$password = $_POST['password1'];
	
	$vSql = "SELECT login, nom FROM public.utilisateur WHERE nom = '".$nom."' OR login = '".$login."';" ;
	$row = mQuery($vSql);
	if(empty($row)){
		var_dump("exists");
	}else{
		$is_admin = 'false';
	}

	$sql = "INSERT INTO public.utilisateur VALUES ('".$login."','".$password."','".$nom."','".$prenom."','".$mail."','".date("Y-m-d")."',false,".$num_pannier.");";
	var_dump($sql);
	$row = mQuery($sql);
	
	}

	if ($row) {
	  	header('Location: log.php');
	}
	else {
		 header('Location: sign.php?result=existe');
	}
}

?>
