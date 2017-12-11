<?php
use SimpleBus\Message\Bus\Middleware\MessageBusSupportingMiddleware;
use SimpleBus\Message\Bus\Middleware\FinishesHandlingMessageBeforeHandlingNext;
use SimpleBus\Message\CallableResolver\CallableMap;
use SimpleBus\Message\CallableResolver\ServiceLocatorAwareCallableResolver;
use SimpleBus\Message\Handler\DelegatesToMessageHandlerMiddleware;
use SimpleBus\Message\Handler\Resolver\NameBasedMessageHandlerResolver;
use SimpleBus\Message\Name\ClassBasedNameResolver;

use Symfony\Component\Validator\Validation;

$app['validator'] = function ($app)
{
	$validator = Validation::createValidatorBuilder()
		->enableAnnotationMapping()
		->getValidator();

	return $validator;
};

$app['command_bus'] = function ($app) 
{
  $commandBus = new MessageBusSupportingMiddleware();

  $commandHandlerMap = new CallableMap(
  	[	
      // Command::class => 'service.name'
    ],
    new ServiceLocatorAwareCallableResolver(
    	function ($service) use ($app) {
    	  return $app[$service];
    	}
    )
  );

  $commandBus->appendMiddleware(
    new DelegatesToMessageHandlerMiddleware(
      new NameBasedMessageHandlerResolver(
        new ClassBasedNameResolver(), $commandHandlerMap
      )
    )
  );

  $commandBus->appendMiddleware(new FinishesHandlingMessageBeforeHandlingNext());
  $commandBus->prependMiddleware(new ValidationMiddleware($app['validator']));
  
  return $commandBus;
};
