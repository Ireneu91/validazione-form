<?php

declare(strict_types=1);

namespace App;

use App\Controller\FormController;
use App\Http\Request;
use App\Http\Response;
use App\Validation\ContactFormValidator;

final class App
{
    // proprietà di tipo FormController
    private FormController $formController;

    public function __construct()
    {
        // Pattern MVC
        $this->formController = new FormController(new ContactFormValidator()); // i dati prima devono essere validati (se sono del campo corretto ad es.), poi controllati
    }

    public function handle(Request $request): Response
    {
        $method = $request->method(); // prende il metodo
        $path = $request->path();  // prende il percorso

        if ($method === 'GET' && $path === '/') { // se è in GET e in root
            return $this->formController->showForm($request); // fai vedere il form
        }

        if ($method === 'POST' && $path === '/submit') { // se stai mandando dei dati
            return $this->formController->handleSubmit($request); // gestisci il submit
        }

        return Response::html('<h1>404 Not Found</h1>', 404);
    }
}
