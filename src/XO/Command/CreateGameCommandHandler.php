<?php

namespace Lurch\XO\Command;

use Lurch\XO\Repository\GameRepository;
use Lurch\XO\Repository\PlayerRepository;

/**
 * Class CreateGameCommandHandler
 * @package Lurch\XO\Command
 */
class CreateGameCommandHandler
{
  private $gameRepository;
  private $playerRepository;

  /**
   * CreateGameCommandHandler constructor.
   * @param GameRepository $gameRepository
   * @param PlayerRepository $playerRepository
   */
  public function __construct(GameRepository $gameRepository, PlayerRepository $playerRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->playerRepository = $playerRepository;
  }

  /**
   * @param CreateGameCommand $createGameCommand
   */
  public function handle(CreateGameCommand $createGameCommand): void
  {

  }
}