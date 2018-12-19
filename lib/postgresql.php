<?php

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



// sql new version 
// add bindParam dans une array 
function mNewQuery($sql,$model= 1,$array=array()){
  
  $connexion = mConn();
  $resultset = $connexion->prepare($sql);
  
  if($model == 1){
    foreach ($array as $key => $value) {
      $resultset->bindParam($key,$value);
    }
    $resultset->execute();
    
  }else{
    $resultset->execute($array);
  }

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


function mNewExec($sql,$model=1, $array = array()){
  $connexion = mConn();
  $resultset = $connexion->prepare($sql);

  if($model == 1){
    foreach ($array as $key => $value) {
      $resultset->bindParam($key,$value);
    }  
    if ($resultset->execute() == true) {
     return "true";
    }
    else {
      return "false";
    }

  }else{
    if ($resultset->execute($array) == true) {
     return "true";
    }
    else {
      return "false";
    }
  }
  
}

