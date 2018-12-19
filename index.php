<?php




require('./lib/init.php');

session_start();

//requête pour récupérer les produits à afficher avec l'annonce qui correspont


if(isset($_GET['categorie'])){
    $categorie = $_GET['categorie'];
    // exemple resoudre
    $sql = "SELECT * FROM produit, annonce left join solde_intermediate on solde_intermediate.ref_produit = annonce.ref_produit WHERE produit.ref_produit = annonce.ref_produit and produit.categorie_produit = :categorie;";
    $row = mNewQuery($sql,$model = 1,array('categorie' => $categorie));
    // exemple resoudre
    $sql = "SELECT ref_produit,nom_produit FROM public.produit where produit.categorie_produit = :categorie;";
    $listproduit = mNewQuery($sql,$model = 1,array('categorie' => $categorie));

}else{
    $sql = "SELECT * FROM produit, annonce left join solde_intermediate on solde_intermediate.ref_produit = annonce.ref_produit  WHERE produit.ref_produit = annonce.ref_produit";
    $row = mNewQuery($sql);

    $sql = "SELECT ref_produit,nom_produit FROM public.produit";
    $listproduit  = mNewQuery($sql);

}


// partie de discount


$sql = "SELECT distinct categorie_produit FROM produit;";

$categories = mNewQuery($sql);

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
