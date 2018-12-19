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


// pour connecter sur cette page
session_start();
if(empty($_SESSION['login'])){
  header('Location: log.php');
}

if(isset($_POST['promotion'])){
	
	// update the promotion

	if(isset($_POST['debut'])){
		$sql = "UPDATE public.promotion SET  debut= ?, fin='".$_POST['fin']."', rabais='".$_POST['rabais']."' WHERE promotion.nom_promo= '".$_POST['promotion']."';";
		$row = mNewQuery($sql,$model = 2,array($_POST['debut']));
		if($row == "true"){
			header('Location: listpromotion.php?result=avec success');
		}
	}
	$vSql = "SELECT * FROM public.promotion  WHERE promotion.nom_promo = '".$_POST['promotion']."'";
	$row = mQuery($vSql);
	$value = $row[0];
}

// delete function
if(isset($_POST['delete'])){
	//update all the produit with the promotion
	$sql = "UPDATE public.produit SET nom_promo= NULL WHERE nom_promo = '".$_POST['promotion']."';";
	$row = mExec($sql);
	$sql ="DELETE FROM public.promotion WHERE promotion.nom_promo= '".$_POST['promotion']."';";
	$result = mExec($sql);
	if($result == "true"){
		header('Location: listpromotion.php?result=avec success');
	}
	
}


require(ROOT . '/view/admin/modifierpromorion.html');

?>
