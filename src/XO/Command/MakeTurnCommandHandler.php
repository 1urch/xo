<?php

namespace Lurch\XO\Command;

use Doctrine\ORM\EntityManager;

use Lurch\XO\Entity\{Game, Player};
use Lurch\XO\Repository\{GameRepositoryInterface, PlayerRepositoryInterface};
use Lurch\XO\Exception\ObjectDoesNotExistsException;

/**
 * Class MakeTurnCommandHandler
 * @package Lurch\XO\Command
 */
class MakeTurnCommandHandler
{
  /**
   * @var GameRepositoryInterface
   */
  private $gameRepository;

  /**
   * @var PlayerRepositoryInterface
   */
  private $playerRepository;

  /**
   * MakeTurnCommandHandler constructor.
   * @param EntityManager $em
   * @param GameRepositoryInterface $gameRepository
   * @param PlayerRepositoryInterface $playerRepository
   */
  public function __construct(GameRepositoryInterface $gameRepository, PlayerRepositoryInterface $playerRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->playerRepository = $playerRepository;
  }

  /**
   * @param MakeTurnCommand $makeTurnCommand
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function handle(MakeTurnCommand $makeTurnCommand): void
  {
    /** @var Player $player */
    $player = $this->playerRepository->findById($makeTurnCommand->playerId);

    if (is_null($player))
      throw new ObjectDoesNotExistsException('A non-existed player can not make a turn');

    /** @var Game $game */
    $game = $this->gameRepository->findById($makeTurnCommand->gameId);

    if (is_null($game))
      throw new ObjectDoesNotExistsException('It is not possible to make a turn for non-existed game');

    $game->turn($player, $makeTurnCommand->x, $makeTurnCommand->y);
    $this->gameRepository->save($game);
  }

}