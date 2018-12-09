<?php



require('./lib/init.php');
session_start();

$sql = "SELECT * FROM produit, annonce
WHERE produit.ref_produit = annonce.ref_produit
AND categorie_produit='loisir'";
$row = mQuery($sql);



include(ROOT . '/view/front/loisir.html');

?>
