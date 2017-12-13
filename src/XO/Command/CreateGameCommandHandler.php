<?php

namespace Lurch\XO\Command;

use Lurch\XO\Repository\GameRepository;
use Lurch\XO\Repository\PlayerRepository;

use Lurch\XO\Command\CreateGameCommand;

class CreateGameCommandHandler
{
  private $gameRepository;
  private $playerRepository;

  public function __construct(GameRepository $gameRepository, PlayerRepository $playerRepository)
  {
    $this->gameRepository = $gameRepository;
    $this->playerRepository = $playerRepository;
  }

  public function handle(CreateGameCommand $createGameCommand)
  {

  }
}