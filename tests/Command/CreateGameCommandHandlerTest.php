<?php
namespace Lurch\XO\Test\Command;

use PHPUnit\Framework\TestCase;

use Lurch\XO\Entity\Player;
use Lurch\XO\Repository\{GameRepositoryInterface, PlayerRepositoryInterface};
use Lurch\XO\Command\{CreateGameCommand, CreateGameCommandHandler};
use Lurch\XO\Exception\ObjectDoesNotExistsException;

/**
 * Class CreateGameCommandHandlerTest
 * @package Lurch\XO\Test\Command
 */
class CreateGameCommandHandlerTest extends TestCase
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
   * @var CreateGameCommand
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
    $this->command = new CreateGameCommand('b29218e9-2a25-4290-89b4-74bba378d3fa', '81b18488-b023-4cb0-99e7-b247a4992290');
  }

  /**
   * @doesNotPerformAssertions
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function testCreateGameCommandHandleSuccess()
  {
    $this->playerRepository->expects($this->any())
      ->method('findById')
      ->will($this->returnValue($this->playerOne));

    $handler = new CreateGameCommandHandler($this->gameRepository, $this->playerRepository);

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

    $handler = new CreateGameCommandHandler($this->gameRepository, $this->playerRepository);

    $handler->handle($this->command);
  }
}
