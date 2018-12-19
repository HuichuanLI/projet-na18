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
if(empty($_SESSION['login'])){
  header('Location: log.php');
}


if(empty($_POST)) {

	$sql = "SELECT ref_produit,nom_produit FROM public.produit";
	$result  = mNewQuery($sql);
	require(ROOT . '/view/admin/addannonce.html');
} else {

	if(empty($_POST['Ref_annonce']) || empty($_POST['debut']) || empty($_POST['ref_produit'])){
		header('Location: addannonce.php');
	}

  $nomp = $_POST['Pnom'];
  $marque = $_POST['Pmarque'];
  $description = $_POST['Pdes'];
  $etat = $_POST['Petat'];
  $prix = $_POST['Pprix'];
  $nomp = $_POST['Pnom'];
  $cat = $_POST['Pcat'];
  $url = $_POST['Purl'];
  $ref = $_POST['ref_produit'];


  $sql="INSERT INTO produit (ref_produit, nom_produit, description, etat_produit, marque, prix, categorie_produit, url_photo)
  VALUES (?,?,?,?,?,?,?,?)";
  $result = mNewExec($sql,$model=2,array($ref,$nomp,$description,$etat,$marque,$prix,$cat,$url));
  


  if($result == "true"){
    header('Location: listannonce.php');
  }else{
    header('Location: listannonce.php?result=problème ajout produit');
  }


	$sql2 ="INSERT INTO public.annonce(ref_annonce, date_mise_en_ligne, ref_produit, login_vendeur)VALUES (?,?,?,?);";
	$result2 = mNewExec($sql2,$model=2,array($_POST['Ref_annonce'],$_POST['debut'],$ref,$_SESSION['login']));




	if($result2 == "true"){
		header('Location: listannonce.php');
	}else{
		header('Location: listannonce.php?result=problem');
	}

}

?>
