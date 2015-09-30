<?php
/**
 * Created by PhpStorm.
 * User: goce
 * Date: 9/29/15
 * Time: 17:03
 */

namespace Syncer\Credential;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\FileNotFoundException;


/**
 * File: PubkeyAuthCredential.php
 * Author: goce
 * Created:  2015.09.29
 *
 * Description:
 */
class SshPubkeyAuthCredential extends Credential{

  /**
   * The identity file location used during the public key authentication process
   *
   * @var String
   */
  protected $keyLocation;

  /**
   * SSH Connection port number. Defaults to 22.
   *
   * @var Integer
   */
  protected $port;

  public function __construct($name,$host,$username,$keyLocation,$port=22){
    $file = new Filesystem();

    if(!$file->isFile($keyLocation)){
      throw new FileNotFoundException("Private key file doesn't exist at " . $keyLocation);
    }

    $this->keyLocation = $keyLocation;
    $this->port = $port;

    parent::__construct($name,$host,$username,$keyLocation);
  }

  /**
   * Override parent secret() function.
   *
   * @return String
   */
  public function secret(){
    return $this->keyLocation;
  }

}