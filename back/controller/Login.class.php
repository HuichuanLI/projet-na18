<?php 
	
	class Login{
		public function index($param){
			session_start();
			if(isset($_SESSION["login"])){
				header("location: ../homepage/index");
			}
			$string = file_get_contents("./html/login.html");
			echo $string;
		}

		public function post($param){
			error_reporting(1);
			include "config/connect_class.php";
			$login = $_POST["login"];
			$password = $_POST["password"];
			$vConnect = new Connect();
			$vConn = $vConnect->connection();
			$vSql = "SELECT login, mdp FROM public.utilisateur WHERE mail = '".$login."' and mdp = '".$password."';" ;
			$vRow = $vConnect->get($vSql);
			if($vRow != null){
				// echo "hello world";
				#	start session 
				
				$url = "../homepage/index";
				echo "<script type='text/javascript'>";
				echo "window.location.href='$url'";
				echo "</script>"; 
				 
			}else{
				$string = file_get_contents("./html/login.html");
				echo $string;
			}
		}

	
	}
?>