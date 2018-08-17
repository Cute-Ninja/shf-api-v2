<?php

namespace App\HttpResponse;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ServerErrorResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @param \Exception $e
     *
     * @return Response
     */
    public function exception(\Exception $e)
    {
        $code    = $e->getCode() ?: Response::HTTP_INTERNAL_SERVER_ERROR;
        $message = $e->getMessage() ?: null;

        return new Response($message, $code);
    }

    /**
     * @return Response
     */
    public function notImplemented()
    {
        return new Response(null, Response::HTTP_NOT_IMPLEMENTED);
    }
}
