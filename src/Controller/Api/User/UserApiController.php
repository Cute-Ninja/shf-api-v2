<?php

namespace App\Controller\Api\User;

use App\Controller\Api\AbstractApiController;
use App\Entity\User\User;
use App\Form\Type\User\UserType;
use App\Utils\SecurityUtils;
use App\Utils\StringUtils;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserApiController extends AbstractApiController
{
    /**
     * @param Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list Users",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=User::class, groups={"default"}))
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="No Users found for the search parameters used"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
    {
        $builder = $this->getUserRepository()
                        ->findManyByCriteriaBuilder(
                            [
                                'username' => $request->get('username'),
                                'isAdmin'  => false
                            ]
                        );

        return $this->getSuccessResponseBuilder()->buildMultiObjectResponse(
            $this->paginate($builder, $request),
            $request,
            $this->getRouter(),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @param Request $request
     * @param string  $username
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the details of an User",
     *     @Model(type=User::class, groups={"default"})
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No username was matching an existing User"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, string $username): Response
    {
        $user = $this->getUserRepository()
                     ->findOneByCriteria(
                         ['username' => $username],
                         ['userBodyMeasurement']
                     );

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $user,
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @param Request                      $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     *
     * @return Response
     *
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="User creation parameters",
     *     @Model(type=UserType::class)
     * )
     * @SWG\Response(
     *     response=200,
     *     description="The User has been successfully created and returned",
     *     @Model(type=User::class, groups={"default"})
     * )
     * @SWG\Response(
     *     response=422,
     *     description="Error in the form you are submitted (details in Response body).",
     * )
     * @SWG\Tag(name="User")
     */
    public function post(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        if (null !== $request->headers->get('Authorization')) {
            return $this->getClientErrorResponseBuilder()->forbidden();
        }

        $user = new User();
        $form = $this->createForm(
            UserType::class,
            $user,
            ['method' => 'POST', 'context' => UserType::CONTEXT_CREATE, 'validation_groups' => 'registration']
        );

        $form->handleRequest($request);
        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $this->getClientErrorResponseBuilder()->jsonResponseFormError($form);
        }

        $user->setPassword($passwordEncoder->encodePassword($user, $user->getPassword()));
        $user->setConfirmationKey(SecurityUtils::randomString(15));

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->created($user, $this->getSerializationGroup($request));
    }

    /**
     * @param Request $request
     * @param string  $username
     *
     * @return Response
     *
     * @SWG\Parameter(
     *     name="form",
     *     in="body",
     *     description="User update parameters",
     *     @Model(type=UserType::class)
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="The User has been successfully updated and returned",
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
     * @SWG\Tag(name="User")
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
            UserType::class,
            $user,
            ['method' => 'PUT', 'context' => UserType::CONTEXT_EDIT]
        );

        $form->handleRequest($request);

        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $this->getClientErrorResponseBuilder()->jsonResponseFormError($form);
        }

        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $user,
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @param string $username
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=204,
     *     description="The User has been deleted successfully"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed to delete this User"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No username was matching an existing User"
     * )
     * @SWG\Tag(name="User")
     * @Security(name="Bearer")
     */
    public function delete(string $username): Response
    {
        $user = $this->getUserRepository()->findOneByCriteria(['username' => $username]);
        if (null === $user) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        if (false === $this->getUser()->hasRole('ROLE_ADMIN_USER_DELETE')) {
            return $this->getClientErrorResponseBuilder()->forbidden();
        }

        $user->setStatus(User::STATUS_DELETED);
        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->ok();
    }
}
