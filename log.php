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
if(empty($_POST)) {
	require(ROOT . '/view/front/login.html');
} else {
	$user['login'] = trim($_POST['login']);
	if(empty($user['login'])) {
		var_dump('not empty');
	}

	$user['password'] = trim($_POST['password']);
	if(empty($user['password'])) {
		var_dump('password not empty');
	}
	$vSql = "SELECT login, mdp FROM public.utilisateur WHERE mail = '".$user['login']."' and mdp = '".$user['password']."';" ;
	$row = mQuery($vSql);
	if(!$row) {
    	var_dump('wrong id');
	} else {
	    session_start();
	    $_SESSION['login']=$row[0]['login'];
	    header('Location: homepage.php');
	}
}

?>
