<?php

namespace Lurch\XO\Controller;

use Symfony\Component\HttpFoundation\{Request, JsonResponse};

use Lurch\XO\Common\{JsonMapperInterface, ApiResponseFactoryInterface};
use Lurch\XO\Command\{CreateGameCommand, JoinGameCommand, MakeTurnCommand};
use Lurch\XO\Query\{AvailableGamesQuery, GameStateQuery};

use SimpleBus\Message\Bus\MessageBus;
use Ramsey\Uuid\UuidFactory;

class GameController
{

  /**
   * @var MessageBus
   */
  private $commandBus;

  /**
   * @var UuidFactory
   */
  private $uuidFactory;

  /**
   * @var ApiResponseFactoryInterface
   */
  private $response;


  /**
   * GameController constructor.
   * @param MessageBus $commandBus
   * @param UuidFactory $uuidFactory
   * @param ApiResponseFactoryInterface $response
   */
  public function __construct(MessageBus $commandBus, UuidFactory $uuidFactory, ApiResponseFactoryInterface $response)
  {
    $this->commandBus = $commandBus;
    $this->uuidFactory = $uuidFactory;
    $this->response = $response;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function create(Request $request): JsonResponse
  {
    $uuid = $this->uuidFactory->uuid4();

    $command = new CreateGameCommand($uuid, $request->request->get('token'));
    $this->commandBus->handle($command);

    $data = new class { public $id; };
    $data->id = $uuid;

    return $this->response->success($data);
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function join(Request $request, string $id): JsonResponse
  {
    $command = new JoinGameCommand($id, $request->request->get('token'));
    $this->commandBus->handle($command);

    return $this->response->success();
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function turn(Request $request, string $id): JsonResponse
  {
    $x = $request->request->get('x');
    $y = $request->request->get('y');
    $command = new MakeTurnCommand($id, $request->request->get('token'), $x, $y);
    $this->commandBus->handle($command);

    return $this->response->success();
  }

  public function list(Request $request, AvailableGamesQuery $availableGamesQuery)
  {
    return $this->response->success($availableGamesQuery());
  }

  public function state(Request $request, GameStateQuery $gameStateQuery, string $id)
  {
    return $this->response->success($gameStateQuery($id));
  }
}