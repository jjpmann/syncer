<?php
require 'vendor/autoload.php';

/*
 * Created by PhpStorm.
 * User: goce
 * Date: 9/24/15
 * Time: 20:30
 */

use Illuminate\Remote;

$conn = [
  'name' => 'lmodev',
  'host' => 'lmodev2.lmo.com',
  'username' => 'vimdev',
  'auth' => [
    'key' => '/Users/goce/.ssh/passless_key',
  ]
];

//$c = new Remote\SecLibGateway($conn['host'],$conn['auth'],new \Illuminate\Filesystem\Filesystem());
$connection = new Remote\Connection('remote', 'lmodev2.lmo.com', 'vimdev',
  ['key' => $conn['auth']['key']]);
$connection->run("ls -all", function ($line) {
  echo "printing line" . PHP_EOL;
});



