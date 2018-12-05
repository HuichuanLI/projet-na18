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
	$panier_paye = 'true';
	$code_promo = 'NULL';
	
	$date = new DateTime();
	$date_crea =$date->format('Y-m-d');


	#creation utilisatuer

	$typeuser = $_POST['typeuser'];
	if($typeuser == "admin"){
		$is_admin = 'true';
	}else{
		$is_admin = 'false';
	}




	$sql = "INSERT INTO public.utilisateur(
	 login, mdp, nom, prénom, mail, date_creation_compte, est_admin, est_paye) VALUES ('$login','$password','$nom','$prenom','$mail','$date_crea',$is_admin,'$panier_paye')";
	
	$result = mConn()->prepare($sql);
	$row = $result->execute();
	
	# when the user is vendeur
	if($typeuser == "vendeur"){
		$description = $_POST["description"];
		$siret = $_POST["siret"];
		$nom_magasin = $_POST["magasin"];
		$sql = "INSERT INTO public.vendeur(login, description, siret, nom_magasin) VALUES ('$login', '$description', '$siret', '$nom_magasin');";
		$result = mConn()->prepare($sql);
		$row = $result->execute();
	}

	if ($row) {
	  	header('Location: log.php');
	}
	else {
		 header('Location: sign.php?result=existe');
	}
}

?>
