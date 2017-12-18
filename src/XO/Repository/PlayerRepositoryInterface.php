<?php

namespace Lurch\XO\Repository;

use Lurch\XO\Entity\Player;
/**
 * Interface PlayerRepositoryInterface
 * @package Lurch\XO\Repository
 */
interface PlayerRepositoryInterface {

  /**
   * @param string $id
   * @return Player
   */
  public function findById(string $id): ?Player;

  /**
   * @param Player $player
   */
  public function save(Player $player): void;

}
