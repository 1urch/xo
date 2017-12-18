<?php

namespace Lurch\XO\Repository;

use Lurch\XO\Entity\Game;
/**
 * Interface GameRepositoryInterface
 * @package Lurch\XO\Repository
 */
interface GameRepositoryInterface {

  /**
   * @param string $id
   * @return Game|null
   */
  public function findById(string $id): ?Game;
  /**
   * @param Game $game
   */
  public function save(Game $game): void;

}
