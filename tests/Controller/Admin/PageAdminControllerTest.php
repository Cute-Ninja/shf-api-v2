<?php

namespace App\Tests\Controller\Admin;

use App\Tests\Controller\AbstractPageControllerTest;
use Symfony\Component\HttpFoundation\Response;

class PageAdminControllerTest extends AbstractPageControllerTest
{
    /**
     * @param string $url
     *
     * @dataProvider pagesDataProvider
     */
    public function testPagesUnauthorized(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     *
     * @dataProvider pagesDataProvider
     */
    public function testPagesAuthorized(string $url): void
    {
        $client = $this->buildAuthenticatedAdmin();
        $client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function pagesDataProvider(): array
    {
        return [
            ['/admin/dashboard'],
            ['/admin/user'],
        ];
    }
}