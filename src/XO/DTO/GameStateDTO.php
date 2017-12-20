<?php

namespace Lurch\XO\DTO;

use Lurch\XO\Entity\{Game, Player};

/**
 * Class GameStateDTO
 * @package Lurch\XO\DTO
 */
class GameStateDTO
{
  /**
   * @var string
   */
  public $id;

  /**
   * @var array
   */
  public $players;

  /**
   * @var array
   */
  public $board;

  /**
   * @var string
   */
  public $winner;

  /**
   * @var string
   */
  public $status;

  /**
   * @var int
   */
  public $turnsMade;

  /**
   * @var string
   */
  public $playerTurn;

  /**
   * GameStateDTO constructor.
   * @param $id
   * @param $board
   * @param $winner
   * @param $status
   * @param $turnsMade
   */
  public function __construct(string $id, array $board, string $winner = null, string $status, int $turnsMade)
  {
    $this->id = $id;
    $this->board = $board;
    $this->winner = $winner;
    $this->status = $status;
    $this->turnsMade = $turnsMade;
  }

  /**
   * @param Player $player
   */
  public function addPlayer(Player $player): void
  {
    $this->players[] = $player->getId();

    if (count($this->players) > 1 && $this->status !== Game::STATUS_COMPLETE) {
      $this->playerTurn = $this->players[$this->turnsMade % 2];
    }
  }
}