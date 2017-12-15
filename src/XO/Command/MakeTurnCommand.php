<?php

namespace Lurch\XO\Command;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MakeTurnCommand
 * @package Lurch\XO\Command
 */
class MakeTurnCommand
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
   * @var int
   * @Assert\Type("integer")
   * @Assert\NotBlank()
   */
  public $x;

  /**
   * @var int
   * @Assert\Type("integer")
   * @Assert\NotBlank()
   */
  public $y;

  public function __construct(string $gameId, string $playerId, $x, $y)
  {
    $this->gameId = $gameId;
    $this->playerId = $playerId;
    $this->x = $x;
    $this->y = $y;
  }

}