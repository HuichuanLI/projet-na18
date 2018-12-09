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
$vSql = "SELECT * FROM public.utilisateur left join  public.vendeur ON utilisateur.login = vendeur.login WHERE utilisateur.login = '".$_SESSION['login']."'";
$row = mQuery($vSql);
$value = $row[0];





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
