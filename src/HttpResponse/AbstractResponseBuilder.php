<?php

namespace App\HttpResponse;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractResponseBuilder
{
    /**
     * @var ViewHandler
     */
    private $viewHandler;

    /**
     * @param ViewHandler $viewHandler
     */
    public function __construct(ViewHandler $viewHandler)
    {
        $this->viewHandler = $viewHandler;
    }

    /**
     * @param array $data
     * @param array $headers
     *
     * @return Response
     */
    public function ok($data = null, $headers = []): Response
    {
        $code = null === $data || true === empty($data) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK ;

        return $this->handle(View::create($data, $code, $headers));
    }

    /**
     * @param View $view
     *
     * @return Response
     */
    protected function handle(View $view): Response
    {
        return $this->viewHandler->handle($view);
    }

    /**
     * @return SuccessResponseBuilder
     */
    protected function getSuccessResponseBuilder():SuccessResponseBuilder
    {
        return new SuccessResponseBuilder($this->viewHandler);
    }

    /**
     * @return ClientErrorResponseBuilder
     */
    protected function getClientErrorResponseBuilder(): ClientErrorResponseBuilder
    {
        return new ClientErrorResponseBuilder($this->viewHandler);
    }

    /**
     * @return ServerErrorResponseBuilder
     */
    protected function getServerErrorResponseBuilder(): ServerErrorResponseBuilder
    {
        return new ServerErrorResponseBuilder($this->viewHandler);
    }
}
