<?php
/**
 * Created by PhpStorm.
 * User: goce
 * Date: 10/19/15
 * Time: 16:47
 */

namespace Syncer\Command;


use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Output\Output;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Yaml\Dumper;


/**
 * File: SettingsGenerateCommand.php
 * Author: goce
 * Created:  2015.10.19
 *
 * Description:
 */
class SettingsGenerateCommand extends Command {

  const SETTINGS_FILE = '.syncer.settings.yml';

  protected function configure() {
    $this
      ->setName("settings:generate")
      ->setDescription("Generates a .syncer.settings.yml file with sample settings");
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $filesystem = new Filesystem();

    if ($filesystem->isFile(self::SETTINGS_FILE)) {
      $helper = $this->getHelper('question');
      $output->writeln(sprintf('<question>The settings file \'%s\' already exists. If you continue you will overwrite the file and loose any existing settings. Are you sure?</question>',self::SETTINGS_FILE));
      $question = new ConfirmationQuestion('(y/n)? ',FALSE);

      if(!$helper->ask($input,$output,$question)){
       $output->writeln("<comment>Settings file was not generated. Come back soon! </comment>");
      }
    }

    $settings = [
      'local' => [
        'database'  => [
          'username'  => 'my-local-db-user',
          'password'  => 'my-super-secret-password',
          'database'  => 'database-name'
        ]
      ],
      'remote'  => [
        'ssh' => [
          'host' => 'servername:portname',
          'username'  => 'ssh-user',
          'private-key' => 'absolute-key-loacation',
        ],
        'database'  => [
          'username'  => 'my-remote-db-user',
          'password'  => 'my-super-secret-password',
          'database'  => 'remote-database-name'
        ]
      ]
    ];

    $dumper = new Dumper();

    $contents = $dumper->dump($settings,6);
    file_put_contents(self::SETTINGS_FILE,$contents);

    $output->writeln('<info>New settings file written</info>');
  }
}