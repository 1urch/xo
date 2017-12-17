<?php

namespace Lurch\XO\Common;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponseFactory implements ApiResponseFactoryInterface
{
  public function __construct()
  {
  }

  public function success(object $data = null): JsonResponse
  {
    $data = [
      'status' => 'success',
      'data'   => $data
    ];

    return new JsonResponse($data);
  }

  public function error(string $message): JsonResponse
  {
    $data = [
      'status'  => 'error',
      'message' => $message
    ];

    return new JsonResponse($data);
  }

}