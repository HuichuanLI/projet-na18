<?php
class Connect {
	public $fHost = "db";
	public $fPort = "5432";
	public $fDbname = "yyh";
	public $fUser = "yyh";
	public $fPassword = "haha1sbccy";
	public $fConn;

	public function connection(){
		$this->fConn = new PDO('pgsql:host='.$this->fHost.';port='.$this->fPort , 'yyh', 'haha1sbccy');
		return $this->fConn;
	} 
	
	public function get($sql){
		$vResultSet = $this->fConn->prepare($sql);
		$vResultSet->execute();
		$vRow = $vResultSet->fetch(PDO::FETCH_ASSOC);
		return $vRow;	
	}

}
?>