<?php

namespace App\Tests\Resources\Controller;

use Doctrine\Common\Annotations\AnnotationException;
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

    /**
     * @param null|string $name
     *
     * @return Response
     */
    public function exception(?string $name = null): Response
    {
        $exception = new \Exception('global exception');
        if ('annotation' === $name) { // Used in SuccessResponseBuilder
            $exception = new AnnotationException();
        }

        return $this->get('shf.response_builder.server_error')->exception($exception);
    }

    /**
     * @return Response
     */
    public function notImplemented(): Response
    {
        return $this->get('shf.response_builder.server_error')->notImplemented();
    }
}