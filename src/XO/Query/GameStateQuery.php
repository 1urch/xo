<?php

namespace Lurch\XO\Query;

use Doctrine\ORM\{EntityManager, Query};
use Lurch\XO\DTO\GameStateDTO;
use Lurch\XO\Exception\ObjectDoesNotExistsException;
/**
 * Class GameStateQuery
 * @package Lurch\XO\Query
 */
class GameStateQuery
{

  /**
   * @var EntityManager
   */
  private $em;

  /**
   * GameStateQuery constructor.
   * @param EntityManager $em
   */
  public function __construct(EntityManager $em)
  {
    $this->em = $em;
  }

  /**
   * @param string $id
   * @return object
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function __invoke(string $id): object
  {
    $dql = 'SELECT NEW Lurch\XO\DTO\GameStateDTO(game.id, game.board.board, game.winner, game.status, game.turnsMade) '
         . 'FROM Lurch\XO\Entity\Game game WHERE game.id = :id';
    /** @var Query $query */
    $query = $this->em->createQuery($dql);
    $query->setParameter('id', $id);
    /** @var GameStateDTO $game */
    $game = $query->getSingleResult();

    if (!$game instanceof GameStateDTO)
      throw new ObjectDoesNotExistsException('Game does not exists');

    $dql = 'SELECT player FROM Lurch\XO\Entity\Player player JOIN player.games game WHERE game.id = :id';
    $query = $this->em->createQuery($dql);
    $query->setParameter('id', $id);
    $players = $query->getResult();

    foreach ($players as $player) {
      $game->addPlayer($player);
    }

    $result = new class { public $game; };
    $result->game = $game;

    return $result;
  }
}