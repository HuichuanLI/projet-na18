<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/

require('./lib/init.php');

session_start();
if(empty($_SESSION['login'])){
	header('Location: log.php');
}



if($_SESSION['admin'] == false){
	$admin = "false";
}else{
	$admin = "true";
}



if($_SESSION['vendeur'] == false){
	$vendeur = "false";
}else{
	$vendeur = "true";
}

$sql = "SELECT * FROM produit";
$row = mQuery($sql);





if(empty($_POST)) {
	require(ROOT . '/view/admin/listproduit.html');
} 
?>
