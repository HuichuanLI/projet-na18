<?php


require('./lib/init.php');
date_default_timezone_set("Europe/Paris");


session_start();

if(empty($_SESSION['login'])){
  header('Location: log.php');
}

$vSql = "SELECT * FROM public.utilisateur   WHERE utilisateur.login = ?;";
$value = mNewQuery($vSql,$model=2,array($_SESSION['login']))[0];

$vSql = "SELECT * FROM public.utilisateur LEFT JOIN public.vendeur ON vendeur.login = utilisateur.login WHERE utilisateur.login = ? ";

$value = array_merge($value,mNewQuery($vSql,$model = 2, array($_SESSION['login']))[0]);


if(empty($value["description"])){
	if($value["est_admin"] == true){
		$value["typeuser"] = "admin";
	}else{
		$value["typeuser"] = "acheteur";
		$vSql = "SELECT * FROM public.adresse join  public.vendeur ON adresse.login = vendeur.login WHERE utilisateur.login = ?";
		$row = mNewQuery($vSql, $model =2, array($_SESSION['login']));
		$address = $row[0];

	}
}else{
	$value["typeuser"] = "vendeur";
}

if(isset($_POST['login'])){

	$sql = "UPDATE public.utilisateur SET mdp=?, nom=?, prénom=? WHERE login=?;";
	
	$result = mNewExec($sql,$model = 2,array($_POST['password1'],$_POST['nom'],$_POST['prenom'],$_POST['login']));
	if($value["typeuser"] == "vendeur"){
		$sql = "UPDATE public.vendeur SET  description= ?, siret= ?, nom_magasin= ? WHERE login= ?;";
		$result = mNewExec($sql, $model = 2, array($_POST['description'],$_POST['siret'],$_POST['magasin'],$_POST['login']);
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
