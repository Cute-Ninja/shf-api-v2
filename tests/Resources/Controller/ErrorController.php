<?php

namespace App\Tests\Resources\Controller;

use App\Tests\Resources\Form\TestFormType;
use Doctrine\Common\Annotations\AnnotationException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends Controller
{
    /**
     * @return Response
     */
    public function forbidden(): Response
    {
        return $this->get('shf.response_builder.client_error')->forbidden();
    }

    /**
     * @return Response
     */
    public function unauthorized(): Response
    {
        return $this->get('shf.response_builder.client_error')->unauthorized();
    }

    /**
     * @return Response
     */
    public function notFound(): Response
    {
        return $this->get('shf.response_builder.client_error')->notFound();
    }

    /**
     * @return Response
     */
    public function badRequest(): Response
    {
        return $this->get('shf.response_builder.client_error')->badRequest('Not good');
    }

    /**
     * @return Response
     */
    public function formError(): Response
    {
        $form = $this->createForm(TestFormType::class);

        $form->addError(new FormError('global error 1'));
        $form->addError(new FormError('global error 2'));
        $form->get('field_1')->addError(new FormError('field_1 error 1'));

        return $this->get('shf.response_builder.client_error')->jsonResponseFormError($form);
    }

    /**
     * @param null|string $name
     *
     * @return Response
     */
    public function exception(?string $name = null): Response
    {
        $exception = new \Exception('global exception');
        if ('annotation' === $name) { // Used in SuccessResponseBuilder
            $exception = new AnnotationException();
        }

        return $this->get('shf.response_builder.server_error')->exception($exception);
    }

    /**
     * @return Response
     */
    public function notImplemented(): Response
    {
        return $this->get('shf.response_builder.server_error')->notImplemented();
    }
}