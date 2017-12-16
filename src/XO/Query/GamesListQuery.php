<?php

namespace Lurch\XO\Query;

use Doctrine\ORM\EntityManager;
use Lurch\XO\Entity\Game;
/**
 * Class GamesListQuery
 * @package Lurch\XO\Query
 */
class GamesListQuery
{
  /**
   * @var EntityManager
   */
  private $em;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  public function __invoke(string $message): array
  {
    $dql = 'SELECT game.id FROM Lurch\XO\Entity\Game game WHERE game.status = :status';
    $query = $this->em->createQuery($dql);
    $query->setParameter('status', Game::STATUS_CREATED);

    return $query->getArrayResult();
  }
}