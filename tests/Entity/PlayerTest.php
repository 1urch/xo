<?php

namespace Lurch\XO\Test\Entity;

use Lurch\XO\Entity\Player;
use PHPUnit\Framework\TestCase;

/**
 * Class PlayerTest
 * @package Lurch\XO\Entity
 */
class PlayerTest extends TestCase
{
  public function testSuccessCreation()
  {
    $id = 'f6acd343-0af1-4065-adc1-ff1fefa771ed';
    $name = 'Player One';

    $player = new Player($id, $name);

    $this->assertEquals($id, $player->getId());
    $this->assertEquals($name, $player->getName());
    $this->assertEmpty($player->getGames());
  }

  public function testCreateGame()
  {
    $player = new Player('f6acd343-0af1-4065-adc1-ff1fefa771ed', 'Player One');
    $game = $player->createGame('b29218e9-2a25-4290-89b4-74bba378d3fa');

    $this->assertInstanceOf('Lurch\XO\Entity\Game', $game);
  }


}
