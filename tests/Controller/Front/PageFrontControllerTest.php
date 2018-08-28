<?php

namespace App\Tests\Controller\Front;

use App\Tests\Controller\AbstractPageControllerTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Front\PageFrontController
 */
class PageFrontControllerTest extends AbstractPageControllerTest
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
        $this->client = $this->buildAuthenticatedUser();
        $this->client->request('GET', $url);

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @return array
     */
    public function pagesDataProvider(): array
    {
        return [
            ['/front/dashboard'],
            ['/front/profile'],
            ['/front/workouts'],
        ];
    }
}