
<?php
require('./lib/init.php');
session_start();
//filtrage des données
if(isset($_GET['categorie'])){
    $categorie = $_GET['categorie'];
    $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and produit.categorie_produit ='".$categorie."';";
    $row = mQuery($sql);
    $sql = "SELECT ref_produit,nom_produit FROM public.produit where produit.categorie_produit ='".$categorie."';";
    $listproduit  = mQuery($sql);
}else if (isset($_GET['etat'])){
  $etat = $_GET['etat'];
  $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and produit.etat_produit ='".$etat."';";
  $row = mQuery($sql);
  $sql = "SELECT ref_produit,nom_produit FROM public.produit where produit.categorie_produit ='".$etat."';";
  $listproduit  = mQuery($sql);
}else if (!empty($_GET['prix_min']) && !empty($_GET['prix_max'])){
  $prix_min = $_GET['prix_min'];
  $prix_max = $_GET['prix_max'];
  $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and produit.prix between '$prix_min' and '$prix_max'";
  $row = mQuery($sql);

}else if (isset($_GET['vendeur'])){
  $vd = $_GET['vendeur'];
  $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit and annonce.login_vendeur = '$vd'";
  $row = mQuery($sql);

}else if (isset($_POST['prix'])){
  $prix = $_POST['prix'];
  if ($prix == 'Prix croissant'){
    $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit
    order by prix ASC";
    $row = mQuery($sql);
  }else if ($prix == 'Prix décroissant'){
    $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit
    order by prix DESC";
    $row = mQuery($sql);
  }


}else{
    $sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit";
    $row = mQuery($sql);
    $sql = "SELECT ref_produit,nom_produit FROM public.produit";
    $listproduit  = mQuery($sql);
}






$sql = "SELECT distinct categorie_produit FROM produit;";
$categories = mQuery($sql);



$sql = "SELECT distinct etat_produit FROM produit;";
$etats = mQuery($sql);

$sql = "SELECT distinct login_vendeur FROM annonce";
$vendeurs = mQuery($sql);






//requête qui gère l'achat
  if (isset($_POST['buy'])){
    $reprod = $_POST['buy'];
    $login_acheteur = $_SESSION['login'];
    $qt = $_POST['qt'];
    $sql = "SELECT * FROM public.produit_est_dans_le_panier where ref_produit = '".$reprod."' and login = '".$login_acheteur."';";
    $result = mQuery($sql);
    if($result == null){
    	$insertsql = "INSERT INTO produit_est_dans_le_panier VALUES ('$reprod','$login_acheteur','$qt')";
    	$result = mExec($insertsql);
    }else{
    	$qt = $result[0]["quantite"] + $qt;
    	$updatesql = "UPDATE public.produit_est_dans_le_panier SET quantite='$qt' WHERE ref_produit = '".$reprod."' and login = '".$login_acheteur."';";
    	$result = mExec($updatesql);
    }
    if($result == "true"){
    	header('Location: panier.php');
    }
  }
require('./view/front/index.html');
?>
]
