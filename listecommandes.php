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


    $sql = "SELECT * FROM public.commande WHERE commande.login = ?;";
    $row = mNewQuery($sql,$model = 2, array($_SESSION['login']));


    if($_SESSION['admin'] == false){
        $admin = "false";
    }else{
        $admin = "true";
    }


    $sql = "SELECT * FROM public.vendeur WHERE login =?;";
    $vendeur = mNewQuery($sql,$model = 2, array($_SESSION['login']));
    if($vendeur == NULL){
        $vendeur = "false";
    }else{
        $vendeur = "true";
    }
    $_SESSION['vendeur'] = $vendeur;
    include(ROOT.'/view/admin/listecommandes.html');
