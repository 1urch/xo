<?php

namespace Lurch\XO\Common;

interface JsonMapperInterface
{
  public function map(string $json, object $object): object;
}

