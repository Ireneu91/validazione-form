<?php

namespace App\Tests;

use App\App;
use App\Validation\ContactFormValidator;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ValidazioneTest extends TestCase {

    public function testValidatorName() {
        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
             'data'=>["name"=> " "]
            ]
        );
        $this->assertEquals('Il nome è obbligatorio (min 2 caratteri).', $risultatoValidate['errors']['name']);


        $risultatoValidate = $validator->validate([
             'data'=>["name"=> "i"]
            ]
        );
        $this->assertEquals('Il nome è obbligatorio (min 2 caratteri).', $risultatoValidate['errors']['name']);
    }

    public function testValidatorEmail() {

        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
             'data'=>["email"=> " "]
            ]
        );
        $this->assertEquals('Inserisci una email valida.', $risultatoValidate['errors']['email']);

        $risultatoValidate = $validator->validate([
             'data'=>["email"=> "mail"]
            ]
        );
        $this->assertEquals('Inserisci una email valida.', $risultatoValidate['errors']['email']);
    }

    public function testValidatorMessage() {
        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
             'data'=>["message"=> " "]
            ]
        );
        $this->assertEquals('Il messaggio è obbligatorio (min 10 caratteri).', $risultatoValidate['errors']['message']);

        $risultatoValidate = $validator->validate([
             'data'=>["message"=> "esempio"]
            ]
        );
        $this->assertEquals('Il messaggio è obbligatorio (min 10 caratteri).', $risultatoValidate['errors']['message']);
    }

    public function testOutput() {
        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
                'name'=>"Irene",
                'email'=>"irene@esempio.com",
                'message'=>"Buonasera. Vorrei richiedere maggiori informazioni."
            ]
        );
        $this->assertIsArray($risultatoValidate);

        $this->assertArrayHasKey('name', $risultatoValidate['data']);
        $this->assertArrayHasKey('email', $risultatoValidate['data']);
        $this->assertArrayHasKey('message', $risultatoValidate['data']);

        $this->assertArrayHasKey('errors', $risultatoValidate);
        $this->assertArrayNotHasKey('name', $risultatoValidate['errors']);
        $this->assertArrayNotHasKey('email', $risultatoValidate['errors']);
        $this->assertArrayNotHasKey('message', $risultatoValidate['errors']);
    }

    public function testData() {
        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
                'name'=>"I",
                'email'=>"ireneesempio.com",
                'message'=>"ciao"
            ]
        );
        $this->assertArrayHasKey('name', $risultatoValidate['data']);
        $this->assertArrayHasKey('email', $risultatoValidate['data']);
        $this->assertArrayHasKey('message', $risultatoValidate['data']);
    }

    public function testErrors() {
        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
                'name'=>"I",
                'email'=>"ireneesempio.com",
                'message'=>"ciao"
            ]
        );
        $this->assertArrayHasKey('name', $risultatoValidate['errors']);
        $this->assertArrayHasKey('email', $risultatoValidate['errors']);
        $this->assertArrayHasKey('message', $risultatoValidate['errors']);
    }

    public function testRemoveHtml() {
        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
                'name'=>"<b>Ire</b>",
                'email'=>"<b>irene@esempio.com</b>",
                'message'=>"<i>Buonasera.</i> Vorrei richiedere maggiori informazioni."
            ]
        );
        $this->assertEquals('Ire', $risultatoValidate['data']['name']);
        $this->assertEquals('irene@esempio.com', $risultatoValidate['data']['email']);
        $this->assertEquals('Buonasera. Vorrei richiedere maggiori informazioni.', $risultatoValidate['data']['message']);
    }

    public function testSpaziMultipli() {
        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
                'name'=>"Pinco     Pallo",
                'message'=>"Buonasera.         Vorrei richiedere    maggiori informazioni."
            ]
        );
        $this->assertEquals('Pinco Pallo', $risultatoValidate['data']['name']);
        $this->assertEquals('Buonasera. Vorrei richiedere maggiori informazioni.', $risultatoValidate['data']['message']);
    }

    public function testTrim() {
        $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
                'name'=>" Ire  ",
                'email'=>"  irene@esempio.com ",
                'message'=>"  Buonasera. Vorrei richiedere maggiori informazioni. "
            ]
        );
        $this->assertEquals('Ire', $risultatoValidate['data']['name']);
        $this->assertEquals('irene@esempio.com', $risultatoValidate['data']['email']);
        $this->assertEquals('Buonasera. Vorrei richiedere maggiori informazioni.', $risultatoValidate['data']['message']);
    }

    public function testInputNonStringa() {
         $validator = new ContactFormValidator();

        $risultatoValidate = $validator->validate([
                'name'=>['Irene'],
                'email'=>['esempio@mail.com'],
                'message'=>['Buonasera']
            ]
        );
        $this->assertEquals('Il nome è obbligatorio (min 2 caratteri).', $risultatoValidate['errors']['name']);

        $this->assertEquals('Inserisci una email valida.', $risultatoValidate['errors']['email']);

        $this->assertEquals('Il messaggio è obbligatorio (min 10 caratteri).', $risultatoValidate['errors']['message']);
    }
}