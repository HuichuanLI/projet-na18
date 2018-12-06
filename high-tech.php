<?php



require('./lib/init.php');
$sql = "SELECT ref_produit, nom_produit, description, etat_produit, marque, prix, nom_promo
FROM produit WHERE categorie_produit = 'high-tech'";

$result = mConn()->prepare($sql);
$result->execute();





while($row= $result->fetch(PDO::FETCH_ASSOC)){

  echo "Référence produit : " . $row['ref_produit'] . "<br>";
  echo "Nom du produit : " . $row['nom_produit'] . "<br>";
  echo "Description du produit : " . $row['description'] . "<br>";
  echo "État du produit : " . $row['etat_produit'] . "<br>";
  echo "Marque dump produit :" . $row['marque'] . "<br>";
  echo "Prix du produit : " . $row['prix'] . "<br>";
  if ($row['nom_promo'] != NULL){
    echo "Promotion associée " . $row['nom_promo'] . "<br>";
  }else{
    echo "Promotion associée : aucune promotion actuelle sur ce produit";
  }
    echo "<br><br>";
}



include(ROOT . '/view/front/high-tech.html');

?>
