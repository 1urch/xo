<?php

namespace Lurch\XO\Command;

use Doctrine\ORM\EntityManager;

use Lurch\XO\Entity\{Game, Player};
use Lurch\XO\Repository\{GameRepository, PlayerRepository};
use Lurch\XO\Exception\ObjectDoesNotExistsException;
/**
 * Class MakeTurnCommandHandler
 * @package Lurch\XO\Command
 */
class MakeTurnCommandHandler
{
  /**
   * @var EntityManager
   */
  private $em;

  /**
   * @var GameRepository
   */
  private $gameRepository;

  /**
   * @var PlayerRepository
   */
  private $playerRepository;

  /**
   * MakeTurnCommandHandler constructor.
   * @param EntityManager $em
   * @param GameRepository $gameRepository
   * @param PlayerRepository $playerRepository
   */
  public function __construct(EntityManager $em, GameRepository $gameRepository, PlayerRepository $playerRepository)
  {
    $this->em = $em;
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
    $player = $this->playerRepository->find($makeTurnCommand->playerId);

    if (is_null($player))
      throw new ObjectDoesNotExistsException('It is not possible to join a non-existent player to the game');

    /** @var Game $game */
    $game = $this->gameRepository->find($makeTurnCommand->gameId);

    if (is_null($game))
      throw new ObjectDoesNotExistsException('It is not possible to join a non-existent game');

    $game->turn($player, $makeTurnCommand->x, $makeTurnCommand->y);
    $this->em->flush();
  }

}