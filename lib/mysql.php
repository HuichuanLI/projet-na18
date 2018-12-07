<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2017.6
*@copyright Gpl
*/
//connect to the sql
error_reporting(E_ALL ^ E_DEPRECATED);

function mConn() {
  static $connexion = null;
  if($connexion === null) {
    $connexion = new PDO('pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a027', 'na18a027', 'FCCSel7x');
  }

  return $connexion;
}


//select function
function mQuery($sql){
  $connexion = mConn();
  $resultset = $connexion->prepare($sql);
  $resultset->execute();
  $index = 0;

  while ($row = $resultset->fetch(PDO::FETCH_ASSOC)) {
    $result[$index] = $row;
    $index++;
  }
  if(isset($result)){
    return $result;  
  }else{
    return null;
  }
  
}
