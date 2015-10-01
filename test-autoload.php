<?php
require 'vendor/autoload.php';

/*
 * Created by PhpStorm.
 * User: goce
 * Date: 9/24/15
 * Time: 20:30
 */

use Illuminate\Remote;
use Syncer\SSH;
use Syncer\Credential\SshPubkeyAuthCredential;

$conn = [
  'name' => 'lmodev',
  'host' => 'lmodev2.lmo.com',
  'username' => 'vimdev',
  'auth' => [
    'key' => '/Users/goce/.ssh/passless_key',
  ]
];

/*
$connection = new Remote\Connection('remote', 'lmodev2.lmo.com', 'vimdev',
  ['key' => $conn['auth']['key']]);
$connection->run("ls -all", function ($line) {
  echo "printing line" . PHP_EOL;
});*/


/* Make a remote SSH Connection
$cred = new SshPubkeyAuthCredential($conn['name'],$conn['host'],$conn['username'],$conn['auth']['key']);

$ssh = new SSH('default',$cred);

$ssh->run('ls -all',function($line){
  echo "printing line" . PHP_EOL;
  echo $line;
});
/**/

