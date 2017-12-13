<?php

namespace Lurch\XO\Common;

use Lurch\XO\Exception\MapperException;

/**
 * Class JsonMapperFacade
 * @package Lurch\XO\Common
 */
class JsonMapperFacade implements JsonMapperInterface
{
  /**
   * @var \JsonMapper
   */
  private $mapper;

  /**
   * JsonMapperFacade constructor.
   */
  public function __construct()
  {
    $this->mapper = new \JsonMapper();
  }

  /**
   * @param string $json
   * @param object $object
   * @return object
   * @throws MapperException
   */
  public function map(string $json, object $object): object
  {
    $json = json_decode($json);
    if ($json === false || is_null($json)) throw new MapperException('Json error: ' . json_last_error_msg());

    try {
      $mappedObject = $this->mapper->map($json, $object);
    } catch (\Exception $e) {
      throw new MapperException($e->getMessage());
    }

    return $mappedObject;
  }
}

