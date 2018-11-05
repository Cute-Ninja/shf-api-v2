<?php

namespace App\Tests\PHPunit\Controller\Admin;

use App\Tests\PHPUnit\Controller\AbstractPageControllerTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Admin\PageAdminController
 */
class PageAdminControllerTest extends AbstractPageControllerTest
{
    /**
     * @param string $url
     *
     * @dataProvider pagesDataProvider
     */
    public function testPagesUnauthorized(string $url): void
    {
        $this->client = static::createClient();
        $this->client->request('GET', $url);

        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     *
     * @dataProvider pagesDataProvider
     */
    public function testPagesAuthorized(string $url): void
    {
        $this->buildAuthenticatedAdmin();
        $this->client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function pagesDataProvider(): array
    {
        return [
            ['/admin/dashboard'],
            ['/admin/users'],
            ['/admin/workouts'],
        ];
    }
}