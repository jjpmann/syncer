<?php

require_once 'vendor/autoload.php';

use Syncer\Command\FileDumperCommand;
use Symfony\Component\Console\Application;

$app = new Application();
$app->add(new FileDumperCommand());
$app->add(new \Syncer\Command\RemoteImporterCommand());
$app->add(new \Syncer\Command\SyncCommand());
$app->add(new \Syncer\Command\SettingsDiscoverCommand());
$app->add(new \Syncer\Command\SettingsGenerateCommand());
$app->run();