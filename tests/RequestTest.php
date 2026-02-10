<?php

namespace App\Tests;

use App\App;
use App\Http\Request;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase {

    public function testGet(): void {
        $app = new App();
        $request = new Request(
            // ---- se stampo su index un var_damp di $_GET, $_POST e $_SERVER vedrò che: ----//
            [], // il primo è vuoto
            [], // il secondo pure
            ['REQUEST_URI'=>'/','REQUEST_METHOD'=>'GET'] // il terzo contiene tanti array associativi, ma ci interessano questi
        );

        $response = $app->handle($request);
        $controllo = $response->status();

        $this->assertSame(200, $controllo);

        $body= $response->body();
        $parola = "<form";
        $this->assertStringContainsString($parola, $body);
    }

    // POST /submit Deve invocare “handleSubmit” (verifica indiretta: dipende dai dati).
    public function testPost(): void {
        $app = new App();
        $request = new Request(
            [],
            [
                'name' => 'Irene',
                'email' => 'esempio@esempio.com',
                'message' => 'Buongiorno. Vorrei richiedere informazioni.'
            ],
            ['REQUEST_URI'=>'/submit','REQUEST_METHOD'=>'POST']
        );

        $response = $app->handle($request);
        $controllo = $response->status();
        $this->assertSame(200, $controllo);

        $body= $response->body();

        // se risponde grazie
        $successo = "Successo";
        $this->assertStringContainsString($successo, $body);

        $request = new Request(
            [],
            [
                'name' => 'Irene',
                'email' => 'esempioesempio.com',
                'message' => 'Buongiorno. Vorrei richiedere informazioni.'
            ],
            ['REQUEST_URI'=>'/submit','REQUEST_METHOD'=>'POST']
        );
        $response = $app->handle($request);
        $body= $response->body();

        // se ci sono errori
        $errore = "errori";
        $this->assertStringContainsString($errore, $body);
    }

    //Qualsiasi altra rotta (es. GET /nope)
    // Deve restituire 404.
    // Body deve contenere un marker (es. 404 Not Found).
    public function testAltraRotta() {
        $app = new App();
        $request = new Request(
            [],
            [],
            ['REQUEST_URI'=>'/submitto','REQUEST_METHOD'=>'GET']
        );

        $response = $app->handle($request);
        $body= $response->body();
        $notFound = "404";
        $this->assertStringContainsString($notFound, $body);
    }

    public function testPath() {
        $app = new App();
        $request = new Request(
            [],
            [],
            ['REQUEST_URI'=>'/??x=1','REQUEST_METHOD'=>'GET']
        );
        
        $this->assertEquals('/', $request->path());
    }
}