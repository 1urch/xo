<?php

namespace Lurch\XO\Common;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ApiResponseFactoryInterface
{
  public function success(object $data = null): JsonResponse;

  public function error(string $message): JsonResponse;
}
