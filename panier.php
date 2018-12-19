<?php
require('./lib/init.php');
date_default_timezone_set("Europe/Paris");
session_start();
if(!empty($_SESSION['login'])){
  $login = $_SESSION['login'];
  $sql = "SELECT * FROM produit_est_dans_le_panier,  solde_intermediate right join  produit on solde_intermediate.ref_produit = produit.ref_produit 
  WHERE produit.ref_produit = produit_est_dans_le_panier.ref_produit
  AND produit_est_dans_le_panier.login = ?";
  $row = mNewQuery($sql,$model= 2, array($login));
  
  $listproduit = $row;


  // ACHETE ACTION
  
  if(isset($_POST['achat'])){
    $sql = "SELECT * FROM produit_est_dans_le_panier WHERE ref_produit = '".$_POST['achat']."' AND produit_est_dans_le_panier.login = ?";
    $result1 = mNewQuery($sql,$model= 2, array($login));
    $qtoriginal = $result1[0]["quantite"];

    if((int)$_POST['ach']<= (int)$qtoriginal){
      $qt_mainteant = $qtoriginal - (int)$_POST['ach'];

      if($qt_mainteant == 0){
        $sql = "DELETE FROM public.produit_est_dans_le_panier WHERE ref_produit = ? AND produit_est_dans_le_panier.login = ?";
        $result = mNewExec($sql,$model = 2, array($_POST['achat'],$login));
      }else{
        $sql = "UPDATE public.produit_est_dans_le_panier SET  quantite= $qt_mainteant WHERE ref_produit = ? AND produit_est_dans_le_panier.login = ?";
        $result = mNewExec($sql,$model = 2, array($_POST['achat'],$login));
      }

      #achete action dans la table de utilisateur_achete_produit

      $sql = "SELECT * FROM public.utilisateur_achete_produit WHERE  ref_produit = ? AND login = ?";
      $row = mNewQuery($sql,$model= 2, array($_POST['achat'],$login));

     // quand il a deja achat
     if($result == null){
        $sql = "INSERT INTO public.utilisateur_achete_produit(ref_produit, login, quantite) VALUES (?,?,?); ";
        $result = mNewExec($sql,$model = 2, array($_POST['achat'],$login,$_POST['ach']));
     }else{
        $achete = (int)$result[0]['quantite'] + (int)$_POST['ach'];
        $sql = "UPDATE public.utilisateur_achete_produit SET  quantite= ? WHERE ref_produit = ? AND login = ?";
        $result = mNewExec($sql, $model = 2 ,array($achete,$_POST['achat'],$login));
     }


    // update la table de date_commande  
    $date = new DateTime();
    $date_crea =$date->format('Y-m-d H:i:s');
    $sqlcommande = "INSERT INTO public.commande(date_commande, statut_commande,login) VALUES (?, ?,?);";
    $result = mNewExec($sqlcommande,$model = 2 ,array($date_crea,'payée',$_SESSION['login']));
    


    // $result = mExec($sqlcommande);

    $sql = "SELECT * FROM public.commande where date_commande = ?;";
    $result = mNewQuery($sql,$model = 2 ,array($date_crea));
    $num_commande = $result[0]["num_commande"];
    
    /* for the table prix*/ 
    $sql = "SELECT * FROM public.produit left join solde_intermediate on solde_intermediate.ref_produit = produit.ref_produit where produit.ref_produit = ?;";
    $ligne = mNewQuery($sql,$model = 2,array($_POST['achat']));
    if(!empty($ligne[0]['prix_maintenant']) && $ligne[0]['prix_maintenant'] != $ligne[0]['prix_original']){
      $prix = $ligne[0]['prix_maintenant'];
    }else{
      $prix = $ligne[0]['prix'];
    }


    $sql = "INSERT INTO public.produit_commande (ref_produit, num_commande, quantite,prix) VALUES (?, ?, ?,?);";
    $result = mNewExec($sql,$model = 2,array($_POST['achat'],$num_commande,$_POST['ach'],$prix));
   

    header('Location: homepage.php?result=achete avec succes');
    }else{
       header('Location: panier.php?result=error');
    }
  }

  //SUPPRIMER ACTION
  if(isset($_POST['supp'])){
    $sql = "SELECT * FROM produit_est_dans_le_panier WHERE ref_produit = ? AND produit_est_dans_le_panier.login = ?";
    $result = mNewQuery($sql,$model =2 , array($_POST['supp'],$login));
    $qtoriginal = $result[0]["quantite"];
      $qtoriginal = $result[0]["quantite"];
      $supnum = (int)$_POST["supnum"];
      if((int)$qtoriginal < (int)$supnum){
          header('Location: panier.php?result=error');
      }else{
          $qt_mainteant  = (int)$qtoriginal - (int)$supnum;
         if($qt_mainteant == 0){
            $sql = "DELETE FROM public.produit_est_dans_le_panier WHERE ref_produit = ? AND produit_est_dans_le_panier.login = ?";
            $result = mNewExec($sql,$model =2,array($_POST['supp'],$login));
          }else{
            $sql = "UPDATE public.produit_est_dans_le_panier SET  quantite= $qt_mainteant WHERE ref_produit = ? AND produit_est_dans_le_panier.login = ?";
            $result = mNewExec($sql, $model =2 ,array($_POST['supp'],$login));
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
    $sqlcommande = "INSERT INTO public.commande(date_commande, statut_commande,login) VALUES (?, ?,?);";
    $result = mNewExec($sqlcommande,$model =2 ,array($date_crea,'payée',$_SESSION['login']));

    // probleme 
    $sql = "SELECT * FROM public.commande where date_commande = ?;";
    $result = mNewQuery($sql,$model =2 ,array($date_crea));
    
    $num_commande = $result[0]["num_commande"];



    for($index = 0 ; $index < count($listproduit); $index++){

        $sql = "SELECT * FROM public.produit left join solde_intermediate on solde_intermediate.ref_produit = produit.ref_produit where produit.ref_produit = ?;";
        $ligne = mNewQuery($sql,$model =2 ,array($listproduit[$index]["ref_produit"]));


        if(!empty($ligne[0]['prix_maintenant']) && $ligne[0]['prix_maintenant'] != $ligne[0]['prix_original']){
          $prix = $ligne[0]['prix_maintenant'];
        }else{
          $prix = $ligne[0]['prix'];
        }

        $sql = "INSERT INTO public.produit_commande (ref_produit, num_commande, quantite,prix) VALUES (?, ?, ?,?);";
        $result = mNewExec($sql,$model =2,array($listproduit[$index]["ref_produit"],$num_commande,$listproduit[$index]["quantite"],$prix));

        $sql = "SELECT * FROM public.utilisateur_achete_produit WHERE  ref_produit = ? AND login = ?";
        $result = mNewQuery($sql,$model =2, array($listproduit[$index]["ref_produit"],$login));

       // quand il a deja achat
       if($result == null){
          $sql = "INSERT INTO public.utilisateur_achete_produit(ref_produit, login, quantite) VALUES (?,?,?); ";
          $result = mNewExec($sql, $model =2, array($listproduit[$index]['ref_produit'],$login,$listproduit[$index]['quantite']));
       }else{
          $achete = (int)$result[0]['quantite'] + (int)$listproduit[$index]['quantite'];
          $sql = "UPDATE public.utilisateur_achete_produit SET  quantite= ? WHERE ref_produit = ? AND login = ?";
          $result = mNewExec($sql, $model =2 ,array($achete,$listproduit[$index]['ref_produit']),$login);
       }
        $sql = "DELETE FROM public.produit_est_dans_le_panier WHERE ref_produit = ? AND produit_est_dans_le_panier.login = ?";
        $result = mNewExec($sql , $model = 2 ,array($listproduit[$index]["ref_produit"],$login));
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
