<?php
require('./lib/init.php');
session_start();


if(!empty($_SESSION['login'])){

  $login = $_SESSION['login'];



  $sql = "SELECT * FROM produit_est_dans_le_panier, produit
  WHERE produit.ref_produit = produit_est_dans_le_panier.ref_produit
  AND produit_est_dans_le_panier.login = '$login'";
  $row = mQuery($sql);





  if(isset($_POST['achat']) && isset($_POST['supp'])){

    $refProd = $_POST['achat'];
    $supp = $_POST['supp'];

    if(isset($_POST['ach'])){
      $qt = $_POST['ach'];
    }

    if(isset($_POST['spr'])){
      $qtsupr = $_POST['spr'];
    }

    //quantite panier
    $Quant = "SELECT quantite FROM produit_est_dans_le_panier
    WHERE ref_produit = '$refProd'";
    $qt_panier = mQuery($Quant)[0];


    $sql3 = "SELECT quantite FROM UTILISATEUR_ACHETE_PRODUIT
    WHERE ref_produit = '$refProd'";
    $qt_achat = mQuery($sql3)[0];
    var_dump($qt_achat);


var_dump($qt <= $qt_panier && $qt_achat['quantite'] == NULL);

    if ($qt <= $qt_panier && $qt_achat['quantite'] == NULL){
      $sql2 = "INSERT INTO UTILISATEUR_ACHETE_PRODUIT VALUES
      ('$refProd', '$login','$qt')";
      $result = mExec($sql2);
    }

    if( empty($_POST["ach"]) && (int)$qt <= (int)$qt_panier ){
      $update_valeur_panier = $qt_panier['quantite'] - $qt;
      $update_valeur_table_achat = $qt_achat['quantite'] + $qt;


      $updtSql =  "UPDATE produit_est_dans_le_panier
      SET quantite = $update_valeur_panier
      WHERE ref_produit = '$refProd'";
      $result = mExec($updtSql);

      $updtSql2 =  "UPDATE UTILISATEUR_ACHETE_PRODUIT
      SET quantite = $update_valeur_table_achat
      WHERE ref_produit = '$refProd'";
      $result = mExec($updtSql2);

      if($update_valeur_panier == 0) {
        $delSql = "DELETE FROM produit_est_dans_le_panier
        WHERE ref_produit = '$refProd'";
        $vretour = mExec($delSql);
        header('Location: panier.php');
      }
      header('Location: panier.php');
    }





//a fixer
    //form delete
    if(isset($_POST['spr'])){
      $suppr_val = (int)$qt_panier['quantite'] - (int)$qtsupr;
      $sqldel = "UPDATE produit_est_dans_le_panier
      SET quantite = $suppr_val
      WHERE ref_produit = '$supp'";
      $vretour2 = mExec($sqldel);
      header('Location: panier.php');

      if($suppr_val == 0){
        $sqldel = "DELETE FROM produit_est_dans_le_panier
        WHERE ref_produit = '$supp'";
        $vretour2 = mExec($sqldel);
      }
    }


  }

}

include(ROOT . '/view/front/panier.html');

?>
