<?php
declare(strict_types=1);

namespace App;

use App\Controller\FormController;
use App\Http\Request;
use App\Http\Response;
use App\Validation\ContactFormValidator;

final class App
{
    private FormController $formController;

    public function __construct()
    {
        $this->formController = new FormController(new ContactFormValidator());
    }

    public function handle(Request $request): Response
    {
        $method = $request->method(); // prende il metodo
        $path = $request->path();  // prende il percorso

        if ($method === 'GET' && $path === '/') { // se è in GET e in root
            return $this->formController->showForm($request); //
        }

        if ($method === 'POST' && $path === '/submit') {
            return $this->formController->handleSubmit($request);
        }

        return Response::html('<h1>404 Not Found</h1>', 404);
    }
}
