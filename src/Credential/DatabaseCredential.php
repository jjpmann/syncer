<?php namespace Syncer\Credential;


use Illuminate\Filesystem\Filesystem;

class DatabaseCredential extends Credential {

  protected $port;

  public function __construct($dbName, $username, $password, $host = "localhost", $port = 3306) {

    $this->port = $port;
    parent::__construct($dbName, $username,$host, $password);
  }

  public function dbName()
  {
    return $this->name;
  }

  public function port(){
    return $this->port;
  }

}