<?php
namespace Lurch\XO\Test\Command;

use Lurch\XO\Exception\ObjectDoesNotExistsException;
use PHPUnit\Framework\TestCase;

use Lurch\XO\Entity\{Player, Game};
use Lurch\XO\Repository\{GameRepositoryInterface, PlayerRepositoryInterface};
use Lurch\XO\Command\{MakeTurnCommand, MakeTurnCommandHandler};

/**
 * Class MakeTurnCommandHandlerTest
 * @package Lurch\XO\Test\Command
 */
class MakeTurnCommandHandlerTest extends TestCase
{

  /**
   * @var PlayerRepositoryInterface
   */
  private $playerRepository;

  /**
   * @var GameRepositoryInterface
   */
  private $gameRepository;

  /**
   * @var Player
   */
  private $playerOne;

  /**
   * @var Player
   */
  private $playerTwo;

  /**
   * @var Game
   */
  private $game;

  /**
   * @var MakeTurnCommand
   */
  private $command;

  public function setUp()
  {
    $this->playerRepository = $this->getMockBuilder('Lurch\XO\Repository\PlayerRepository')
      ->disableOriginalConstructor()
      ->getMock();

    $this->gameRepository = $this->getMockBuilder('Lurch\XO\Repository\GameRepository')
      ->disableOriginalConstructor()
      ->getMock();

    $this->playerOne = new Player('81b18488-b023-4cb0-99e7-b247a4992290', 'Player One');
    $this->playerTwo = new Player('2ed58ec5-bd77-4482-a868-ffd4128a4123', 'Player Two');

    $this->game = $this->playerOne->createGame('b29218e9-2a25-4290-89b4-74bba378d3fa');

    $this->command = new MakeTurnCommand('b29218e9-2a25-4290-89b4-74bba378d3fa', '2ed58ec5-bd77-4482-a868-ffd4128a4123', 1, 1);
  }

  /**
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function testMakeTurnCommandHandleSuccess()
  {
    $this->game->join($this->playerTwo);

    $this->playerRepository->expects($this->any())
      ->method('findById')
      ->will($this->returnValue($this->playerOne));

    $this->gameRepository->expects($this->any())
      ->method('findById')
      ->will($this->returnValue($this->game));

    $handler = new MakeTurnCommandHandler($this->gameRepository, $this->playerRepository);

    $exception = null;
    try {
      $handler->handle($this->command);
    } catch (ObjectDoesNotExistsException $exception) { }

    $this->assertNull($exception);
  }

  /**
   * @expectedException \Lurch\XO\Exception\ObjectDoesNotExistsException
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function testPlayerDoesNotExists()
  {
    $this->playerRepository->expects($this->any())
      ->method('findById')
      ->will($this->returnValue(null));

    $handler = new MakeTurnCommandHandler($this->gameRepository, $this->playerRepository);

    $handler->handle($this->command);
  }

  /**
   * @expectedException \Lurch\XO\Exception\ObjectDoesNotExistsException
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function testGameDoesNotExists()
  {
    $this->playerRepository->expects($this->any())
      ->method('findById')
      ->will($this->returnValue($this->playerOne));

    $this->gameRepository->expects($this->any())
      ->method('findById')
      ->will($this->returnValue(null));

    $handler = new MakeTurnCommandHandler($this->gameRepository, $this->playerRepository);

    $handler->handle($this->command);
  }
}
