<?php
namespace Lurch\XO\Test\Query;

use PHPUnit\Framework\TestCase;
use Lurch\XO\Query\AvailableGamesQuery;

class AvailableGamesQueryTest extends TestCase
{

  public function testQueryInvokeSuccess()
  {
    $em = $this->getMockBuilder('Doctrine\ORM\EntityManager')
      ->disableOriginalConstructor()
      ->getMock();

    $query = $this->getMockBuilder('Doctrine\ORM\AbstractQuery')
      ->disableOriginalConstructor()
      ->getMock();

    $queryResult = [['id' => 'success']];

    $query->expects($this->any())
      ->method('getArrayResult')
      ->will($this->returnValue($queryResult));

    $em->expects($this->any())
      ->method('createQuery')
      ->will($this->returnValue($query));

    $gamesList = new AvailableGamesQuery($em);
    $result = $gamesList();

    $expect = new class{ public $games; };
    $expect->games = $queryResult;

    $this->assertEquals(json_encode($expect), json_encode($result));
  }

}