<?php

namespace Lurch\XO\Command;

use Doctrine\ORM\EntityManager;

use Lurch\XO\Entity\{Player, Game};
use Lurch\XO\Repository\{
  GameRepository, GameRepositoryInterface, PlayerRepository, PlayerRepositoryInterface
};
use Lurch\XO\Exception\ObjectDoesNotExistsException;
/**
 * Class JoinGameCommandHandler
 * @package Lurch\XO\Command
 */
class JoinGameCommandHandler
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
   * JoinGameCommandHandler constructor.
   * @param GameRepositoryInterface $gameRepository
   * @param PlayerRepositoryInterface $playerRepository
   */
  public function __construct(GameRepositoryInterface $gameRepository, PlayerRepositoryInterface $playerRepository)
  {
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
    $player = $this->playerRepository->findById($joinGameCommand->playerId);

    if (is_null($player))
      throw new ObjectDoesNotExistsException('It is not possible to join a non-existent player to the game');

    /** @var Game $game */
    $game = $this->gameRepository->findById($joinGameCommand->gameId);

    if (is_null($game))
      throw new ObjectDoesNotExistsException('It is not possible to join a non-existent game');

    $game->join($player);
    $this->gameRepository->save($game);
  }

}