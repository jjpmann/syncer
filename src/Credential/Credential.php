<?php
/**
 * Created by PhpStorm.
 * User: goce
 * Date: 9/29/15
 * Time: 11:19
 */

namespace Syncer\Credential;

use Syncer\Credential\CredentialInterface;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

/**
 * File: Credential.php
 * Author: goce
 * Created:  2015.09.29
 *
 * Description:
 */
class Credential implements CredentialInterface {

  /**
   * The name of the credential
   *
   * @var String
   */
  protected $name;

  /**
   * The remote host
   *
   * @var String
   */
  protected $host;

  /**
   * The SSH username
   *
   * @var String
   */
  protected $user;

  /**
   * THe credential secret (password, private file, etc...)
   *
   * @var String
   */
  protected $secret;



  public function __construct($name, $host, $username, $secret) {
    $this->name = $name;
    $this->host = $host;
    $this->user = $username;
    $this->secret = $secret;
  }

  /**
   * @return String
   */
  public function name() {
    return $this->name;
  }

  /**
   * @return String
   */
  public function host() {
    return $this->host;
  }

  /**
   * @return String
   */
  public function user() {
    return $this->user;
  }

  /**
   * @return String
   */
  public function secret() {
    return $this->secret;
  }
}