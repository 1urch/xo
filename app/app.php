<?php

use Silex\Application;

use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;

use Dflydev\Provider\DoctrineOrm\DoctrineOrmServiceProvider;

use Lurch\XO\Common\DoctrineColumnHydrator;

$app = new Application();

$app->register(new DoctrineServiceProvider());
$app->register(new DoctrineOrmServiceProvider);
$app->register(new HttpFragmentServiceProvider());
$app->register(new ServiceControllerServiceProvider());

$app['orm.proxies_dir'] = __DIR__ . '/cache/doctrine';
$app['orm.em.options'] = [
  'mappings' => [
    [
      'type'      => 'annotation',
      'namespace' => 'Lurch',
      'path'      => __DIR__ . '/../src',
      'use_simple_annotation_reader' => false
    ],
  ],
];
$app['orm.custom.hydration_modes'] = [
  DoctrineColumnHydrator::class => DoctrineColumnHydrator::class
];

return $app;
