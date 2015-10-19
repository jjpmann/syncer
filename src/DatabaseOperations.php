<?php namespace Syncer;

use Syncer\Credential\DatabaseCredential;
use Illuminate\Filesystem\Filesystem;

class DatabaseOperations {

  public static function dumpLocal(Credential\DatabaseCredential $cred, Filesystem $file) {
    $format = "mysqldump -u %s -p%s %s > %s";

    $command = sprintf($format, $cred->user(), $cred->secret(), $cred->dbName(),self::filename());
  }

  public static function generateFilename($dbName = "") {

    $format = '%s_db_dump_%s.sql';

    return sprintf($format,$dbName,time());
  }
}