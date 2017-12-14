<?php
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;
use Saxulum\SaxulumWebProfiler\Provider\SaxulumWebProfilerProvider;
use Symfony\Component\Debug\Debug;

require __DIR__ . '/prod.php';

$app['debug'] = true;

$app->register(
  new MonologServiceProvider(),
  [
    'monolog.logfile' => __DIR__ . '/../logs/app_dev.log',
  ]
);

//$app->register(
//  new WebProfilerServiceProvider(),
//  [
//    'profiler.cache_dir' => __DIR__ . '/../cache/profiler'
//  ]
//);
//
//$app->register(new SaxulumWebProfilerProvider());

//Debug::enable();
