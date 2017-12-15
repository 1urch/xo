<?php

namespace Lurch\XO\Command;

use Lurch\XO\Repository\{GameRepository, PlayerRepository};
/**
 * Class JoinGameCommandHandler
 * @package Lurch\XO\Command
 */
class JoinGameCommandHandler
{
  private $gameRepository;
  private $playerRepository;

  /**
   * JoinGameCommandHandler constructor.
   * @param GameRepository $gameRepository
   * @param PlayerRepository $playerRepository
   */
  public function __construct(GameRepository $gameRepository, PlayerRepository $playerRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->playerRepository = $playerRepository;
  }

  /**
   * @param JoinGameCommand $joinGameCommand
   */
  public function handle(JoinGameCommand $joinGameCommand): void
  {

  }

}