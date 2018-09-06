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
        return $this->handle(View::create(null, Response::HTTP_FORBIDDEN, []));
    }

    /**
     * @return Response
     */
    public function unauthorized(): Response
    {
        return $this->handle(View::create(null, Response::HTTP_UNAUTHORIZED, []));
    }

    /**
     * @return Response
     */
    public function notFound(): Response
    {
        return $this->handle(View::create(null, Response::HTTP_NOT_FOUND, []));
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    public function badRequest($message): Response
    {
        return $this->handle(View::create(['message' => $message], Response::HTTP_BAD_REQUEST, []));
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

        return $this->handle(View::create($data, Response::HTTP_UNPROCESSABLE_ENTITY, []));
    }
}
