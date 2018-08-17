<?php

namespace App\Tests\Form\Error;

use App\Form\Error\ApiFormError;
use App\Tests\Resources\Form\TestFormType;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;

/**
 * @covers App\Form\Error\ApiFormError
 */
class ApiFormErrorTest extends WebTestCase
{
    public function setUp()
    {
        parent::setUp();

        static::bootKernel();
    }

    public function testGetForErrorAsFormattedArray(): void
    {
        /** @var FormInterface $form */
        $form = static::$container->get('form.factory')->create(TestFormType::class);

        $form->addError(new FormError('error global 1'));
        $form->addError(new FormError('error global 2'));
        $form->get('field_1')->addError(new FormError('error field 1'));
        $form->get('field_2')->addError(new FormError('error field 2'));

        $apiFormError = new ApiFormError();
        $errors = $apiFormError->getFormErrorsAsFormattedArray($form);

        $expected = [
            'global' => ['error global 1', 'error global 2'],
            'field_1' => ['error field 1'],
            'field_2' => ['error field 2']
        ];
        $this->assertEquals($expected, $errors);
    }
}