<?php

namespace App\Controller\Api\User;

use App\Controller\Api\AbstractApiController;
use App\Controller\Api\StandardApiInterface;
use App\Entity\User\User;
use App\Form\Type\User\UserBodyMeasurementType;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserBodyMeasurementApiController extends AbstractApiController
{
    /**
     * @var Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserBodyMeasurement")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $username
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserBodyMeasurement")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, string $username): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserBodyMeasurement")
     * @Security(name="Bearer")
     */
    public function post(Request $request): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $username
     *
     * @return Response
     *
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="Body measurement update parameters",
     *     @Model(type=UserBodyMeasurementType::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="The body measurements have been successfully updated and the User returned",
     *     @Model(type=User::class, groups={"default"})
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No username was matching an existing User"
     * )
     * @SWG\Response(
     *     response=422,
     *     description="Error in the form you are submitted (details in Response body).",
     * )
     *
     * @SWG\Tag(name="UserBodyMeasurement")
     * @Security(name="Bearer")
     */
    public function put(Request $request, string $username): Response
    {
        $user = $this->getUserRepository()->findOneByCriteria(['username' => $username]);
        if (null === $user) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        if (false === $this->getUser()->hasRole('ROLE_ADMIN_USER_WRITE') && $this->getUser()->getId() !== $user->getId()) {
            return $this->getClientErrorResponseBuilder()->forbidden();
        }

        $form = $this->createForm(
            UserBodyMeasurementType::class,
            $user->getBodyMeasurement(),
            ['method' => 'PUT']
        );

        $form->handleRequest($request);

        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $this->getClientErrorResponseBuilder()->jsonResponseFormError($form);
        }

        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $user->getBodyMeasurement(),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @var Request $request
     * @var string  $username
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserBodyMeasurement")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, string $username): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }
}