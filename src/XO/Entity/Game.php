<?php

namespace Lurch\XO\Entity;

use Lurch\XO\Entity\Player;

use Ramsey\Uuid\Uuid;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Lurch\XO\Entity\Board;

use Lurch\XO\Exception\NumberOfPlayersException;
use Lurch\XO\Exception\WrongStatusException;
use Lurch\XO\Exception\AlreadyJoinedException;
use Lurch\XO\Exception\ActionDeniedException;

/**
 * @ORM\Entity(repositoryClass="")
 * @ORM\Table(name="")
 */
class Game
{

  const STATUS_CREATED  = 'created';
  const STATUS_PLAYING  = 'playing';
  const STATUS_COMPLETE = 'complete';

  /**
   * @var \Ramsey\Uuid\Uuid
   * @ORM\Column(type="guid")
   */
  private $id;

  /**
   * @var ArrayCollection
   * @ORM\ManyToMany(targetEntity="Lurch\Heights\Entity\Player")
   * @ORM\JoinTable(
   *  name="ht_games_players",
   *  joinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="id")},
   *  inverseJoinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")}
   * )
   */
  private $players;

  /**
   * @var Board;
   * @ORM\OneToOne(targetEntity="Lurch\Heights\Entity\Board")
   * @ORM\JoinColumn(name="board_id", referencedColumnName="id")
   */
  private $board;

  /**
   * @var Player
   * @ORM\Column(nullable=true)
   * @ORM\OneToOne(targetEntity="Lurch\Heights\Entity\Player")
   * @ORM\JoinColumn(name="winner_id", referencedColumnName="id")
   */
  private $winner = null;


  /**
   * @ORM\Column(type="string")
   */
  private $status;

  /**
   * @ORM\Column(type="integer")
   */
  private $turnsMade = 0;

  /**
   * Game constructor.
   *
   */
  public function __construct(string $id, Board $board)
  {
    $this->id = $id;
    $this->board = $board;
    $this->players = new ArrayCollection();
    $this->status = self::STATUS_CREATED;
  }

  /**
   * @param Player $player
   * @throws WrongStatusException
   * @throws NumberOfPlayersException
   * @throws AlreadyJoinedException
   */
  public function join(Player $player): void
  {
    if ($this->status !== self::STATUS_CREATED) {
      throw new WrongStatusException('You can not join the game because it is ' . $this->status);
    }

    if ($this->players->count() === 2) {
      throw new NumberOfPlayersException('No more than two players allowed');
    }

    if ($this->players->contains($player)) {
      throw new AlreadyJoinedException('You are already joined');
    }

    $this->players->add($player);
  }

  /**
   * @throws WrongStatusException
   * @throws NumberOfPlayersException
   */
  public function start(): void
  {
    if ($this->status !== self::STATUS_CREATED) {
      throw new WrongStatusException('You can not start the game because it is ' . $this->status);
    }

    if ($this->players->count() < 2) {
      throw new NumberOfPlayersException('Need at least two players to start');
    }

    $this->status = self::STATUS_PLAYING;
  }

  /**
   * @throws WrongStatusException
   * @throws ActionDeniedException
   * @throws \Lurch\XO\Exception\UnableToSetTileException
   */
  public function turn(Player $player, $x, $y): void
  {
    if ($this->status !== self::STATUS_PLAYING) {
      throw new WrongStatusException('You can not make a turn because the game in "' . $this->status . '" status');
    }

    if ($player !== $this->getCurrentPlayer()) {
      throw new ActionDeniedException('You can not make an action because your turn has not come yet');
    }

    $this->board->setTile($x, $y, $this->getCurrentOffset() +  1);

    if ($this->board->haveCompletedRow()) {
      $this->winner = $player;
      $this->status = self::STATUS_COMPLETE;
    } elseif ($this->board->isBoardFull()) {
      $this->status = self::STATUS_COMPLETE;
    }

    $this->turnsMade++;
  }

  /**
   * @return int
   */
  private function getCurrentOffset(): int
  {
    return $this->turnsMade % $this->players->count();
  }

  /**
   * @return Player
   */
  public function getCurrentPlayer(): Player
  {
    $offset = $this->getCurrentOffset();
    return $this->players->offsetGet($offset);
  }
}