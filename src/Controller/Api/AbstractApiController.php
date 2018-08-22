<?php

namespace App\Controller\Api;

use App\Controller\AbstractBaseController;
use App\HttpResponse\ClientErrorResponseBuilder;
use App\HttpResponse\ServerErrorResponseBuilder;
use App\HttpResponse\SuccessResponseBuilder;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractApiController extends AbstractBaseController
{
    /**
     * @return SuccessResponseBuilder
     */
    protected function getSuccessResponseBuilder(): SuccessResponseBuilder
    {
        return $this->container->get('shf.response_builder.success');
    }
    /**
     * @return ClientErrorResponseBuilder
     */
    protected function getClientErrorResponseBuilder(): ClientErrorResponseBuilder
    {
        return $this->container->get('shf.response_builder.client_error');
    }
    /**
     * @return ServerErrorResponseBuilder
     */
    protected function getServerErrorResponseBuilder(): ServerErrorResponseBuilder
    {
        return $this->container->get('shf.response_builder.server_error');
    }

    /**
     * @param Request $request
     * @param array   $proxyGroups
     *
     * @return string
     */
    protected function buildProxySerializationGroups(Request $request, array $proxyGroups = []): string
    {
        $queryGroups = $request->get('groups');
        $proxyGroupsAsString = implode(',', $proxyGroups);
        if (null === $queryGroups) {
            return $proxyGroupsAsString;
        }

        return $queryGroups . ',' . $proxyGroupsAsString;
    }
}
