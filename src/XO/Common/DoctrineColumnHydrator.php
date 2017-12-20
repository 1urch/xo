<?php

namespace Lurch\XO\Common;

use Doctrine\ORM\Internal\Hydration\AbstractHydrator;

class DoctrineColumnHydrator extends AbstractHydrator
{
  public function hydrateAllData()
  {
    return $this->_stmt->fetchAll(\PDO::FETCH_COLUMN);
  }
}