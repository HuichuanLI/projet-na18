<?php
/***
*index.php front-page
*
*@author huichuan.li
*@link https://github.com/HuichuanLI
*@since 2018.6
*@copyright Gpl
*/

require('./lib/init.php');
date_default_timezone_set("Europe/Paris");

if(empty($_POST)) {
	require(ROOT . '/view/admin/addpromotion.html');
}else{
	if(empty($_POST['promotion']) || empty($_POST['debut']) || empty($_POST['fin']) || empty($_POST['rabais']) ){
		  header('Location: sign.php?addpromotion=empty');
	}else{
		$sql ="INSERT INTO public.promotion(nom_promo, debut, fin, rabais) VALUES (?, ?, ?, ?);";
		
		$result = mNewExec($sql,$model=2,array($_POST['promotion'],$_POST['debut'],$_POST['fin'],$_POST['rabais']));
		

		if($result == "true"){
			header('Location: listpromotion.php?result=avec success');
		}else{
			header('Location: addpromotion.php?result=error');
		}
	}
} 

?>
