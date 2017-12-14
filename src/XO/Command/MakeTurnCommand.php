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
  public $game_id;

  /**
   * @var string
   * @Assert\NotBlank()
   * @Assert\Uuid
   */
  public $player_id;

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

}