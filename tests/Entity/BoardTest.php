<?php

namespace Lurch\XO\Test\Entity;

use Lurch\XO\Entity\Board;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{

  protected $id;

  protected function setUp()
  {
    $this->id = '35c30b81-b7ec-4428-88f7-5d187c01e813';
  }

  /**
   * @dataProvider providerTestSetTile
   * @throws \Lurch\XO\Exception\UnableToSetTileException
   */
  public function testSetTileSuccess(int $x, int $y)
  {
    $board = new Board();
    $board->setTile($x, $y, 1);

    $this->assertEquals(1, $board->getTile($x, $y));
  }

  /**
   * @dataProvider providerTestSetTileUnavailable
   * @expectedException \Lurch\XO\Exception\UnableToSetTileException
   * @throws \Lurch\XO\Exception\UnableToSetTileException
   */
  public function testSetTileUnavailable(int $x, int $y)
  {
    $board = new Board();
    $board->setTile($x, $y, 1);
    $board->setTile($x, $y, 1);
  }

  /**
   * @expectedException \Lurch\XO\Exception\TileDoesNotExistsException
   * @throws \Lurch\XO\Exception\TileDoesNotExistsException
   */
  public function testGetTileDoesNotExists()
  {
    $board = new Board();
    $board->getTile(3,3);
  }

  public function testHaveCompletedRowFalse()
  {
    $boardArray = [[1, 2, 1], [2, 2, 1], [2, 1, 2]];
    $reflection = new \ReflectionClass('Lurch\XO\Entity\Board');
    $boardProp = $reflection->getProperty('board');
    $boardProp->setAccessible(true);

    $board = new Board();
    $boardProp->setValue($board, $boardArray);

    $this->assertFalse($board->haveCompletedRow());
  }

  /**
   * @dataProvider providerTestHaveCompletedRowTrue
   * @throws \Lurch\XO\Exception\UnableToSetTileException
   */
  public function testHaveCompletedRowTrue($tileOne, $tileTwo, $tileThree)
  {
    $board = new Board();
    $board->setTile($tileOne[0], $tileOne[1], 1);
    $board->setTile($tileTwo[0], $tileTwo[1], 1);
    $board->setTile($tileThree[0], $tileThree[1], 1);

    $this->assertTrue($board->haveCompletedRow());
  }

  public function testIsBoardFullFalse()
  {
    $board = new Board();
    $this->assertFalse($board->isBoardFull());
  }

  public function testIsBoardFullTrue()
  {
    $boardArray = [[1, 1, 1], [1, 1, 1], [1, 1, 1]];
    $reflection = new \ReflectionClass('Lurch\XO\Entity\Board');
    $boardProp = $reflection->getProperty('board');
    $boardProp->setAccessible(true);

    $board = new Board();
    $boardProp->setValue($board, $boardArray);

    $this->assertTrue($board->isBoardFull());
  }

  public function providerTestHaveCompletedRowTrue()
  {
    return [
      [[0, 0], [1, 0], [2, 0]], // horizontal first
      [[0, 1], [1, 1], [2, 1]], // horizontal second
      [[0, 2], [1, 2], [2, 2]], // horizontal third
      [[0, 0], [0, 1], [0, 2]], // vertical first
      [[1, 0], [1, 1], [1, 2]], // vertical second
      [[2, 0], [2, 1], [2, 2]], // vertical third
      [[0, 0], [1, 1], [2, 2]], // diagonal first
      [[0, 2], [1, 1], [1, 2]]  // diagonal second
    ];
  }

  public function providerTestSetTile()
  {
    return [
      [0, 0],
      [0, 1],
      [0, 2],
      [1, 0],
      [1, 1],
      [1, 2],
      [2, 0],
      [2, 1],
      [2, 2]
    ];
  }

  public function providerTestSetTileUnavailable()
  {
    return [
      [0, 0],
      [3, 1],
      [1, 3]
    ];
  }

}
