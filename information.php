<?php


require('./lib/init.php');
date_default_timezone_set("Europe/Paris");


session_start();

if(empty($_SESSION['login'])){
  header('Location: log.php');
}

$vSql = "SELECT * FROM public.utilisateur  WHERE utilisateur.login = '".$_SESSION['login']."'";
$value = mQuery($vSql)[0];


if(empty($value["description"])){
	if($value["est_admin"] == true){
		$value["typeuser"] = "admin";
	}else{
		$value["typeuser"] = "acheteur";
		$vSql = "SELECT * FROM public.adresse join  public.vendeur ON adresse.login = vendeur.login WHERE utilisateur.login = '".$_SESSION['login']."'";
		$row = mQuery($vSql);
		$address = $row[0];

	}
}else{
	$value["typeuser"] = "vendeur";
}

if(empty($_POST)) {
	require(ROOT . '/view/admin/information.html');
}



?>
