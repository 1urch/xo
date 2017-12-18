<?php

namespace Lurch\XO\Common;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Interface ApiResponseFactoryInterface
 * @package Lurch\XO\Common
 */
interface ApiResponseFactoryInterface
{
  /**
   * @param object|null $data
   * @return JsonResponse
   */
  public function success(object $data = null): JsonResponse;

  /**
   * @param string $message
   * @return JsonResponse
   */
  public function error(string $message): JsonResponse;
}
