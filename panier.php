<?php
require('./lib/init.php');
session_start();


if(!empty($_SESSION['login'])){

  $login = $_SESSION['login'];



  $sql = "SELECT * FROM produit_est_dans_le_panier, produit
  WHERE produit.ref_produit = produit_est_dans_le_panier.ref_produit";
  $row = mQuery($sql);



  if(isset($_POST['achat'])){

    $refProd = $_POST['achat'];
    $sql2 = "INSERT INTO UTILISATEUR_ACHETE_PRODUIT VALUES
    ('$refProd', '$login')";
    $result = mConn()->prepare($sql2);
    $retour = $result->execute();

    if ($retour) {
      $delSql = "DELETE FROM produitest_dans_le_panier
      WHERE ref_produit = '$refProd'";
      $vretour = $mExec($delSql);
      header('Location: panier.php');

    }

  }

}

  include(ROOT . '/view/front/panier.html');

  ?>
