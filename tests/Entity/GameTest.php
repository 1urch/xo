<?php

namespace Lurch\XO\Test\Entity;

use PHPUnit\Framework\TestCase;

use Lurch\XO\Entity\Game;

class GameTest extends TestCase
{
  protected $id;
  protected $board;
  protected $game;
  protected $playerOne;
  protected $playerTwo;

  protected function setUp()
  {
    $this->board = $this->getMockBuilder('Lurch\XO\Entity\Board')
      ->getMock();

    $this->playerOne = $this->getMockBuilder('Lurch\XO\Entity\Player')
      ->setConstructorArgs(['f6acd343-0af1-4065-adc1-ff1fefa771ed', 'PlayerOne'])
      ->getMock();

    $this->playerTwo = $this->getMockBuilder('Lurch\XO\Entity\Player')
      ->setConstructorArgs(['e74dbfc1-6ce6-4901-990c-dea6fbe9992f', 'PlayerTwo'])
      ->getMock();

    $this->id = '4a70e603-890b-4dec-bf1a-a3c32c63f4e0';
  }

  public function testJoinSuccess()
  {
    $game = new Game($this->id, $this->board, $this->playerOne);
    $game->join($this->playerTwo);
    $this->assertAttributeCount(2, 'players', $game);
  }

  /**
   * @expectedException \Lurch\XO\Exception\WrongStatusException
   */
  public function testJoinAfterGameStart()
  {
    $game = new Game($this->id, $this->board, $this->playerOne);
    $game->join($this->playerTwo);
    $game->join($this->playerOne);
  }

  /**
   * @expectedException \Lurch\XO\Exception\AlreadyJoinedException
   */
  public function testJoinPlayerAlreadyJoined()
  {
    $game = new Game($this->id, $this->board, $this->playerOne);
    $game->join($this->playerOne);
  }

  /**
   * @expectedException \Lurch\XO\Exception\WrongStatusException
   */
  public function testTurnAtWrongStatus()
  {
    $game = new Game($this->id, $this->board, $this->playerOne);
    $game->turn($this->playerOne, 1, 1);
  }

  /**
   * @expectedException \Lurch\XO\Exception\ActionDeniedException
   */
  public function testTurnAtWrongOrder()
  {
    $game = new Game($this->id, $this->board, $this->playerOne);
    $game->join($this->playerTwo);
    $game->turn($this->playerTwo, 1, 1);
  }

  public function testTurnSuccess()
  {
    $this->board->expects($this->once())
      ->method('haveCompletedRow')
      ->will($this->returnValue(false));

    $this->board->expects($this->once())
      ->method('isBoardFull')
      ->will($this->returnValue(false));

    $game = new Game($this->id, $this->board, $this->playerOne);
    $game->join($this->playerTwo);
    $game->turn($this->playerOne, 1, 1);
    $this->assertAttributeEquals(1, 'turnsMade', $game);
  }

  public function testTurnHaveWinner()
  {
    $this->board->expects($this->once())
      ->method('haveCompletedRow')
      ->will($this->returnValue(true));

    $game = new Game($this->id, $this->board, $this->playerOne);
    $game->join($this->playerTwo);
    $game->turn($this->playerOne, 1, 1);

    $this->assertAttributeEquals($game::STATUS_COMPLETE, 'status', $game);
    $this->assertAttributeEquals($this->playerOne, 'winner', $game);
  }

  public function testTurnBoardIsFull()
  {
    $this->board->expects($this->once())
      ->method('haveCompletedRow')
      ->will($this->returnValue(false));

    $this->board->expects($this->once())
      ->method('isBoardFull')
      ->will($this->returnValue(true));

    $game = new Game($this->id, $this->board, $this->playerOne);
    $game->join($this->playerTwo);
    $game->turn($this->playerOne, 1, 1);

    $this->assertAttributeEquals($game::STATUS_COMPLETE, 'status', $game);
    $this->assertAttributeEquals(null, 'winner', $game);
  }
}