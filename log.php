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
if(!empty($_SESSION['login'])){
  header('Location: homepage.php');
}


if(empty($_POST)) {
	require(ROOT . '/view/front/login.html');
} else {
	$user['login'] = trim($_POST['login']);
	if(empty($user['login'])) {
		header('Location: log.php');
	}

	$user['password'] = trim($_POST['password']);
	if(empty($user['password'])) {
		header('Location: log.php');
	}
	$vSql = "SELECT login, mdp,est_admin FROM public.utilisateur WHERE login = ? and mdp = ?" ;
	
	$row = mNewQuery($vSql,$model = 2, array($user['login'],$user['password']));


	if(!$row) {
    	header('Location: log.php');
	} else {
	    unset($_SESSION['login']);
		unset($_SESSION['admin']);
	    $_SESSION['login']=$row[0]['login'];
	    $_SESSION['admin']=$row[0]['est_admin'];
	    header('Location: index.php');
	}
}

?>
