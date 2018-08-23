<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractProxyController extends Controller
{
    /**
     * @param Request $request
     * @param string  $controller
     * @param array   $path
     * @param array   $extraParams
     *
     * @return Response
     */
    protected function forwardToApi(Request $request, string $controller, array $path = [], array $extraParams = []): Response
    {
        $groups = $this->buildProxySerializationGroups($request, isset($extraParams['groups']) ? $extraParams['groups'] : []);

        $params = array_merge($extraParams, $request->query->all());
        $params['groups'] = $groups;
        $params['user']   = $this->getUser()->getId();

        return $this->forward(
            $controller,
            $path,
            $params
        );
    }

    /**
     * @param Request $request
     * @param array   $proxyGroups
     *
     * @return string
     */
    private function buildProxySerializationGroups(Request $request, array $proxyGroups = []): string
    {
        $queryGroups = $request->get('groups');
        $proxyGroupsAsString = implode(',', $proxyGroups);
        if (null === $queryGroups) {
            return $proxyGroupsAsString;
        }

        return $queryGroups . ',' . $proxyGroupsAsString;
    }
}