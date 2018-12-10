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


	session_start();
	if(isset($_POST['login'])){
		// submit to change the information of user 
		if(isset($_POST['nom'])){
			if($_POST['typeuser'] == "admin"){
				$admin = 'true';
			}else{
				$admin = 'false';
			}
			if($_POST['typeuser'] == "vendeur"){
				$vendeur = 'true';
			}

			$vSql = "UPDATE public.utilisateur SET  mdp='".$_POST['password1']."', nom='".$_POST['nom']."', prénom='".$_POST['prenom']."', est_admin='".$admin."' WHERE login = '".$_POST['login']."';";
			$row = mQuery($vSql);
			if($vendeur == 'true'){
				$updatesql = "UPDATE public.vendeur SET description='".$_POST['description']."', siret='".$_POST['siret']."', nom_magasin='".$_POST['magasin']."' WHERE login = '".$_POST['login']."';";
				$row = mQuery($updatesql);
			}	
		}

		if(isset($_POST['delete'])){

			if($_POST['login'] != $_SESSION['login']){

				$sql = "DELETE  FROM public.utilisateur_consulte_annonce WHERE ref_annonce IN ( select utilisateur_consulte_annonce.ref_annonce from utilisateur_consulte_annonce ,annonce where utilisateur_consulte_annonce.ref_annonce = annonce.ref_annonce  and  annonce.login_vendeur ='".$_POST['login']."') ;";	
				var_dump($sql);
				$row = mExec($sql);
					
				$sql = "DELETE FROM public.annonce WHERE annonce.login_vendeur ='".$_POST['login']."';";
				$row = mExec($sql);
				
				$sql = "DELETE FROM public.vendeur WHERE vendeur.login = '".$_POST['login']."';";
				$row = mExec($sql);
				$sql = "DELETE FROM public.utilisateur WHERE utilisateur.login = '".$_POST['login']."';";
				$row = mExec($sql);
				$sql = "DELETE FROM public.adresse WHERE login = '".$_POST['login']."';";
				$row = mExec($sql);
				$sql = "DELETE FROM public.utilisateur_consulte_annonce WHERE login = '".$_POST['login']."';";
				$row = mExec($sql);
				$sql = "DELETE FROM public.utilisateur_achete_produit WHERE login = '".$_POST['login']."';";
				$row = mExec($sql);	
				header('Location: listuser.php?result=avec success');				

			}else{

				header('Location: listuser.php?result=delete yourself');
			}
		}
		$vSql = "SELECT * FROM public.utilisateur left join  public.vendeur ON utilisateur.login = vendeur.login WHERE utilisateur.login = '".$_POST['login']."'";
		$row = mQuery($vSql);
		$value = $row[0];
		if(empty($value["description"])){
			if($value["est_admin"] == true){
				$value["typeuser"] = "admin";
			}else{
				$value["typeuser"] = "acheteur";
			}
		}else{
			$value["typeuser"] = "vendeur";
		}
	}







require(ROOT . '/view/admin/modifieruser.html');

?>
