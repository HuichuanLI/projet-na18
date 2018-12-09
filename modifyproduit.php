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




$sql = "SELECT * FROM public.produit where ref_produit = '".$_POST['ref_produit']."';";
$row = mQuery($sql);
$value = $row[0];


$sql = "SELECT * FROM promotion";
$promotion = mQuery($sql);


if(isset($_POST['Prix'])){
	if(empty($_POST['nom_promo1'])){
	$nom_promo = "NULL";
		$sql = "UPDATE public.produit SET  nom_produit='".$_POST['nom_produit']."', description='".$_POST['description']."', etat_produit='".$_POST['etat_produit']."', marque='".$_POST['marque']."', prix=".$_POST['Prix'].", categorie_produit='".$_POST['Categorie_produit']."', nom_promo=".$nom_promo.", url_photo='".$_POST['url_photo']."' WHERE ref_produit='".$_POST['ref_produit']."';";
		}else{
			$nom_promo = $_POST['nom_promo1'];
			$sql = "UPDATE public.produit SET  nom_produit='".$_POST['nom_produit']."', description='".$_POST['description']."', etat_produit='".$_POST['etat_produit']."', marque='".$_POST['marque']."', prix=".$_POST['Prix'].", categorie_produit='".$_POST['Categorie_produit']."', nom_promo='".$nom_promo."', url_photo='".$_POST['url_photo']."' WHERE ref_produit='".$_POST['ref_produit']."';";
		}

	$result = mExec($sql);	
	if($result == "true"){
			header('Location: listproduit.php?result=avec succes');
	}
}




require(ROOT . '/view/admin/modifyproduit.html');


?>
