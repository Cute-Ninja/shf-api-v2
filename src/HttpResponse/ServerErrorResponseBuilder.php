<?php

namespace App\HttpResponse;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

class ServerErrorResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @param \Exception $e
     *
     * @return Response
     */
    public function exception(\Exception $e): Response
    {
        $code    = $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $e->getMessage() ?: null;

        return $this->handle(View::create(['message' => $message], $code, []));
    }

    /**
     * @return Response
     */
    public function notImplemented(): Response
    {
        return $this->handle(View::create(null, Response::HTTP_NOT_IMPLEMENTED, []));
    }
}
