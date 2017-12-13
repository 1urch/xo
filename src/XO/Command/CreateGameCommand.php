<?php

namespace Lurch\XO\Command;

class CreateGameCommand
{
  private $id;
  /*
   * @var string
   */
  public $name;

  public function setId(string $id)
  {
    $this->id = $id;
  }

  public function getId()
  {
    return $this->id;
  }
}