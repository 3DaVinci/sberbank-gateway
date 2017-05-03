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

    public function tearDown()
    {
        Mockery::close();
    }

    public function setMockSberbankClient($mockFiles)
    {
        if (!is_array($mockFiles)) {
            $mockFiles = (array) $mockFiles;
        }

        $queue = [];
        foreach ($mockFiles as $mockFile) {
            array_push($queue, $this->buildResponse($mockFile));
        }

        $mock = new MockHandler($queue);

        $handlerStack = HandlerStack::create($mock);
        $guzzleClient = new Client(['handler' => $handlerStack]);

        return new SberbankClient(
            new \Http\Adapter\Guzzle6\Client($guzzleClient)
        );
    }

    private function buildResponse($mockFile)
    {
        $body = '';
        $file = __DIR__.'/Mock/'.$mockFile.'.json';
        if (file_exists($file)) {
            $body = file_get_contents($file);
        }

        return new Response(200, [], $body);
    }
}