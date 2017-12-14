<?php

namespace Lurch\XO\Common;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseFactory implements ApiResponseFactoryInterface
{
  public function __construct()
  {
  }

  public function success(array $data = null): JsonResponse
  {
    $data = [
      'status' => 'success',
      'data'   => $data
    ];

    return new JsonResponse($data);
  }

  public function error(array $data = null): JsonResponse
  {
    $data = [
      'status' => 'error',
      'data'   => $data
    ];

    return new JsonResponse($data);
  }

}