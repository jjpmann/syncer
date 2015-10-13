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

$dbCred = [
  'db-name'  => 'ncarb_demo',
  'host'  => 'localhost',
  'username'  => "root",
  'password'  => 'root',
];

/*
$connection = new Remote\Connection('remote', 'lmodev2.lmo.com', 'vimdev',
  ['key' => $conn['auth']['key']]);
$connection->run("ls -all", function ($line) {
  echo "printing line" . PHP_EOL;
});*/

/* Dump a DB Connection */
$db = new \Syncer\Credential\DatabaseCredential($dbCred['db-name'],$dbCred['username'],$dbCred['password']);

//$adapter = new \League\Flysystem\Adapter\Local('/tmp');
$temp = new \Illuminate\Filesystem\Filesystem();

$dbDumpName = "db.dump.".$db->name() . "__" . time();
$localPath = '/tmp/' . $dbDumpName;

$temp->put($localPath,"test");

($temp->exists($localPath)) ? print "Hell YES" : print "NOOOOooooooo!";

//$adapter->write($dbDumpName,"test");





/* Make a remote SSH Connection
$cred = new SshPubkeyAuthCredential($conn['name'],$conn['host'],$conn['username'],$conn['auth']['key']);

$ssh = new SSH('default',$cred);

$ssh->run('ls -all',function($line){
  echo "printing line" . PHP_EOL;
  echo $line;
});
/**/

