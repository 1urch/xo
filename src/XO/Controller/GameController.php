<?php

namespace Lurch\XO\Controller;

use Lurch\XO\Common\JsonMapperInterface;

use Lurch\XO\Command\CreateGameCommand;

use Ramsey\Uuid\UuidFactory;
use Symfony\Component\HttpFoundation\Request;
use SimpleBus\Message\Bus\MessageBus;

class GameController
{

  private $request;
  private $commandBus;
  private $mapper;
  private $uuidFactory;

  /**
   * @var CreateGameCommand
   */
  private $createGameCommand;

  public function __construct(Request $request, MessageBus $commandBus, JsonMapperInterface $mapper, UuidFactory $uuidFactory)
  {
    $this->request = $request;
    $this->commandBus = $commandBus;
    $this->mapper = $mapper;
    $this->uuidFactory = $uuidFactory;
  }

  public function setUpCommands(CreateGameCommand $createGameCommand)
  {
    $this->createGameCommand = $createGameCommand;
  }

  public function create(string $id)
  {
//    $json = $this->request->getContent();
//    $uuid = $this->uuidFactory->uuid4();
//
//    $this->createGameCommand->setId($uuid);
//
//    $command = $this->mapper->map($json, $this->createGameCommand);
//    $this->commandBus->handle($command);
  }
}