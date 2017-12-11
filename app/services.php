<?php

use Lurch\XO\Middleware\MessageBusValidationMiddleware;

use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;

use Symfony\Component\Validator\Validation;

$app['commandBus'] = function ($app)
{
  $commandBus = new MessageBusSupportingMiddleware();

  $map = [
    // Command::class => 'service.name'
  ];

  $resolver = new ServiceLocatorAwareCallableResolver(
    function ($service) use ($app) {
      return $app[$service];
    }
  );

  $commandHandlerMap = new CallableMap($map, $resolver);

  $app['validator'] = function ($app)
  {
    $validator = Validation::createValidatorBuilder()
      ->enableAnnotationMapping()
      ->getValidator();

    return $validator;
  };

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
