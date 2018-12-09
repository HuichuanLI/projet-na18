<?php



require('./lib/init.php');


$sql = "SELECT * FROM produit";
$result = mConn()->prepare($sql);
$result->execute();
$row = mQuery($sql);

require('./view/front/index.html');

?>
