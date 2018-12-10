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
if(isset($_POST['promotion'])){
	
	// update the promotion
	if(isset($_POST['debut'])){
		// $sql = ""

	}



	$vSql = "SELECT * FROM public.promotion  WHERE promotion.nom_promo = '".$_POST['promotion']."'";
	$row = mQuery($vSql);
	$value = $row[0];




}
require(ROOT . '/view/admin/modifierpromorion.html');

?>
