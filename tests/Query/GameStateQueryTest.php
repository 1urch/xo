<?php
namespace Lurch\XO\Test\Query;

use PHPUnit\Framework\TestCase;

use Doctrine\ORM\{AbstractQuery, EntityManager};

use Lurch\XO\Entity\{Game, Player};
use Lurch\XO\DTO\GameStateDTO;
use Lurch\XO\Query\GameStateQuery;

class GameStateQueryTest extends TestCase
{

  /**
   * @var EntityManager
   */
  private $em;

  /**
   * @var AbstractQuery
   */
  private $query;

  public function setUp()
  {
    $this->em = $this->getMockBuilder('Doctrine\ORM\EntityManager')
      ->disableOriginalConstructor()
      ->getMock();

    $this->query = $this->getMockBuilder('Doctrine\ORM\AbstractQuery')
      ->disableOriginalConstructor()
      ->getMock();
  }

  /**
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function testQueryInvokeSuccess()
  {
    $id = '81b18488-b023-4cb0-99e7-b247a4992290';
    $board = [[0, 0, 0], [0, 0, 0], [0, 0, 0]];
    $winner = null;
    $status = Game::STATUS_CREATED;
    $turnsMade = 0;

    $querySingleResult = new GameStateDTO($id, $board, $winner, $status, $turnsMade);

    $this->query->expects($this->any())
      ->method('getSingleResult')
      ->will($this->returnValue($querySingleResult));

    $queryResult[] = new Player('81b18488-b023-4cb0-99e7-b247a4992290', 'Player One');
    $queryResult[] = new Player('2ed58ec5-bd77-4482-a868-ffd4128a4123', 'Player Two');

    $this->query->expects($this->any())
      ->method('getResult')
      ->will($this->returnValue($queryResult));

    $this->em->expects($this->any())
      ->method('createQuery')
      ->will($this->returnValue($this->query));

    $gameState = new GameStateQuery($this->em);
    $result = $gameState('81b18488-b023-4cb0-99e7-b247a4992290');

    $reflectionGameState = new \ReflectionClass(GameStateDTO::class);
    $property = $reflectionGameState->getProperty('players');
    $property->setAccessible(true);
    $property->setValue($querySingleResult, $queryResult);

    $expect = new class{ public $game; };
    $expect->game = $querySingleResult;

    $this->assertEquals(json_encode($expect), json_encode($result));
  }

  /**
   * @expectedException \Lurch\XO\Exception\ObjectDoesNotExistsException
   * @throws \Doctrine\ORM\NoResultException
   * @throws \Doctrine\ORM\NonUniqueResultException
   */
  public function testGameNotExists()
  {
    $this->query->expects($this->any())
      ->method('getSingleResult')
      ->will($this->returnValue(null));

    $this->em->expects($this->any())
      ->method('createQuery')
      ->will($this->returnValue($this->query));

    $gameState = new GameStateQuery($this->em);
    $gameState('81b18488-b023-4cb0-99e7-b247a4992290');
  }

}