<?php

namespace Lurch\XO\Entity;

use Lurch\XO\Entity\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
  public function testSuccessCreation()
  {
    $id = 'f6acd343-0af1-4065-adc1-ff1fefa771ed';
    $name = 'Player One';

    $player = new Player($id, $name);

    $this->assertEquals($id, $player->getId());
    $this->assertEquals($name, $player->getName());
  }

}
