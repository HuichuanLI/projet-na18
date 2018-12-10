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
if(empty($_POST)) {
	require(ROOT . '/view/front/modifier.html');
} else {
	$login = $_SESSION['login'];
	$password = $_POST['password1'];
	$sql = "UPDATE public.utilisateur SET mdp ='".$password."' WHERE login ='".$login."';";
	$row = mQuery($sql);
	header('Location: homepage.php');
}
?>