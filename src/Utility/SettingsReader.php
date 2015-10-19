<?php
/**
 * Created by PhpStorm.
 * User: goce
 * Date: 10/19/15
 * Time: 14:05
 */

namespace Syncer\Utility;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Yaml\Parser;
use Illuminate\Filesystem\Filesystem;

/**
 * File: SettingsReader.php
 * Author: goce
 * Created:  2015.10.19
 *
 * Description:
 */
class SettingsReader {

  public static function readYaml($file)
  {

    $filesystem = new Filesystem();

    if(!$filesystem->isFile($file)){
      throw new FileNotFoundException(sprintf("Yikes!!! Couldn't find the file %s ", $file));
    }

    $parser = new Parser();


    $yaml = $parser->parse(file_get_contents($file));

    return $yaml;
  }
}