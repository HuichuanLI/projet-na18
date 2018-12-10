<?php
require('./lib/init.php');
session_start();


if(!empty($_SESSION['login'])){

  $login = $_SESSION['login'];



  $sql = "SELECT * FROM produit_est_dans_le_panier, produit
  WHERE produit.ref_produit = produit_est_dans_le_panier.ref_produit";
  $row = mQuery($sql);



  if(isset($_POST['achat']) && isset($_POST['supp'])){

    $refProd = $_POST['achat'];
    $supp = $_POST['supp'];




    $sql2 = "INSERT INTO UTILISATEUR_ACHETE_PRODUIT VALUES
    ('$refProd', '$login')";
    $result = mExec($sql2);


    if ($result) {
      $delSql = "DELETE FROM produit_est_dans_le_panier
      WHERE ref_produit = '$refProd'";
      $vretour = mExec($delSql);
      header('Location: panier.php');

    }

    $sql3 = "DELETE FROM produit_est_dans_le_panier
    WHERE ref_produit = '$supp'";
    $vretour2 = mExec($sql3);
    header('Location: panier.php');



  }

}

  include(ROOT . '/view/front/panier.html');

  ?>
