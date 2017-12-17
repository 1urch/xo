<?php

namespace Lurch\XO\DTO;
use Lurch\XO\Entity\Player;

/**
 * Class GameStateDTO
 * @package Lurch\XO\DTO
 */
class GameStateDTO
{
  public $id;
  public $players;
  public $board;
  public $winner;
  public $status;
  public $turnsMade;
  public $playerTurn;

  /**
   * GameStateDTO constructor.
   * @param $id
   * @param $board
   * @param $winner
   * @param $status
   * @param $turnsMade
   */
  public function __construct($id, $board, $winner, $status, $turnsMade)
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
  public function addPlayer(Player $player)
  {
    $this->players[]['id'] = $player->getId();

    if (count($this->players) > 1) {
      $this->playerTurn = $this->players[$this->turnsMade % 2]['id'];
    }
  }
}