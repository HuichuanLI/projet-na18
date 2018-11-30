<?php
class Connect {
  public $fHost;
  public $fPort;
  public $fDbname;
  public $fUser;
  public $fPassword;
  public $fConn;

public function __construct () {
    $this->fHost = "localhost";
    $this->fPort="32341";
    $this->fUser="yyh";
    $this->fPassword = "haha1sbccy";
  }

  public function mConnect () {
    $this->fConn = pg_connect("host=$this->fHost port=$this->fPort  user=$this->fUser password=$this->fPassword") or die('Échec de la connexion : ' . pg_last_error());
  }

  function mClose () {
    pg_close($this->fConn);
  }
}
?>