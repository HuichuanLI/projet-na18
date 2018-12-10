<?php
session_start();
unset($_SESSION['login']);
unset($_SESSION['admin']);
unset($_SESSION['vendeur']);
header('Location: log.php');
?>
