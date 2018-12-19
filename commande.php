<?php




require('./lib/init.php');
session_start();

if(empty($_SESSION['login'])){
  header('Location: log.php');
}


if(isset($_GET['commande'])){
	$commande = $_GET['commande'];
	
	$sql = "SELECT produit_commande.prix, produit_commande.ref_produit, produit.nom_produit, produit.etat_produit, produit.categorie_produit, produit_commande.quantite, produit.marque FROM public.produit_commande,public.produit where produit_commande.ref_produit = produit.ref_produit and produit_commande.num_commande = ?;";

	$row = mNewQuery($sql,$model=2,array($commande));


	$sql = "SELECT * FROM public.commande where num_commande = ?;";
	$result = mNewQuery($sql,$model=2,array($commande))[0];

	if(isset($_POST['recu'])){
		$sql = "UPDATE public.commande SET statut_commande='livrée' WHERE num_commande= ?;";
		$result = mNewExec($sql,$model=2,array($commande));
		header('Location: commande.php?commande='.$commande);
	}
}



include(ROOT . '/view/admin/commande.html');
?>
