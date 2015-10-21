<?php namespace Syncer\Utility;

use PHPUnit_Framework_TestCase;
use Syncer\Utility\SettingsReader;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class SettingsReaderTest extends PHPUnit_Framework_TestCase {

  /**
   * @expectedException Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  public function testReadYamlThrowsFileNotFoundException() {
    $settingsFile = ".this.file.doesn\'t.exist";

    $settings = SettingsReader::readYaml($settingsFile);
  }

  public function testReadYamlReturnsAnArray() {
    $settingsFile = '.syncer.settings.yml';

    $settings = SettingsReader::readYaml($settingsFile);

    $this->assertTrue(is_array($settings),"The SettingsReader::readYaml function correctly returns an array");
  }
}