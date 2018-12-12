<?php
require('./lib/init.php');
session_start();
if(!empty($_SESSION['login'])){
  $login = $_SESSION['login'];
  $sql = "SELECT * FROM produit_est_dans_le_panier, produit
  WHERE produit.ref_produit = produit_est_dans_le_panier.ref_produit
  AND produit_est_dans_le_panier.login = '$login'";
  $row = mQuery($sql);
  $listproduit = $row;


  // ACHETE ACTION
  if(isset($_POST['achat'])){
    $sql = "SELECT * FROM produit_est_dans_le_panier WHERE ref_produit = '".$_POST['achat']."' AND produit_est_dans_le_panier.login = '$login'";
    $result = mQuery($sql);
    $qtoriginal = $result[0]["quantite"];
    if((int)$_POST['ach']<= (int)$qtoriginal){

      $qt_mainteant = $qtoriginal - (int)$_POST['ach'];
      if($qt_mainteant == 0){
        $sql = "DELETE FROM public.produit_est_dans_le_panier WHERE ref_produit = '".$_POST['achat']."' AND produit_est_dans_le_panier.login = '$login'";
        $result = mExec($sql);
      }else{
        $sql = "UPDATE public.produit_est_dans_le_panier SET  quantite= $qt_mainteant WHERE ref_produit = '".$_POST['achat']."' AND produit_est_dans_le_panier.login = '$login'";
        $result = mExec($sql);
      }

      #achete action dans la table de utilisateur_achete_produit

      $sql = "SELECT * FROM public.utilisateur_achete_produit WHERE  ref_produit = '".$_POST['achat']."' AND login = '$login'";
      $result = mQuery($sql);

     // quand il a deja achat
     if($result == null){
        $sql = "INSERT INTO public.utilisateur_achete_produit(ref_produit, login, quantite) VALUES ('".$_POST['achat']."','$login' , ".$_POST['ach']."); ";
        $result = mExec($sql);
     }else{
        $achete = (int)$result[0]['quantite'] + (int)$_POST['ach'];
        $sql = "UPDATE public.utilisateur_achete_produit SET  quantite= ".$achete."  WHERE ref_produit = '".$_POST['achat']."' AND login = '$login'";
        $result = mExec($sql);
     }

    header('Location: homepage.php?result=achete avec succes');
    }else{
       header('Location: panier.php?result=error');
    }
  }

  //SUPPRIMER ACTION
  if(isset($_POST['supp'])){
    $sql = "SELECT * FROM produit_est_dans_le_panier WHERE ref_produit = '".$_POST['supp']."' AND produit_est_dans_le_panier.login = '$login'";
    $result = mQuery($sql);
    $qtoriginal = $result[0]["quantite"];
      $qtoriginal = $result[0]["quantite"];
      $supnum = (int)$_POST["supnum"];
      if((int)$qtoriginal < (int)$supnum){
          header('Location: panier.php?result=error');
      }else{
          $qt_mainteant  = (int)$qtoriginal - (int)$supnum;
         if($qt_mainteant == 0){
            $sql = "DELETE FROM public.produit_est_dans_le_panier WHERE ref_produit = '".$_POST['supp']."' AND produit_est_dans_le_panier.login = '$login'";
            $result = mExec($sql);
          }else{
            $sql = "UPDATE public.produit_est_dans_le_panier SET  quantite= $qt_mainteant WHERE ref_produit = '".$_POST['supp']."' AND produit_est_dans_le_panier.login = '$login'";
            $result = mExec($sql);
          }
          if($result == "true"){
               header('Location: panier.php');
          }
      }
  }

}else{
  header('Location: login.php?result=please login');
}
include(ROOT . '/view/front/panier.html');
?>
