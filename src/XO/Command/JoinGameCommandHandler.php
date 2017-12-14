<?php

namespace Lurch\XO\Command;

use Lurch\XO\Repository\GameRepository;
use Lurch\XO\Repository\PlayerRepository;

class JoinGameCommandHandler
{
  private $gameRepository;
  private $playerRepository;

  public function __construct(GameRepository $gameRepository, PlayerRepository $playerRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->playerRepository = $playerRepository;
  }

  public function handle(JoinGameCommand $joinGameCommand)
  {
    //
  }

}