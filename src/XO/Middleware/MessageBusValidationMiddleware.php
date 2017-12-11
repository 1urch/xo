<?php

namespace Lurch\XO\Middleware;

use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ValidationMiddleware
 * @package Lurch\Cointainer\Application\Middleware
 */
class MessageBusValidationMiddleware implements MessageBusMiddleware
{
  /**
   * @var ValidatorInterface
   */
  protected $validator;

  /**
   * ValidationMiddleware constructor.
   * @param ValidatorInterface $validator
   */
  public function __construct(ValidatorInterface $validator)
  {
    $this->validator = $validator;
  }

  /**
   * @param object $message
   * @param callable $next
   */
  public function handle($message, callable $next)
  {
    $violations = $this->validator->validate($message);

    if (count($violations) != 0) {
      $error = $violations->get(0)->getMessage();
      throw new BadRequestHttpException($error);
    }

    $next($message);
  }

}