<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/
session_start();
unset($_SESSION['login']);
unset($_SESSION['admin']);

unset($_SESSION['vendeur']);
header('Location: log.php');
?>
