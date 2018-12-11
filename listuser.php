<?php


require('./lib/init.php');
date_default_timezone_set("Europe/Paris");


session_start();

if(empty($_SESSION['login'])){
  header('Location: log.php');
}

if($_SESSION['admin'] == false){
	$admin = "false";
}else{
	$admin = "true";
}

if($_SESSION['vendeur'] == "false"){
	$vendeur = "false";
}else{
	$vendeur = "true";
}


$sql = "SELECT * FROM utilisateur";
$result = mConn()->prepare($sql);
$result->execute();
$row = mQuery($sql);

require(ROOT . '/view/admin/listuser.html');


?>

