<?php 
	require("connect_class.php");
	
	class Login{
		public function index($param){
			$string = file_get_contents("./html/login.html");
			echo $string;
		}

		public function post($param){
			$login = $_POST["login"];
			$password = $_POST["password"];
			$vConnect = new Connect();
			$vConn = $vConnect->connection();
			$vSql = "SELECT mail, mdp FROM public.utilisateur WHERE mail = '".$login."' and mdp = '".$password."';" ;
			$vRow = $vConnect->get($vSql);
			if($vRow != null){
				echo "hello world";	
			}else{
				$string = file_get_contents("./html/login.html");
				echo $string;
			}
		}

	
	}
?>