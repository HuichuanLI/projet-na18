<?php




require('./lib/init.php');

session_start();

//requête pour récupérer les produits à afficher avec l'annonce qui correspont
$sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit";
$row = mQuery($sql);


$sql = "SELECT ref_produit,nom_produit FROM public.produit";
$result  = mQuery($sql);
//requête qui gère l'achat

  if (isset($_POST['buy'])){
    $reprod = $_POST['buy'];
    $login_acheteur = $_SESSION['login'];

    $sql2 = "INSERT INTO produit_est_dans_le_panier VALUES
    ('$reprod','$login_acheteur')";
    $result = mConn()->prepare($sql2);
    $retour = $result->execute();
  }


require('./view/front/index.html');

?>
