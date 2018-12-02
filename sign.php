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
		#creation utilisatuer
	$num_pannier = rand(3376,10000);
	$sql = "INSERT INTO public.PANIER VALUES (".$num_pannier.",0,null,0,true);";
	var_dump($sql);	
	$row = mQuery($sql);

	$sql = "INSERT INTO public.utilisateur VALUES ('".$login."','".$password."','".$nom."','".$prenom."','".$mail."','".date("Y-m-d")."',false,".$num_pannier.");";
	var_dump($sql);
	$row = mQuery($sql);
	
	}
	
}


?>
