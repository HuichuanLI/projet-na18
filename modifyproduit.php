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




$sql = "SELECT * FROM public.produit where ref_produit = ?;";
$row = mNewQuery($sql,$model=2,array($_POST['ref_produit']));
$value = $row[0];


$sql = "SELECT * FROM promotion";
$promotion = mQuery($sql);

if(isset($_POST['Prix'])){
	if(empty($_POST['nom_promo1'])){
	$nom_promo = "NULL";
		$sql = "UPDATE public.produit SET  nom_produit= ?, description= ?, etat_produit= ?, marque= ?, prix= ?, categorie_produit=?, nom_promo=?, url_photo=? WHERE ref_produit=?;";
		}else{
			$nom_promo = $_POST['nom_promo1'];
			$sql = "UPDATE public.produit SET  nom_produit=?, description=?, etat_produit=?, marque=?, prix=?, categorie_produit=?, nom_promo=？, url_photo=? WHERE ref_produit=?;";
		}

	$result = mNewExec($sql,$model = 2,array($_POST['nom_produit'],$_POST['description'],$_POST['etat_produit'],$_POST['marque'],$_POST['Prix'],$_POST['Categorie_produit'],$nom_promo,$_POST['url_photo'],$_POST['ref_produit']));	

	if($result == "true"){
			header('Location: listproduit.php?result=avec succes');
	}
}




require(ROOT . '/view/admin/modifyproduit.html');


?>
