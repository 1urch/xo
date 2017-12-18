<?php

namespace Lurch\XO\Repository;

use Doctrine\ORM\EntityRepository;
use Lurch\XO\Entity\Player;
/**
 * Class PlayerRepository
 * @package Lurch\XO\Repository
 */
class PlayerRepository extends EntityRepository implements PlayerRepositoryInterface
{

  /**
   * @param string $id
   * @return Player|null
   */
  public function findById(string $id): ?Player
  {
    $player = $this->find($id);
    if (!$player instanceof Player) return null;

    return $player;
  }

  /**
   * @param Player $player
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function save(Player $player): void
  {
    $this->_em->persist($player);
    $this->_em->flush();
  }

}