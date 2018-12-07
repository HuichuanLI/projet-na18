<?php

require('./lib/init.php');

session_start();
if(empty($_SESSION['login'])){
	header('Location: log.php');
}

if(empty($_POST)) {
	require(ROOT . '/view/front/modifier.html');
} else {
