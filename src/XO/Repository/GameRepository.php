<?php

namespace Lurch\XO\Repository;

use Doctrine\ORM\EntityRepository;
use Lurch\XO\Entity\Game;
/**
 * Class GameRepository
 * @package Lurch\XO\Repository
 */
class GameRepository extends EntityRepository implements GameRepositoryInterface
{

  /**
   * @param string $id
   * @return Game|null
   */
  public function findById(string $id): ?Game
  {
    $game = $this->find($id);
    if (!$game instanceof Game) return null;

    return $game;
  }

  /**
   * @param Game $game
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function save(Game $game): void
  {
    $this->_em->persist($game);
    $this->_em->flush();
  }

}