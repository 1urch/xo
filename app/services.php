<?php

use SimpleBus\Message\Bus\Middleware\{MessageBusSupportingMiddleware, FinishesHandlingMessageBeforeHandlingNext};
use SimpleBus\Message\CallableResolver\{CallableMap, ServiceLocatorAwareCallableResolver};
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Ramsey\Uuid\UuidFactory;

use Lurch\XO\Middleware\MessageBusValidationMiddleware;
use Lurch\XO\Common\{JsonMapperFacade, ApiResponseFactory};

use Lurch\XO\Entity\{Game, Player};
use Lurch\XO\Query\{AvailableGamesQuery, GameStateQuery};
use Lurch\XO\Command\{CreateGameCommand, JoinGameCommand, MakeTurnCommand};
use Lurch\XO\Command\{CreateGameCommandHandler, JoinGameCommandHandler, MakeTurnCommandHandler};

$app['repository.game'] = function ($app) {
  return $app['orm.em']->getRepository(Game::class);
};

$app['repository.player'] = function ($app) {
  return $app['orm.em']->getRepository(Player::class);
};

$app['command.game.create'] = function ($app) {
  return new CreateGameCommandHandler($app['orm.em'], $app['repository.player'], $app['uuid']);
};

$app['command.game.join'] = function ($app) {
  return new JoinGameCommandHandler($app['orm.em'], $app['repository.game'], $app['repository.player']);
};

$app['command.game.turn'] = function ($app) {
  return new MakeTurnCommandHandler($app['orm.em'], $app['repository.game'], $app['repository.player']);
};

$app['query.game.list'] = function ($app) {
  return new AvailableGamesQuery($app['orm.em']);
};

$app['query.game.state'] = function ($app) {
  return new GameStateQuery($app['orm.em']);
};


/** commandBus */
$app['commandBus'] = function ($app) {
  /** @var MessageBusSupportingMiddleware $commandBus */
  $commandBus = new MessageBusSupportingMiddleware();

  $map = [
    CreateGameCommand::class => 'command.game.create',
    JoinGameCommand::class => 'command.game.join',
    MakeTurnCommand::class => 'command.game.turn',
  ];

  $resolver = new ServiceLocatorAwareCallableResolver(
    function ($service) use ($app) {
      return $app[$service];
    }
  );

  $commandHandlerMap = new CallableMap($map, $resolver);

  $commandBus->appendMiddleware(
    new DelegatesToMessageHandlerMiddleware(
      new NameBasedMessageHandlerResolver(
        new ClassBasedNameResolver(), $commandHandlerMap
      )
    )
  );

  $commandBus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());
  $commandBus->prependMiddleware(new MessageBusValidationMiddleware($app['validator']));
  
  return $commandBus;
};

/** validator */
$app['validator'] = function ()
{
  /** @var ValidatorInterface $validator */
  $validator = Validation::createValidatorBuilder()
    ->enableAnnotationMapping()
    ->getValidator();

  return $validator;
};

/** uuid */
$app['uuid'] = function () {
  /** @var UuidFactory $uuidFactory */
  $uuidFactory = new UuidFactory();
  return $uuidFactory;
};

$app['responseFactory'] = function () {
  $responseFactory = new ApiResponseFactory();
  return $responseFactory;
};