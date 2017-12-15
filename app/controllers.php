<?php

use Lurch\XO\Controller\GameController;
use Lurch\XO\Provider\ApiControllerProvider;

$app['game.controller'] = function ($app) {
  $controller = new GameController($app['commandBus'], $app['mapper'], $app['uuid'], $app['responseFactory']);
  return $controller;
};

$app->mount('/api', new ApiControllerProvider());
