<?php

namespace Lurch\XO\Command;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class JoinGameCommand
 * @package Lurch\XO\Command
 */
class JoinGameCommand
{
  /**
   * @var string
   * @Assert\NotBlank()
   * @Assert\Uuid
   */
  public $gameId;

  /**
   * @var string
   * @Assert\NotBlank()
   * @Assert\Uuid
   */
  public $playerId;

  /**
   * JoinGameCommand constructor.
   * @param string $gameId
   * @param string $playerId
   */
  public function __construct(string $gameId, string $playerId)
  {
    $this->gameId = $gameId;
    $this->playerId = $playerId;
  }
}