<?php namespace Syncer\Credential;


use Illuminate\Filesystem\Filesystem;

class DatabaseCredential extends Credential {

  protected $port;

  public function __construct(
    $dbName,
    $username,
    $password,
    $host = "localhost",
    $port = 3306
  ) {

    $this->port = $port;
    parent::__construct($dbName,$host,$username,$password);
  }


}