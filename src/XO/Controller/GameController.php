<?php

namespace Lurch\XO\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use SimpleBus\Message\Bus\MessageBus;
use Ramsey\Uuid\UuidFactory;


use Lurch\XO\Common\JsonMapperInterface;
use Lurch\XO\Command\CreateGameCommand;

class GameController
{

  private $commandBus;
  private $mapper;
  private $uuidFactory;

  /**
   * @var CreateGameCommand
   */
  private $createGameCommand;

  public function __construct(MessageBus $commandBus, JsonMapperInterface $mapper, UuidFactory $uuidFactory)
  {
    $this->commandBus = $commandBus;
    $this->mapper = $mapper;
    $this->uuidFactory = $uuidFactory;
  }

  public function setUpCommands(CreateGameCommand $createGameCommand)
  {
    $this->createGameCommand = $createGameCommand;
  }

  public function create(Request $request)
  {
    $json = $request->getContent();
    $uuid = $this->uuidFactory->uuid4();
    $this->createGameCommand->setId($uuid);
    $command = $this->mapper->map($json, $this->createGameCommand);
    $this->commandBus->handle($command);

    return new JsonResponse(['id' => $command->getId()]);
  }
}