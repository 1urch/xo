<?php

use Lurch\XO\Controller\GameController;
use Lurch\XO\Provider\ApiControllerProvider;

use Lurch\XO\Command\CreateGameCommand;
use Lurch\XO\Command\JoinGameCommand;
use Lurch\XO\Command\MakeTurnCommand;


$app['game.controller'] = function ($app) {
  $controller = new GameController($app['commandBus'], $app['mapper'], $app['uuid'], $app['responseFactory']);
  $controller->setUpCommands(new CreateGameCommand(), new JoinGameCommand(), new MakeTurnCommand());

  return $controller;
};

$app->mount('/api', new ApiControllerProvider());
