<?php namespace Syncer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;

class SyncCommand extends Command {

  protected function configure()
  {
    $this
      ->setName('push')
      ->setDescription("Syncs a database. NOTE: the destination database will be dropped before the sync happens")
      ->addOption('from',null,InputOption::VALUE_REQUIRED, "The source credentials")
      ->addOption('to',null,InputOption::VALUE_REQUIRED, "The destination credentials")
      ;
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $yaml = new Parser();
    $dumper = new Dumper();

    $settings = $yaml->parse(file_get_contents('.syncer.settings.yml'));


    $output->write($dumper->dump($settings,4,4));
    //$output->writeln($settings);
  }
}

