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
	$panier_paye = 'true';
	$code_promo = 'NULL';
	$is_admin = 'false';
	$date = new DateTime();
	$date_crea =$date->format('Y-m-d');


	#creation utilisatuer
	$num_pannier = rand(3376,10000);
	$sql = "INSERT INTO public.utilisateur VALUES ('$login','$password','$nom','$prenom','$mail','$date_crea',$is_admin,'$num_pannier','$code_promo','$panier_paye')";
	$result = mConn()->prepare($sql);
	$row = $result->execute();


	if ($row) {
	  header('Location: log.php');
	}

	else {

		echo 'Erreur lors de la création';
		echo "\nPDO::errorInfo():\n";
		print_r($result->errorInfo());

	}



}


?>
