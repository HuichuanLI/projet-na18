<?php


require('./lib/init.php');
date_default_timezone_set("Europe/Paris");


session_start();

if(empty($_SESSION['login'])){
  header('Location: log.php');
}

$vSql = "SELECT * FROM public.utilisateur   WHERE utilisateur.login = '".$_SESSION['login']."'";
$value = mQuery($vSql)[0];

$vSql = "SELECT * FROM public.utilisateur LEFT JOIN public.vendeur ON vendeur.login = utilisateur.login WHERE utilisateur.login = '".$_SESSION['login']."' ";

$value = array_merge($value,mQuery($vSql)[0]);


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

if(isset($_POST['login'])){

	$sql = "UPDATE public.utilisateur SET mdp='".$_POST['password1']."', nom='".$_POST['nom']."', prénom='".$_POST['prenom']."' WHERE login='".$_POST['login']."';";
	$result = mExec($sql);
	if($value["typeuser"] == "vendeur"){
		$sql = "UPDATE public.vendeur SET  description='".$_POST['description']."', siret='".$_POST['siret']."', nom_magasin='".$_POST['magasin']."' WHERE login='".$_POST['login']."';";
		$result = mExec($sql);
	}
	if($result == true){
		header('Location: information.php?result=avec success');
	}else{
		header('Location: information.php?result=non success');
	}


}

if(empty($_POST)) {
	require(ROOT . '/view/admin/information.html');
}



?>
