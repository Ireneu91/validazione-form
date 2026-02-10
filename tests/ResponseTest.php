<?php

namespace App\Tests;

use App\App;
use App\Http\Response;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase {

    public function testResponseHtml() {
        $html = "ciao";
        $response = Response::html($html);
        // se il costruttore è privato non posso fare new e quindi uso la funzione statica creata per poterlo costruire

        $this->assertEquals(['Content-Type' => 'text/html; charset=UTF-8'], $response->headers());
    }
}