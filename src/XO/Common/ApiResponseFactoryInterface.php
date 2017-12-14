<?php

namespace Lurch\XO\Common;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ApiResponseFactoryInterface
{
  public function success(array $data = null): JsonResponse;

  public function error(array $data = null): JsonResponse;
}
