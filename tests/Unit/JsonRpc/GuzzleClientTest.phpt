<?php

namespace LetsAgree\GethJsonRpcPhpClient\Tests\Unit\JsonRpc;

require_once __DIR__ . '/../../bootstrap.php';

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\RequestException;
use LetsAgree\GethJsonRpcPhpClient\JsonRpc\GuzzleClient;
use LetsAgree\GethJsonRpcPhpClient\JsonRpc\GuzzleClientFactory;
use Mockery;
use Mockery\MockInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Tester\Environment;
use Tester\TestCase;



class GuzzleClientTest extends TestCase
{

	public function testGuzzlePost()
	{
		$factory = $this->mockFactory('{}');
		$guzzle = new GuzzleClient($factory, 'localhost', 12345);
		$guzzle->post('{}');

		Environment::$checkAssertions = FALSE;
	}



	/**
	 * @throws \LetsAgree\GethJsonRpcPhpClient\JsonRpc\RequestFailedException
	 */
	public function testGuzzleFail()
	{
		$factory = $this->mockFactoryFailRequest();
		$guzzle = new GuzzleClient($factory, 'localhost', 12345);
		$guzzle->post('{}');

		Environment::$checkAssertions = FALSE;
	}



	/**
	 * @return GuzzleClientFactory|MockInterface
	 */
	private function mockFactoryFailRequest()
	{
		return Mockery::mock(GuzzleClientFactory::class)
			->shouldReceive('create')->andReturnUsing(
				function () {
					throw Mockery::mock(RequestException::class);
				}
			)->getMock();
	}



	/**
	 * @param string $result
	 * @return GuzzleClientFactory|MockInterface
	 */
	private function mockFactory($result)
	{
		return Mockery::mock(GuzzleClientFactory::class)
			->shouldReceive('create')->andReturn($this->mockGuzzleClient($result))->getMock();
	}



	/**
	 * @param string $result
	 * @return GuzzleHttpClient|MockInterface
	 */
	private function mockGuzzleClient($result)
	{
		return Mockery::mock(GuzzleHttpClient::class)
			->shouldReceive('post')->andReturn(
				Mockery::mock(ResponseInterface::class)
					->shouldReceive('getBody')->andReturn(
						Mockery::mock(StreamInterface::class)
							->shouldReceive('getContents')->andReturn($result)->getMock()
					)->getMock()
			)->getMock();
	}

}



(new GuzzleClientTest())->run();