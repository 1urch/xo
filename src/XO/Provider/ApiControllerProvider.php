<?php

namespace Lurch\XO\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;

class ApiControllerProvider implements ControllerProviderInterface
{

  public function connect(Application $app)
  {
    $app->error(function (\Exception $e) use ($app) {
      return $app->json(['error' => $e->getMessage()]);
    });

    $controllers = $app['controllers_factory'];
    $controllers->post('/game/create', 'game.controller:create');

    return $controllers;
  }

}