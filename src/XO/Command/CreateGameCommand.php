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
  public $playerId;

  /**
   * CreateGameCommand constructor.
   * @param string $id
   * @param string $playerId
   */
  public function __construct(string $id, string $playerId)
  {
    $this->id = $id;
    $this->playerId = $playerId;
  }
}