<?php



require('./lib/init.php');

session_start();

//requête pour récupérer les produits à afficher avec l'annonce qui correspont
$sql = "SELECT * FROM produit, annonce WHERE produit.ref_produit = annonce.ref_produit";
$row = mQuery($sql);

//requête qui gère l'achat



if(!empty($_SESSION['login'])){

  $reprod = isset($_POST['buy']);
  $login_acheteur = $_SESSION['login'];

  $sql2 = "INSERT INTO UTILISATEUR_ACHETE_PRODUIT VALUES
  ('$reprod', '$login_acheteur')";
  
  $result = mConn()->prepare($sql2);
  $retour = $result->execute();
}


require('./view/front/index.html');

?>
