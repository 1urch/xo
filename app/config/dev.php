<?php
use Silex\Provider\MonologServiceProvider;

require __DIR__ . '/prod.php';

$app['debug'] = true;

$app->register(
  new MonologServiceProvider(),
  [
    'monolog.logfile' => __DIR__ . '/../logs/app_dev.log',
  ]
);
