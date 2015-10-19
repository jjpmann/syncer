<?php namespace Syncer\Command;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Remote\Connection;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


/**
 * File: RemoteImporterCommand.php
 * Author: goce
 * Created:  2015.10.08
 *
 * Description:
 */
class RemoteImporterCommand extends Command {

  protected function configure() {
    $this
      ->setName("remote:import")
      ->setDescription("Imports a sql file into a remote database via a ssh connection.")
      //->addOption("--help",'-h',InputOption::VALUE_NONE,"remote:import /tmp/sql-file.sql test.com sshuser /user/.ssh/rsa_pub dbhost dbpassword dbuser dpassword")
      ->addArgument('ssh-host', InputArgument::REQUIRED,
        "The remote server. If you need to specify a port use a colon, i.e host:port")
      ->addArgument('ssh-user', InputArgument::REQUIRED, "The ssh user")
      ->addArgument('ssh-secret', InputArgument::REQUIRED, "The ssh user password or key file location")
      ->addArgument('db-server', InputArgument::REQUIRED, "The database server")
      ->addArgument('db-user', InputArgument::REQUIRED, "The database user")
      ->addArgument('db-password', InputArgument::REQUIRED, "The database user password")
      ->addArgument('db-name', InputArgument::REQUIRED, "The database name")
      ->addArgument('sql-file', InputArgument::REQUIRED, "The sql file to import to the remote server");
  }

  protected function execute(InputInterface $input, OutputInterface $output) {

    $file = $input->getArgument('sql-file');

    $filesystem = new Filesystem();

    if (!$filesystem->isFile($file)) {
      throw new FileNotFoundException("We could not find the file you wanted to send to the remote server");
    }

    $vars = $input->getArguments();

    $keyLocation = $vars['ssh-secret'];


    if(!$filesystem->isFile($keyLocation)){
      $output->writeln(sprintf('<error>Oh NO! We couldn\'t find the private key located here: %s</error>',$keyLocation));

      $pattern = '/^~\//i';
      if(preg_match($pattern,$keyLocation) === 1){
        $output->writeln('<error>Maybe use the absolute path?</error>');
      }

      $output->writeln('<error>We are going to bail and let you fix this. </error>');
      return;
    }

    $auth = [
      'key' => $vars['ssh-secret'],
    ];

    $output->writeln("Connecting to remote host");

    $remote = new Connection('remote', $vars['ssh-host'], $vars['ssh-user'], $auth);

    if ($remote->getGateway()) {
      $output->writeln("Connection established. Transferring file " . $file);
    }

    $fileName = $filesystem->name($file);

    $remoteFile = $fileName;
    $remote->put($file, $remoteFile);

    $output->writeln("File transfered. Importing into database");

    $mysqlCommandFormat = "mysql -u %s -p'%s' %s < %s";
    $mysqlImportCommand = sprintf($mysqlCommandFormat, $vars['db-user'], $vars['db-password'], $vars['db-name'],
      $remoteFile);

    $mysqlDropDbCommand = sprintf("mysql -u %s -p'%s' -e 'DROP DATABASE %s;'", $vars['db-user'], $vars['db-password'],
      $vars['db-name']);
    $mysqlCreateDbCommand = sprintf("mysql -u %s -p'%s' -e 'CREATE DATABASE %s;'", $vars['db-user'],
      $vars['db-password'], $vars['db-name']);


    $remote->run($mysqlDropDbCommand, function ($line) use ($output) {
    });

    $remote->run($mysqlCreateDbCommand, function ($line) use ($output) {
    });

    $remote->run($mysqlImportCommand, function ($line) use ($output) {
      $output->writeln($line);
    });

    /*
     * Cleanup the remote machine
     */
    $remote->run('rm ' . $remoteFile, function ($line) {
    });

    $output->writeln("Remote Importer is ALL DONE !!!");
  }
}