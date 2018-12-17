<?php




require('./lib/init.php');

session_start();

//requête pour récupérer les produits à afficher avec l'annonce qui correspont


if(isset($_GET['categorie'])){
    $categorie = $_GET['categorie'];
    $sql = "SELECT * FROM produit, annonce left join solde_intermediate on solde_intermediate.ref_produit = annonce.ref_produit WHERE produit.ref_produit = annonce.ref_produit and produit.categorie_produit ='".$categorie."';";
    $row = mQuery($sql);
    $sql = "SELECT ref_produit,nom_produit FROM public.produit where produit.categorie_produit ='".$categorie."';";
   
    $listproduit  = mQuery($sql);


}else{
    $sql = "SELECT * FROM produit, annonce left join solde_intermediate on solde_intermediate.ref_produit = annonce.ref_produit  WHERE produit.ref_produit = annonce.ref_produit";
    $row = mQuery($sql);

    $sql = "SELECT ref_produit,nom_produit FROM public.produit";
    $listproduit  = mQuery($sql);

}


// partie de discount


$sql = "SELECT distinct categorie_produit FROM produit;";

$categories = mQuery($sql);

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
