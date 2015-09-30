<?php
namespace Syncer;

/**
 * Stores the connection credentials and connection information
 */

use Illuminate\Remote\Connection;
use Syncer\Credential\Credential;



class SSH extends Connection{

  //has credentials and provides a wrapper for the connection



  /**
   * Remote Host Credentials
   *
   * @param Credential $remoteHost
   */
  protected $remote;



  public function __construct($name,Credential $remote){

    parent::__construct($name,$remote->host(),$remote->user(),['key' => $remote->secret()]);

    $this->remote = $remote;

  }


}
