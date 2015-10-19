<?php namespace Syncer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\ArrayInput;
use Syncer\DatabaseOperations;
use Symfony\Component\Process\Process;


/**
 * File: FileDumperCommand.php
 * Author: goce
 * Created:  2015.10.07
 *
 * Description:
 */
class FileDumperCommand extends Command {

  protected function configure() {
    $this
      ->setName('dump:local')
      ->setDescription('Dump a local database file')
      ->addArgument('db-username', InputArgument::REQUIRED, "The database user")
      ->addArgument('db-password', InputArgument::REQUIRED, "The database password")
      ->addArgument('db-name', InputArgument::REQUIRED, "The database name")
      ->addArgument('filename', InputArgument::REQUIRED, "The sql file");
  }

  protected function execute(InputInterface $input, OutputInterface $output) {
    $user = $input->getArgument('db-username');
    $pass = $input->getArgument('db-password');
    $dbName = $input->getArgument('db-name');
    $filename = $input->getArgument('filename');

    $format = "mysqldump -u %s -p%s %s > %s";

    //$filename = '/tmp/' . DatabaseOperations::generateFilename($dbName);

    $command = sprintf($format, $user, $pass, $dbName, $filename);

    $proc = new Process($command);

    $output->writeln(sprintf("Dumping local database %s to %s", $dbName, $filename));

    $proc->run();

    if (!$proc->isSuccessful()) {
      $output->writeln("Oooops ... there was an error you should fix otherwise we can't dump the database to a file. Here's the error:");
      $output->writeln($proc->getErrorOutput());
      return;
    }

    $output->writeln($proc->getOutput());
    $output->writeln(sprintf("Dumper is ALL DONE!!! Database %s dumped at %s",$dbName,$filename));
  }
}