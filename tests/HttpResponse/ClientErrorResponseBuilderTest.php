<?php

namespace App\Tests\HttpResponse;

use App\HttpResponse\ClientErrorResponseBuilder;
use App\Tests\Resources\Form\TestFormType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @covers App\HttpResponse\ClientErrorResponseBuilder
 */
class ClientErrorResponseBuilderTest extends WebTestCase
{
    /**
     * @var ClientErrorResponseBuilder
     */
    protected $responseBuilder;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        self::$container = $kernel->getContainer();

        $this->responseBuilder = self::$container->get('shf.response_builder.client_error');
    }

    public function testForbidden(): void
    {
        $response = $this->responseBuilder->forbidden();

        $this->assertEquals(Response::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testUnauthorized(): void
    {
        $response = $this->responseBuilder->unauthorized();

        $this->assertEquals(Response::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }


    public function testNotFound(): void
    {
        $response = $this->responseBuilder->notFound();

        $this->assertEquals(Response::HTTP_NOT_FOUND, $response->getStatusCode());
        $this->assertEmpty($response->getContent());
    }

    public function testBadRequest(): void
    {
        $message  = 'request is not formed correctly';
        $response = $this->responseBuilder->badRequest($message);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
        $this->assertEquals($message, $response->getContent());
    }

    public function testJsonResponseFormError(): void
    {
        /** @var FormInterface $form */
        $form = static::$container->get('form.factory')->create(TestFormType::class);

        $form->addError(new FormError('error global 1'));
        $form->addError(new FormError('error global 2'));
        $form->get('field_1')->addError(new FormError('error field 1'));
        $form->get('field_2')->addError(new FormError('error field 2'));

        $response = $this->responseBuilder->jsonResponseFormError($form);

        $expected = [
            'global' => ['error global 1', 'error global 2'],
            'field_1' => ['error field 1'],
            'field_2' => ['error field 2']
        ];
        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->getStatusCode());
        $this->assertEquals(json_encode($expected), $response->getContent());
    }
}