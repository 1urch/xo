<?php

use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\EntityManager;

use Ramsey\Uuid\UuidFactory;

use Lurch\XO\Middleware\MessageBusValidationMiddleware;
use Lurch\XO\Common\JsonMapperFacade;

use Lurch\XO\Repository\GameRepository;
use Lurch\XO\Repository\PlayerRepository;
use Lurch\XO\Entity\Game;
use Lurch\XO\Entity\Player;
use Lurch\XO\Command\CreateGameCommand;
use Lurch\XO\Command\CreateGameCommandHandler;


$app['service.game.create'] = function ($app) {
  /** @var EntityManager $em */
  $em = $app['orm.em'];
  /** @var GameRepository $gameRepository */
  $gameRepository = $em->getRepository(Game::class);
  /** @var PlayerRepository $playerRepository */
  $playerRepository = $em->getRepository(Player::class);

  return new CreateGameCommandHandler($gameRepository, $playerRepository);
};


/** commandBus */
$app['commandBus'] = function ($app) {
  /** @var MessageBusSupportingMiddleware $commandBus */
  $commandBus = new MessageBusSupportingMiddleware();

  $map = [
    CreateGameCommand::class => 'service.game.create'
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

/** mapper */
$app['mapper'] = function () {
  /** @var JsonMapperFacade $mapper */
  $mapper = new JsonMapperFacade();
  return $mapper;
};

/** uuid */
$app['uuid'] = function () {
  /** @var UuidFactory $uuidFactory */
  $uuidFactory = new UuidFactory();
  return $uuidFactory;
};