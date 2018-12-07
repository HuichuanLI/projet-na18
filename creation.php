<?php



require('./lib/init.php');
$sql = "SELECT ref_produit, nom_produit, description, etat_produit, marque, prix, nom_promo
FROM produit WHERE categorie_produit = 'création'";
$row = mQuery($sql);

include(ROOT . '/view/front/creation.html');

?>
