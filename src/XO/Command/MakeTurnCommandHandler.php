<?php

namespace Lurch\XO\Command;

use Lurch\XO\Repository\GameRepository;
use Lurch\XO\Repository\PlayerRepository;

/**
 * Class MakeTurnCommandHandler
 * @package Lurch\XO\Command
 */
class MakeTurnCommandHandler
{
  private $gameRepository;
  private $playerRepository;

  /**
   * MakeTurnCommandHandler constructor.
   * @param GameRepository $gameRepository
   * @param PlayerRepository $playerRepository
   */
  public function __construct(GameRepository $gameRepository, PlayerRepository $playerRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->playerRepository = $playerRepository;
  }

  /**
   * @param MakeTurnCommand $makeTurnCommand
   */
  public function handle(MakeTurnCommand $makeTurnCommand): void
  {

  }

}