<?php
/**
 * Created by PhpStorm.
 * User: goce
 * Date: 10/19/15
 * Time: 13:55
 */

namespace Syncer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Yaml;
use Syncer\Utility\SettingsReader;
use Symfony\Component\Yaml\Dumper;

/**
 * File: SettingsDiscoverCommand.php
 * Author: goce
 * Created:  2015.10.19
 *
 * Description:
 */
class SettingsDiscoverCommand extends Command {

  protected function configure() {
    $this
      ->setName("settings:list")
      ->setDescription("Lists the available settings it can find. It could be from a yaml file or CMS specific.")
      ->addOption("help",'h',InputOption::VALUE_NONE,"Provide help")
      //->addArgument('env', InputArgument::OPTIONAL, "The environment settings to list")
      //->addOption('env', 'e', InputOption::VALUE_NONE, "List only the available environments");
    ;
  }

  /**
   * @param \Symfony\Component\Console\Input\InputInterface   $input
   * @param \Symfony\Component\Console\Output\OutputInterface $output
   *
   * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
   */
  protected function execute(InputInterface $input, OutputInterface $output) {
    $settings = SettingsReader::readYaml('.syncer.settings.yml');

    $printable = Yaml::dump($settings, 4, 6);
    $output->write($printable);

    /*
    if ($input->getOption('env')) {
      foreach ($settings as $name => $setting) {
        $output->writeln(sprintf("<info>%s</info>", $name));
      }
    }*/

  }

}