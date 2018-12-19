<?php

require('./lib/init.php');

session_start();

//requête pour récupérer les produits à afficher avec l'annonce qui correspont


if(isset($_GET['categorie'])){
    // for the  filitre part 
    $categorie = $_GET['categorie'];
    // exemple resoudre
    $sql = "SELECT * FROM solde_intermediate right join  annonce on solde_intermediate.ref_produit = annonce.ref_produit ,produit WHERE produit.ref_produit = annonce.ref_produit and produit.categorie_produit = :categorie;";
    $row = mNewQuery($sql,$model = 1,array('categorie' => $categorie));
    // exemple resoudre
    $sql = "SELECT ref_produit,nom_produit FROM public.produit where produit.categorie_produit = :categorie;";
    $listproduit = mNewQuery($sql,$model = 1,array('categorie' => $categorie));
    }else if (isset($_GET['etat'])){
      $etat = $_GET['etat'];
      $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and produit.etat_produit = ?;";
      $row = mNewQuery($sql,$model = 2 ,array($etat));
      $sql = "SELECT ref_produit,nom_produit FROM public.produit where produit.categorie_produit = ?;";
      $listproduit = mNewQuery($sql,$model = 2 ,array($etat));
    }else if (!empty($_GET['prix_min']) && !empty($_GET['prix_max'])){
      $prix_min = $_GET['prix_min'];
      $prix_max = $_GET['prix_max'];
      $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and produit.prix between ? and ?";
      $row = mNewQuery($sql,$model = 2 ,array($prix_min,$prix_max));

    }else if (isset($_GET['vendeur'])){
      $vd = $_GET['vendeur'];
      $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and annonce.login_vendeur = ?";
      $row = mNewQuery($sql,$model = 2, array($vd));

    }else if (isset($_POST['prix'])){
      $prix = $_POST['prix'];
      if ($prix == 'Prix croissant'){
        $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit
        order by prix ASC";
        $row = mNewQuery($sql);
      }else if ($prix == 'Prix décroissant'){
        $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit
        order by prix DESC";
        $row = mNewQuery($sql);
      }
    }else{
        $sql = "SELECT * FROM  solde_intermediate  right join annonce on solde_intermediate.ref_produit = annonce.ref_produit ,produit WHERE produit.ref_produit = annonce.ref_produit";
        $row = mNewQuery($sql);
        $sql = "SELECT ref_produit,nom_produit FROM public.produit";
        $listproduit  = mNewQuery($sql);
    }


// partie de discount


$sql = "SELECT distinct categorie_produit FROM produit;";

$categories = mNewQuery($sql);
$sql = "SELECT distinct etat_produit FROM produit;";
$etats = mQuery($sql);

$sql = "SELECT distinct login_vendeur FROM annonce";
$vendeurs = mQuery($sql);





//requête qui gère l'achat

  if (isset($_POST['buy'])){
    $reprod = $_POST['buy'];
    $login_acheteur = $_SESSION['login'];
    $qt = $_POST['qt'];
    $sql = "SELECT * FROM public.produit_est_dans_le_panier where ref_produit = ? and login = ?;";
    $array= array($reprod, $login_acheteur);
    $result = mNewQuery($sql,$model= 2,$array);
    if($result == null){
    	$insertsql = "INSERT INTO public.produit_est_dans_le_panier (ref_produit, login, quantite) VALUES (?, ?, ?);";
    	$result = mNewExec($insertsql,$model = 2,array($reprod, $login_acheteur, $qt));
    }else{
    	$qt = $result[0]["quantite"] + $qt;
    	$updatesql = "UPDATE public.produit_est_dans_le_panier SET quantite= ? WHERE ref_produit = ? and login = ?;";
        $result = mNewExec($updatesql,$model = 2, array($qt, $reprod ,$login_acheteur));
    }
    if($result == "true"){
    	header('Location: panier.php');
    }

  }


require('./view/front/index.html');

?>
