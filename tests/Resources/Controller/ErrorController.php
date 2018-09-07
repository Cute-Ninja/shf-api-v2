<?php

namespace App\Tests\Resources\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends Controller
{
    /**
     * @return Response
     */
    public function forbidden(): Response
    {
        return $this->get('shf.response_builder.client_error')->forbidden();
    }

    /**
     * @return Response
     */
    public function unauthorized(): Response
    {
        return $this->get('shf.response_builder.client_error')->unauthorized();
    }

    /**
     * @return Response
     */
    public function notFound(): Response
    {
        return $this->get('shf.response_builder.client_error')->notFound();
    }

    /**
     * @return Response
     */
    public function badRequest(): Response
    {
        return $this->get('shf.response_builder.client_error')->badRequest('Not good');
    }
}