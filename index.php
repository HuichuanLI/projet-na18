<?php



require('./lib/init.php');


$sql = "SELECT * FROM produit";
$result = mConn()->prepare($sql);
$result->execute();

while($row= $result->fetch(PDO::FETCH_ASSOC)){

  echo "Référence produit : " . $row['ref_produit'] . "<br>";
  echo "Nom du produit : " . $row['nom_produit'] . "<br>";
  echo "Description du produit : " . $row['description'] . "<br>";
  echo "État du produit : " . $row['etat_produit'] . "<br>";
  echo "Marque du produit : " . $row['marque'] . "<br>";
  echo "Prix du produit : " . $row['prix'] . "<br>";
  if ($row['nom_promo'] != NULL){
    echo "Promotion associée " . $row['nom_promo'] . "<br>";
  }else{
    echo "Promotion associée : aucune promotion actuelle sur ce produit";
  }
    echo "<br><br>";
}
require('./view/front/index.html');

?>
