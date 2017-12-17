<?php

namespace Lurch\XO\Command;

use Doctrine\ORM\EntityManager;
use Ramsey\Uuid\UuidFactoryInterface;

use Lurch\XO\Entity\{Game, Player};
use Lurch\XO\Repository\PlayerRepository;
use Lurch\XO\Exception\ObjectDoesNotExistsException;

/**
 * Class CreateGameCommandHandler
 * @package Lurch\XO\Command
 */
class CreateGameCommandHandler
{
  /**
   * @var EntityManager
   */
  private $em;

  /**
   * @var PlayerRepository
   */
  private $playerRepository;

  /**
   * @var UuidFactoryInterface
   */
  private $uuidFactory;

  /**
   * CreateGameCommandHandler constructor.
   * @param EntityManager $em
   */
  public function __construct(EntityManager $em, PlayerRepository $playerRepository, UuidFactoryInterface $uuidFactory)
  {
    $this->em = $em;
    $this->playerRepository = $playerRepository;
    $this->uuidFactory = $uuidFactory;
  }

  /**
   * @param CreateGameCommand $createGameCommand
   * @throws ObjectDoesNotExistsException
   * @throws \Doctrine\ORM\OptimisticLockException
   */
  public function handle(CreateGameCommand $createGameCommand): void
  {
    /** @var Player $player */
    $player = $this->playerRepository->find($createGameCommand->playerId);

    if (is_null($player))
      throw new ObjectDoesNotExistsException('Can not create a game cause player does not exists');

    /** @var Game $game */
    $game = $player->createGame($createGameCommand->id);

    $this->em->persist($game);
    $this->em->flush();
  }
}