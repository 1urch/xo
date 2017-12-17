<?php

namespace Lurch\XO\Provider;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class ApiControllerProvider implements ControllerProviderInterface
{

  public function connect(Application $app)
  {
    /** @var ControllerCollection $controllers */
    $controllers = $app['controllers_factory'];
    $controllers->post('/game/create', 'game.controller:create');
    $controllers->post('/game/{id}/join', 'game.controller:join');
    $controllers->post('/game/{id}/turn', 'game.controller:turn');

    $controllers->get('/game', function (Request $request) use ($app) {
      $response = $app['game.controller']->list($request, $app['query.game.list']);
      return $response;
    });

    $controllers->get('/game/{id}', function (Request $request, string $id) use ($app) {
      $response = $app['game.controller']->state($request, $app['query.game.state'], $id);
      return $response;
    });

    // Exception handler prototype
    $app->error(function (\Exception $e) use ($app) {

      if ($e instanceof \DomainException) {
        return $app['responseFactory']->error($e->getMessage());
      }

      return $app['responseFactory']->error('Internal error');
    });

    // Auth prototype
    $app->before(function (Request $request, Application $app) {
      if('POST' === $request->getMethod()) {

        if (!$request->request->has('token'))
          throw new \InvalidArgumentException('Missing token');

        $tokens = [
          '2ed58ec5-bd77-4482-a868-ffd4128a4123',
          '81b18488-b023-4cb0-99e7-b247a4992290'
        ];

        if (!in_array($request->request->get('token'), $tokens))
          throw new \InvalidArgumentException('Invalid token');

      }
    });

    return $controllers;
  }

}