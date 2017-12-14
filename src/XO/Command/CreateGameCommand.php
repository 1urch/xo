<?php

namespace Lurch\XO\Command;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Class CreateGameCommand
 * @package Lurch\XO\Command
 */
class CreateGameCommand
{
  /**
   * @var string
   * @Assert\NotBlank()
   * @Assert\Uuid
   */
  public $id;

  /**
   * @var string
   * @Assert\NotBlank()
   * @Assert\Uuid
   */
  public $player_id;

}