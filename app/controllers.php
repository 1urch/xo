<?php

use Lurch\XO\Controller\GameController;
use Lurch\XO\Provider\ApiControllerProvider;

use Lurch\XO\Command\CreateGameCommand;


$app['game.controller'] = function ($app) {
  $controller = new GameController($app['commandBus'], $app['mapper'], $app['uuid']);
  $controller->setUpCommands(new CreateGameCommand());
  return $controller;
};

$app->mount('/api', new ApiControllerProvider());
