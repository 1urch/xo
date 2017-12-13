<?php

namespace Lurch\XO\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Lurch\XO\Repository\PlayerRepository")
 * @ORM\Table(name="")
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
}