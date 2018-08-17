<?php

namespace App\HttpResponse;

use App\Form\Error\ApiFormError;
use FOS\RestBundle\View\View;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

class ClientErrorResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @return Response
     */
    public function forbidden(): Response
    {
        return new Response(null, Response::HTTP_FORBIDDEN);
    }

    /**
     * @return Response
     */
    public function unauthorized(): Response
    {
        return new Response(null, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @return Response
     */
    public function notFound(): Response
    {
        return new Response(null, Response::HTTP_NOT_FOUND);
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    public function badRequest($message): Response
    {
        return new Response($message, Response::HTTP_BAD_REQUEST);
    }

    /**
     * @param FormInterface $form
     *
     * @return Response
     */
    public function jsonResponseFormError(FormInterface $form): Response
    {
        $apiFormError = new ApiFormError();
        $data = $apiFormError->getFormErrorsAsFormattedArray($form);

        return new Response(json_encode($data), Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
