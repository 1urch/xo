<?php

namespace Lurch\XO\Query;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;

/**
 * Class GamesListQuery
 * @package Lurch\XO\Query
 */
class GamesListQuery
{
  /**
   * @var QueryBuilder
   */
  private $em;

  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  public function __invoke()
  {
    //
  }
}