<?php



require('./lib/init.php');


$sql = "SELECT * FROM produit";
$row = mQuery($sql);

require('./view/front/index.html');

?>
