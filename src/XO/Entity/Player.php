<?php

namespace Lurch\XO\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="Lurch\XO\Repository\PlayerRepository")
 * @ORM\Table(name="xo_player")
 */
class Player
{

  /**
   * @var string
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="NONE")
   * @ORM\Column(type="guid")
   */
  private $id;

  /**
   * @ORM\Column(type="string")
   */
  private $name;

  /**
   * @var Collection|Game[]
   * @ORM\ManyToMany(targetEntity="Lurch\XO\Entity\Game", mappedBy="players")
   */
  private $games;

  /**
   * Player constructor.
   * @param string $name
   */
  public function __construct(string $id, string $name)
  {
    $this->id = $id;
    $this->name = $name;
  }

  /**
   * @return string
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * @return string
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * @return Collection|Game[]
   */
  public function getGames(): Collection
  {
    return $this->games;
  }

  /**
   * @param string $id
   * @return Game
   */
  public function createGame(string $id): Game
  {
    return new Game($id, new Board(), $this);
  }
}