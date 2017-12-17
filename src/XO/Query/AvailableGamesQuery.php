<?php

namespace Lurch\XO\Query;

use Doctrine\ORM\{EntityManager, Query};
use Lurch\XO\Entity\Game;
/**
 * Class AvailableGamesQuery
 * @package Lurch\XO\Query
 */
class AvailableGamesQuery
{
  /**
   * @var EntityManager
   */
  private $em;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  public function __invoke(): array
  {
    $dql = 'SELECT game.id FROM Lurch\XO\Entity\Game game WHERE game.status = :status';
    /** @var Query $query */
    $query = $this->em->createQuery($dql);
    $query->setParameter('status', Game::STATUS_CREATED);

    $result = new class{ public $games; };
    $result->games = $query->getArrayResult();

    return $result;
  }
}