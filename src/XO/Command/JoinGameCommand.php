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
  public $game_id;

  /**
   * @var string
   * @Assert\NotBlank()
   * @Assert\Uuid
   */
  public $player_id;
}