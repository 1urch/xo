<?php

use Symfony\Component\HttpFoundation\Request;

use Lurch\XO\Controller\GameController;

$app['game.controller'] = function ($app) {
  /** @var Request $request */
  $request = $app['request_stack']->getCurrentRequest();

  return new GameController($request, $app['commandBus'], $app['mapper'], $app['uuid']);
};
