<?php

namespace Lurch\XO\Query;

use Traversable;
use Doctrine\ORM\EntityManager;
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
    //
    return ['message' => $message];
  }
}