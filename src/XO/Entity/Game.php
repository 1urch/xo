<?php

namespace Lurch\XO\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Lurch\XO\Exception\{WrongStatusException, AlreadyJoinedException, ActionDeniedException, UnableToSetTileException};
/**
 * @ORM\Entity(repositoryClass="Lurch\XO\Repository\GameRepository")
 * @ORM\Table(name="xo_game")
 */
class Game
{

  const STATUS_CREATED  = 'created';
  const STATUS_PLAYING  = 'playing';
  const STATUS_COMPLETE = 'complete';

  /**
   * @var string
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="NONE")
   * @ORM\Column(type="guid")
   */
  private $id;

  /**
   * @var ArrayCollection
   * @ORM\ManyToMany(targetEntity="Lurch\XO\Entity\Player")
   * @ORM\JoinTable(
   *  name="xo_games_players",
   *  joinColumns={@ORM\JoinColumn(name="game_id", referencedColumnName="id")},
   *  inverseJoinColumns={@ORM\JoinColumn(name="player_id", referencedColumnName="id")}
   * )
   */
  private $players;

  /**
   * @var Board;
   * @ORM\Embedded(class="Board", columnPrefix=false)
   */
  private $board;

  /**
   * @var Player
   * @ORM\Column(name="winner_id", nullable=true)
   * @ORM\OneToOne(targetEntity="Lurch\XO\Entity\Player")
   * @ORM\JoinColumn(name="winner_id", referencedColumnName="id")
   */
  private $winner = null;


  /**
   * @ORM\Column(type="string")
   */
  private $status;

  /**
   * @ORM\Column(name="turns", type="integer")
   */
  private $turnsMade = 0;

  /**
   * Game constructor.
   * @param string $id
   * @param Board $board
   * @param Player $player
   */
  public function __construct(string $id, Board $board, Player $player)
  {
    $this->id = $id;
    $this->board = $board;
    $this->players = new ArrayCollection();
    $this->status = self::STATUS_CREATED;
    $this->players->add($player);
  }

  /**
   * @param Player $player
   * @throws WrongStatusException
   * @throws AlreadyJoinedException
   */
  public function join(Player $player): void
  {
    if ($this->status !== self::STATUS_CREATED) {
      throw new WrongStatusException('Joining denied because the game is in a "' . $this->status . '" status');
    }

    if ($this->players->contains($player)) {
      throw new AlreadyJoinedException('Joining denied. You have already joined');
    }

    $this->players->add($player);
    $this->status = self::STATUS_PLAYING;
  }

  /**
   * @throws WrongStatusException
   * @throws ActionDeniedException
   * @throws UnableToSetTileException
   */
  public function turn(Player $player, $x, $y): void
  {
    if ($this->status !== self::STATUS_PLAYING) {
      throw new WrongStatusException('You can not make a turn because the game is in a "' . $this->status . '" status');
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