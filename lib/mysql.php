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
    $connexion = new PDO('pgsql:host=db;port=5432;dbname=yyh', 'yyh', 'haha1sbccy');
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

//insert function 
function mExec($sql){
  $connexion = mConn();
  $resultset = $connexion->prepare($sql);
  if ($resultset->execute() == true) {
   return "true";
  }
  else {
    return "false";
  }
}

  

