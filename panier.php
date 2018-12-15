<?php
require('./lib/init.php');
date_default_timezone_set("Europe/Paris");
session_start();
if(!empty($_SESSION['login'])){
  $login = $_SESSION['login'];
  $sql = "SELECT * FROM produit_est_dans_le_panier, produit
  WHERE produit.ref_produit = produit_est_dans_le_panier.ref_produit
  AND produit_est_dans_le_panier.login = '$login'";
  $row = mQuery($sql);
  $listproduit = $row;

  
  // ACHETE ACTION
  // var_dump($sql);

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


    // update la table de date_commande  
    $date = new DateTime();
    $date_crea =$date->format('Y-m-d H:i:s');
    $sqlcommande = "INSERT INTO public.commande(date_commande, statut_commande,login) VALUES ('".$date_crea."', 'payée','".$_SESSION['login']."');";
   

    // $result = mExec($sqlcommande);

    $sql = "SELECT * FROM public.commande where date_commande = '".$date_crea."';";
    $result = mQuery($sql);
    $num_commande = $result[0]["num_commande"];
    
    for($index = 0 ; $index < count($listproduit); $index++){
        $sql = "INSERT INTO public.produit_commande (ref_produit, num_commande, quantite) VALUES ('".$listproduit[$index]["ref_produit"]."', ".$num_commande.", ".$listproduit[$index]["quantite"].");";
        $result = mExec($sql);
    }
   

    // header('Location: homepage.php?result=achete avec succes');
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

  // achete tous 
  if(isset($_POST['achetertous'])){
    $date = new DateTime();
    $date_crea =$date->format('Y-m-d H:i:s');
    $sqlcommande = "INSERT INTO public.commande(date_commande, statut_commande,login) VALUES ('".$date_crea."', 'payée','".$_SESSION['login']."');";
    $result = mExec($sqlcommande);

    // probleme 
    $sql = "SELECT * FROM public.commande where date_commande = '".$date_crea."';";
    $result = mQuery($sql);
    
    $num_commande = $result[0]["num_commande"];



    for($index = 0 ; $index < count($listproduit); $index++){
        $sql = "INSERT INTO public.produit_commande (ref_produit, num_commande, quantite) VALUES ('".$listproduit[$index]["ref_produit"]."', ".$num_commande.", ".$listproduit[$index]["quantite"].");";
        $result = mExec($sql);

        $sql = "SELECT * FROM public.utilisateur_achete_produit WHERE  ref_produit = '".$listproduit[$index]["ref_produit"]."' AND login = '$login'";
        $result = mQuery($sql);

       // quand il a deja achat
       if($result == null){
          $sql = "INSERT INTO public.utilisateur_achete_produit(ref_produit, login, quantite) VALUES ('".$listproduit[$index]['ref_produit']."','$login' , ".$listproduit[$index]['quantite']."); ";
          $result = mExec($sql);
       }else{
          $achete = (int)$result[0]['quantite'] + (int)$listproduit[$index]['quantite'];
          $sql = "UPDATE public.utilisateur_achete_produit SET  quantite= ".$achete."  WHERE ref_produit = '".$listproduit[$index]['ref_produit']."' AND login = '$login'";
          $result = mExec($sql);
       }
        $sql = "DELETE FROM public.produit_est_dans_le_panier WHERE ref_produit = '".$listproduit[$index]["ref_produit"]."' AND produit_est_dans_le_panier.login = '$login'";
        $result = mExec($sql);
    }
    if($result == "true"){
      header('Location: homepage.php?result=achete avec succes');
    }
  }

}else{
  header('Location: login.php?result=please login');
}
include(ROOT . '/view/front/panier.html');
?>
