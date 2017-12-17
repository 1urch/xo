<?php

namespace Lurch\XO\Command;

use Doctrine\ORM\EntityManager;

use Lurch\XO\Entity\{Player, Game};
use Lurch\XO\Repository\{GameRepository, PlayerRepository};
use Lurch\XO\Exception\ObjectDoesNotExistsException;
/**
 * Class JoinGameCommandHandler
 * @package Lurch\XO\Command
 */
class JoinGameCommandHandler
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
   * JoinGameCommandHandler constructor.
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
   * @param JoinGameCommand $joinGameCommand
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function handle(JoinGameCommand $joinGameCommand): void
  {
    /** @var Player $player */
    $player = $this->playerRepository->find($joinGameCommand->playerId);

    if (is_null($player))
      throw new ObjectDoesNotExistsException('It is not possible to join a non-existent player to the game');

    /** @var Game $game */
    $game = $this->gameRepository->find($joinGameCommand->gameId);

    if (is_null($game))
      throw new ObjectDoesNotExistsException('It is not possible to join a non-existent game');

    $game->join($player);
    $this->em->flush();
  }

}