<?php

namespace Lurch\XO\Entity;

use Doctrine\ORM\Mapping as ORM;

use Lurch\XO\Exception\TileDoesNotExistsException;
use Lurch\XO\Exception\UnableToSetTileException;

/**
 * @ORM\Entity(repositoryClass="Lurch\XO\Repository\BoardRepository")
 * @ORM\Table(name="")
 */
class Board
{
  /**
   * @var string
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="NONE")
   * @ORM\Column(type="guid")
   */
  private $id;

  /**
   * @var array
   * @ORM\Column(type="json")
   */
  private $board = [[0, 0, 0], [0, 0, 0], [0, 0, 0]];

  /**
   * @var array
   */
  private static $rows = [
    [[0, 0], [1, 0], [2, 0]], // horizontal first
    [[0, 1], [1, 1], [2, 1]], // horizontal second
    [[0, 2], [1, 2], [2, 2]], // horizontal third
    [[0, 0], [0, 1], [0, 2]], // vertical first
    [[1, 0], [1, 1], [1, 2]], // vertical second
    [[2, 0], [2, 1], [2, 2]], // vertical third
    [[0, 0], [1, 1], [2, 2]], // diagonal first
    [[0, 2], [1, 1], [1, 2]]  // diagonal second
  ];

  /**
   * Board constructor.
   */
  public function __construct(string $id)
  {
    $this->id = $id;
  }

  /**
   * @param int $x
   * @param int $y
   * @param int $value
   * @throws UnableToSetTileException
   */
  public function setTile(int $x, int $y, int $value): void
  {
    if (!$this->isTileAvailable($x, $y)) {
      throw new UnableToSetTileException('Tile [' . $x . ',' . $y .'] occupied or does not exists');
    }

    $this->board[$x][$y] = $value;
  }

  /**
   * @param $x
   * @param $y
   * @return int
   * @throws TileDoesNotExistsException
   */
  public function getTile($x, $y): int
  {
    if (!isset($this->board[$x][$y])) {
      throw new TileDoesNotExistsException('Tile [' . $x . ',' . $y .'] does not exists');
    }

    return $this->board[$x][$y];
  }

  /**
   * @param int $x
   * @param int $y
   * @return bool
   */
  public function isTileAvailable(int $x, int $y): bool
  {
    return isset($this->board[$x][$y]) && $this->board[$x][$y] === 0;
  }

  /**
   * @return bool
   */
  public function haveCompletedRow(): bool
  {
    foreach (self::$rows as $row) {

      $count = 1;
      $previousTile = null;

      foreach ($row as $tileAddress) {
        $currentTile = $this->board[$tileAddress[0]][$tileAddress[1]];

        if ($currentTile === 0) break;

        if (!is_null($previousTile)) {
          if ($previousTile === $currentTile) $count++;
          else break;
        }

        $previousTile = $currentTile;
      }

      if ($count === 3) return true;
    }

    return false;
  }

  /**
   * @return bool
   */
  public function isBoardFull(): bool
  {
    foreach ($this->board as $keyX => $valueX) {
      foreach ($this->board[$keyX] as $keyY => $valueY) {
        if (!$this->board[$keyX][$keyY])
          return false;
      }
    }

    return true;
  }

}