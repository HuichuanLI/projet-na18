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

if(empty($_SESSION['login'])){
  header('Location: log.php');
}

if($_SESSION['admin'] == false){
	$admin = "false";
}else{
	$admin = "true";
}


$sql = "SELECT * FROM promotion";
$result = mConn()->prepare($sql);
$result->execute();
$row = mQuery($sql);

require(ROOT . '/view/admin/listpropmotion.html');


?>

