<?php

namespace App\Controller;

use App\Entity\User\User;
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
        $groups = $this->buildProxySerializationGroups($request, $extraParams['groups'] ?? []);

        $params = array_merge($extraParams, $request->query->all());
        $params['groups'] = $groups;

        $user = $this->getUser();
        if ($user instanceof User) {
            $params = $this->addAdminParams($user, $params);
            $params = $this->addUserParams($user, $params);
        }

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

    /**
     * @param User  $user
     * @param array $params
     *
     * @return array
     */
    private function addAdminParams(User $user, array $params): array
    {
        if (true === $user->isAdmin()) {
            $params['groups'] = $params['groups'] . ',' . 'admin';
        }

        return $params;
    }

    /**
     * @param User  $user
     * @param array $params
     *
     * @return array
     */
    private function addUserParams(User $user, array $params): array
    {
        if (false === $user->isAdmin()) {
            $params['user'] = $this->getUser()->getId();
        }

        return $params;
    }
}