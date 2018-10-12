<?php

namespace App\Tests\PHPUnit\Controller\Visitor;

use App\Tests\PHPUnit\Controller\AbstractPageControllerTest;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers \App\Controller\Visitor\PageVisitorController
 */
class PageVisitorControllerTest extends AbstractPageControllerTest
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

        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @param string $url
     *
     * @dataProvider pagesDataProvider
     */
    public function testPagesAuthorizedAsUser(string $url): void
    {
        $this->client = $this->buildAuthenticatedUser();
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isRedirect('/front/dashboard'));
    }

    /**
     * @param string $url
     *
     * @dataProvider pagesDataProvider
     */
    public function testPagesAuthorizedAsAdmin(string $url): void
    {
        $this->client = $this->buildAuthenticatedAdmin();
        $this->client->request('GET', $url);

        $this->assertTrue($this->client->getResponse()->isRedirect('/admin/dashboard'));
    }

    /**
     * @return array
     */
    public function pagesDataProvider(): array
    {
        return [
            ['/'],
            ['/login'],
            ['/registration'],
        ];
    }
}