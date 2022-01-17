<?php
/**
 * Author: Andrey Morozov
 * Email: andrey@3davinci.ru
 * Date: 02.05.2017
 */

namespace Sberbank\Tests;

use PHPUnit\Framework\TestCase;
use Mockery;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use Sberbank\Http\Client as SberbankClient;

class SberbankTestCase extends TestCase
{

    public function tearDown() : void
    {
        Mockery::close();
    }

    public function setMockSberbankClient($mockFiles): SberbankClient
    {
        if (!is_array($mockFiles)) {
            $mockFiles = (array) $mockFiles;
        }

        $queue = [];
        foreach ($mockFiles as $mockFile) {
            $queue[] = $this->buildResponse($mockFile);
        }

        $mock = new MockHandler($queue);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handlerStack]);

        return new SberbankClient(
            new \Http\Adapter\Guzzle6\Client($guzzleClient)
        );
    }

    /**
     * @return Mockery\MockInterface
     */
    protected function getMockRequest(): Mockery\MockInterface
    {
        return Mockery::mock('\Sberbank\Message\RequestInterface');
    }

    /**
     * @param string $mockFile
     * @return string
     */
    protected function getMockContent(string $mockFile): string
    {
        $body = '';
        $file = __DIR__.'/Mock/'.$mockFile.'.json';
        if (file_exists($file)) {
            $body = file_get_contents($file);
        }

        return $body;
    }

    /**
     * @param string $mockFile
     * @return array|mixed
     */
    protected function getMockAsArray(string $mockFile)
    {
        $json = $this->getMockContent($mockFile);

        return $json ? json_decode($json, true) : [];
    }

    /**
     * @param string $mockFile
     * @return Response
     */
    private function buildResponse(string $mockFile): Response
    {
        return new Response(200, [], $this->getMockContent($mockFile));
    }
}