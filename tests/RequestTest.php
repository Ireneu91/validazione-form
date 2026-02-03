<?php

namespace App\Tests;

use App\Http\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {

    public function __construct(
        private readonly array $query,
        private readonly array $post,
        private readonly array $server
    ) {}


    $_REQUEST = new Request([$_GET => [] , $_POST=>[], $_SERVER=>[]]);



    request::fromGlobals

}