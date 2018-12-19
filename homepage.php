<?php

    require('./lib/init.php');
    session_start();
    if(empty($_SESSION['login'])){
        header('Location: log.php');
    }


    $sql = "SELECT * FROM UTILISATEUR_ACHETE_PRODUIT, PRODUIT WHERE PRODUIT.ref_produit = UTILISATEUR_ACHETE_PRODUIT.ref_produit AND UTILISATEUR_ACHETE_PRODUIT.login =?;";
    $row = mNewQuery($sql,$model=2,array($_SESSION['login']));


    if($_SESSION['admin'] == false){
        $admin = "false";
    }else{
        $admin = "true";
    }


    $sql = "SELECT * FROM public.vendeur WHERE login = ?;";
    $vendeur = mNewQuery($sql,$model=2,array($_SESSION['login']));
    if($vendeur == NULL){
        $vendeur = "false";
    }else{
        $vendeur = "true";
    }
    $_SESSION['vendeur'] = $vendeur;
    include(ROOT.'/view/admin/homepage.html');
