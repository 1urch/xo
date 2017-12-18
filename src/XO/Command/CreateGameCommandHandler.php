<?php

namespace Lurch\XO\Command;

use Doctrine\ORM\EntityManager;

use Lurch\XO\Entity\{Game, Player};
use Lurch\XO\Repository\{PlayerRepositoryInterface, GameRepositoryInterface};
use Lurch\XO\Exception\ObjectDoesNotExistsException;

/**
 * Class CreateGameCommandHandler
 * @package Lurch\XO\Command
 */
class CreateGameCommandHandler
{
  /**
   * @var PlayerRepositoryInterface
   */
  private $playerRepository;

  /**
   * @var GameRepositoryInterface
   */
  private $gameRepository;

  /**
   * CreateGameCommandHandler constructor.
   * @param GameRepositoryInterface $gameRepository
   * @param PlayerRepositoryInterface $playerRepository
   */
  public function __construct(GameRepositoryInterface $gameRepository, PlayerRepositoryInterface $playerRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->playerRepository = $playerRepository;
  }

  /**
   * @param CreateGameCommand $createGameCommand
   * @throws ObjectDoesNotExistsException
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function handle(CreateGameCommand $createGameCommand): void
  {
    /** @var Player $player */
    $player = $this->playerRepository->findById($createGameCommand->playerId);

    if (is_null($player))
      throw new ObjectDoesNotExistsException('Can not create a game cause player does not exists');

    /** @var Game $game */
    $game = $player->createGame($createGameCommand->id);
    $this->gameRepository->save($game);
  }
}