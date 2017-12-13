<?php

namespace Lurch\XO\Command;

/**
 * Class CreateGameCommand
 * @package Lurch\XO\Command
 */
class CreateGameCommand
{
  /**
   * @var string
   */
  private $id;

  /**
   * @param string $id
   */
  public function setId(string $id)
  {
    $this->id = $id;
  }

  /**
   * @return string
   */
  public function getId()
  {
    return $this->id;
  }
}