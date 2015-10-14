<?php namespace Syncer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;
use Syncer\DatabaseOperations;

class SyncCommand extends Command {

  protected function configure() {
    $this
      ->setName('push')
      ->setDescription("Syncs a database. NOTE: the destination database will be dropped before the sync happens")
      ->addOption('from', NULL, InputOption::VALUE_REQUIRED, "The source credentials")
      ->addOption('to', NULL, InputOption::VALUE_REQUIRED, "The destination credentials");
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $yaml = new Parser();
    $dumper = new Dumper();

    $settings = $yaml->parse(file_get_contents('.syncer.settings.yml'));

    $from = $input->getOption('from');
    $to = $input->getOption('to');


    $localDbUsername = $settings[$from]['database']['username'];
    $localDbPassword = $settings[$from]['database']['password'];
    $localDbDatabase = $settings[$from]['database']['database'];

    $remoteSshHost = $settings[$to]['ssh']['host'];
    $remoteSshUsername = $settings[$to]['ssh']['username'];
    $remoteSshPassword = $settings[$to]['ssh']['private-key'];


    $remoteDbHost = $settings[$to]['database']['host'];
    $remoteDbUsername = $settings[$to]['database']['username'];
    $remoteDbPassword = $settings[$to]['database']['password'];
    $remoteDbDatabase = $settings[$to]['database']['database'];

    //$output->writeln([$localDbUsername,$localDbPassword,$localDbDatabase]);
    //$output->writeln([$remoteSshHost,$remoteSshUsername,$remoteSshPassword]);
    //$output->writeln([$remoteDbHost,$remoteDbUsername,$remoteDbPassword,$remoteDbDatabase]);


    $filename = '/tmp/' . DatabaseOperations::generateFilename($localDbDatabase);
    $dumperCommand = $this->getApplication()->find('dump:local');
    $dumperArguments = [
      'command' => 'dump:local',
      'db-username' => $localDbUsername,
      'db-password' => $localDbPassword,
      'db-name' => $localDbDatabase,
      'filename'  => $filename,
    ];
    $dumperInput = new ArrayInput($dumperArguments);
    $dumperReturnCode = $dumperCommand->run($dumperInput,$output);
    $output->write($dumperReturnCode);
    //$output->write($dumper->dump($settings,4,4));
    //$output->writeln($settings);
  }
}

