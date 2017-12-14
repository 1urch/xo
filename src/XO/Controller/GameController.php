<?php

namespace Lurch\XO\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use SimpleBus\Message\Bus\MessageBus;
use Ramsey\Uuid\UuidFactory;


use Lurch\XO\Common\JsonMapperInterface;
use Lurch\XO\Command\CreateGameCommand;
use Lurch\XO\Command\JoinGameCommand;
use Lurch\XO\Command\MakeTurnCommand;

use Lurch\XO\Common\ApiResponseFactoryInterface;

class GameController
{

  /**
   * @var MessageBus
   */
  private $commandBus;
  /**
   * @var JsonMapperInterface
   */
  private $mapper;
  /**
   * @var UuidFactory
   */
  private $uuidFactory;

  /**
   * @var ApiResponseFactoryInterface
   */
  private $response;

  /**
   * @var CreateGameCommand
   */
  private $createGameCommand;

  /**
   * @var JoinGameCommand
   */
  private $joinGameCommand;

  /**
   * @var MakeTurnCommand
   */
  private $makeTurnCommand;

  /**
   * GameController constructor.
   * @param MessageBus $commandBus
   * @param JsonMapperInterface $mapper
   * @param UuidFactory $uuidFactory
   */
  public function __construct(MessageBus $commandBus, JsonMapperInterface $mapper, UuidFactory $uuidFactory, ApiResponseFactoryInterface $response)
  {
    $this->commandBus = $commandBus;
    $this->mapper = $mapper;
    $this->uuidFactory = $uuidFactory;
    $this->response = $response;
  }

  /**
   * @param CreateGameCommand $createGameCommand
   */
  public function setUpCommands(CreateGameCommand $createGameCommand, JoinGameCommand $joinGameGommand, MakeTurnCommand $makeTurnCommand)
  {
    $this->createGameCommand = $createGameCommand;
    $this->joinGameCommand = $joinGameGommand;
    $this->makeTurnCommand = $makeTurnCommand;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function create(Request $request): JsonResponse
  {
    $uuid = $this->uuidFactory->uuid4();

    $this->createGameCommand->id = $uuid;
    $this->createGameCommand->player_id = $request->request->get('token');

    $this->commandBus->handle($this->createGameCommand);

    $data = ['id' => $uuid];

    return $this->response->success($data);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function join(Request $request, string $id): JsonResponse
  {
    $this->joinGameCommand->player_id = $request->request->get('token');
    $this->joinGameCommand->game_id = $id;

    $this->commandBus->handle($this->joinGameCommand);

    return $this->response->success();
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function turn(Request $request, string $id): JsonResponse
  {
    $this->makeTurnCommand->player_id = $request->request->get('token');
    $this->makeTurnCommand->game_id = $id;
    $this->makeTurnCommand->x = $request->request->get('x');
    $this->makeTurnCommand->y = $request->request->get('y');

    return $this->response->success();
  }
}