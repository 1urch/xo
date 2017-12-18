<?php

namespace Lurch\XO\Test\Common;

use PHPUnit\Framework\TestCase;

use Lurch\XO\Common\ApiResponseFactory;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ApiResponseFactoryTest
 * @package Lurch\XO\Test\Common
 */
class ApiResponseFactoryTest extends TestCase
{
  /**
   * @var ApiResponseFactory
   */
  private $factory;

  public function setUp()
  {
    $this->factory = new ApiResponseFactory();
  }

  public function testSuccessMethod()
  {
    $expect = '{"status":"success","data":{"test":"success"}}';

    $data = new class { public $test; };
    $data->test = 'success';

    /** @var JsonResponse $response */
    $response = $this->factory->success($data);
    $this->assertEquals($expect, $response->getContent());
  }

  public function testErrorMethod()
  {
    $message = 'error';
    $expect = '{"status":"error","message":"' . $message . '"}';

    /** @var JsonResponse $response */
    $response = $this->factory->error($message);
    $this->assertEquals($expect, $response->getContent());
  }
}
