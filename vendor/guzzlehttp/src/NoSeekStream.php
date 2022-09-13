<?php

namespace GuzzleHttp\Psr7;
require_once "vendor/guzzlehttp/src/StreamDecoratorTrait.php";
require_once "vendor/psr/src/StreamInterface.php";

use Psr\Http\Message\StreamInterface;

/**
 * Stream decorator that prevents a stream from being seeked
 */
class NoSeekStream implements StreamInterface
{
    use StreamDecoratorTrait;

    public function seek($offset, $whence = SEEK_SET)
    {
        throw new \RuntimeException('Cannot seek a NoSeekStream');
    }

    public function isSeekable()
    {
        return false;
    }
}
