<?php
    /***
     *index.php front-page
     *
     *@author huichuan.li
     *@link https://github.com/HuichuanLI
     *@since 2017.6
     *@copyright Gpl

     */
    require('./lib/init.php');
    session_start();
    if(empty($_SESSION['login'])){
        header('Location: log.php');
    }


    $sql = "SELECT * FROM public.produit_commande, public.commande, public.annonce WHERE commande.num_commande = produit_commande.num_commande and annonce.ref_produit = produit_commande.ref_produit and annonce.login_vendeur = '".$_SESSION['login'] ."';";

    $row = mQuery($sql);

    if(isset($_POST['num_commande'])){
      $livresql = "UPDATE public.commande SET statut_commande='expédiée' WHERE num_commande=".$_POST['num_commande'].";";
      $result = mExec($livresql);
       header('Location: gestionlivre.php');
    }

    if($_SESSION['admin'] == false){
        $admin = "false";
    }else{
        $admin = "true";
    }


    $sql = "SELECT * FROM public.vendeur WHERE login = '".$_SESSION['login']."';";
    $vendeur = mQuery($sql);
    if($vendeur == NULL){
        $vendeur = "false";
    }else{
        $vendeur = "true";
    }
    $_SESSION['vendeur'] = $vendeur;
    include(ROOT.'/view/admin/commanderecu.html');
