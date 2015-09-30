<?php
/**
 * Created by PhpStorm.
 * User: goce
 * Date: 9/29/15
 * Time: 11:43
 */

namespace Syncer\Credential;

interface CredentialInterface {


  /**
   * Return the credential name
   *
   * @return String
   */
  public function name();

  /**
   * Return the name of the host
   *
   * return String
   **/
   public function host();

   /**
    * Return the username
    *
    *
    * return String
    **/
    public function user();

    /**
     * Returns the secret. If a password, then then password. If we're using a
     * public key authentication then it returns the public key location
     *
     * return String
     **/
     public function secret();


 
}