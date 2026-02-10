<?php

namespace App\Tests;

use App\App;
use App\Http\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestParsingTest extends TestCase {

    public function testMethod() {
        $request = new Request(
            [],
            [],
            ['REQUEST_METHOD'=>'GET']
         );
        $this->assertEquals('GET', $request->method());

        $request = new Request(
            [],
            [],
            ['REQUEST_METHOD'=>'post']
        );
        $this->assertEquals('POST', $request->method());

        $request = new Request(
            [],
            [],
            []
         );
        $this->assertEquals('GET', $request->method());
    }

    public function testPath() {
        $request = new Request(
            [],
            [],
            ['REQUEST_URI'=>'/submit?x=1']
         );
         $this->assertEquals('/submit', $request->path());

         $request = new Request(
            [],
            [],
            ['REQUEST_URI'=>0]
         );
         $this->assertEquals('/', $request->path());
    }

    public function testPost() {
        $request = new Request(
            [],
            [
                'name' => 'Irene',
                'email' => 'esempio@esempio.com',
                'message' => 'Buongiorno. Vorrei richiedere informazioni.'
            ],
            ['REQUEST_URI'=>'/submit','REQUEST_METHOD'=>'POST']
        );
        $this->assertEquals([
                'name' => 'Irene',
                'email' => 'esempio@esempio.com',
                'message' => 'Buongiorno. Vorrei richiedere informazioni.'
            ],
            $request->post());
    }

}