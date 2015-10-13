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

    $auth = [
      'key' => $vars['ssh-secret'],
    ];

    $output->writeln("Connecting to remote host");

    $remote = new Connection('remote', $vars['ssh-host'], $vars['ssh-user'], $auth);

    if ($remote->getGateway()) {
      $output->writeln("Connection established. Transferring file " . $file);
    }

    $fileName = $filesystem->name($file);

    $remoteFile = '/tmp/' . $fileName;
    $remote->put($file, $remoteFile);

    $output->writeln("Remote Importer is ALL DONE !!!");

    //$mysqlCommandFormat = "mysql -u %s -p'%s' %s < %s";
    //$mysqlImportCommand = sprintf($mysqlCommandFormat,$vars['db-user'],$vars['db-password'],$vars['db-name'],$remoteDirectory . '/'. $file);
    //$remote->run()
    //mysql -u username -p'password' dbname < sqlfile

  }
}