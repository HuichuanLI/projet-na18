<?php 
	class Homepage{
		public function index($param){
			session_start();
			$_SESSION['login'] = true;
			// $string = file_get_contents("./html/login.html");
			// echo $string;
			echo "Homepage";
		}

	
	}
?>