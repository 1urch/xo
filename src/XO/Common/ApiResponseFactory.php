<?php

namespace Lurch\XO\Common;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiResponseFactory
 * @package Lurch\XO\Common
 */
class ApiResponseFactory implements ApiResponseFactoryInterface
{

  /**
   * @param object|null $data
   * @return JsonResponse
   */
  public function success(object $data = null): JsonResponse
  {
    $response = new class { public $status; public $data; };
    $response->status = 'success';
    $response->data = $data;

    return new JsonResponse($response);
  }

  /**
   * @param string $message
   * @return JsonResponse
   */
  public function error(string $message): JsonResponse
  {
    $response = new class { public $status; public $message; };
    $response->status = 'error';
    $response->message = $message;

    return new JsonResponse($response);
  }

}