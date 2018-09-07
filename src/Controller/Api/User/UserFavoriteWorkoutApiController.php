<?php

namespace App\Controller\Api\User;

use App\Controller\Api\AbstractApiController;
use App\Controller\Api\StandardApiInterface;
use App\Entity\User\UserFavoriteWorkout;
use App\Form\Type\User\UserFavoriteWorkoutType;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserFavoriteWorkoutApiController extends AbstractApiController implements StandardApiInterface
{
    /**
     * @var Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list of favorites StandardWorkouts of users",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=UserFavoriteWorkout::class, groups={"default"}))
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="No favorites StandardWorkout found for the search parameters used"
     * )
     * @SWG\Tag(name="UserFavoriteWorkout")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
    {
        $builder = $this->getUserFavoriteWorkoutRepository()
                        ->findManyByCriteriaBuilder(
                            [
                                'user'     => $request->get('user'),
                            ],
                            ['user', 'workout']
                        );

        return $this->getSuccessResponseBuilder()->buildMultiObjectResponse(
            $this->paginate($builder, $request),
            $request,
            $this->getRouter(),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @var Request $request
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserFavoriteWorkout")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, int $id): Response
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
     * @SWG\Tag(name="UserFavoriteWorkout")
     * @Security(name="Bearer")
     */
    public function post(Request $request): Response
    {
        $favorite = new UserFavoriteWorkout();

        $form = $this->createForm(
            UserFavoriteWorkoutType::class,
            $favorite,
            ['method' => 'POST']
        );

        $form->handleRequest($request);
        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $this->getClientErrorResponseBuilder()->jsonResponseFormError($form);
        }

        $helper = $this->get('shf_api.action_helper.user_favorite_workout.post');
        $helper->saveFavorite($favorite);

        return $this->getSuccessResponseBuilder()->created(
            $favorite,
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @var Request $request
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="UserFavoriteWorkout")
     * @Security(name="Bearer")
     */
    public function put(Request $request, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=204,
     *     description="The Favorite Workout has been deleted successfully"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed to delete this Favorite Workout"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No id was matching an existing Favorite Workout"
     * )
     * @SWG\Tag(name="UserFavoriteWorkout")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, int $id): Response
    {
        $favorite = $this->getUserFavoriteWorkoutRepository()
                         ->findOneByCriteria(['id' => $id]);

        if (null === $favorite) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        if ($this->getUser()->getId() !== $favorite->getUser()->getId()) {
            return $this->getClientErrorResponseBuilder()->forbidden();
        }

        $this->getEntityManager()->remove($favorite);
        $this->getEntityManager()->flush();

        return $this->getServerErrorResponseBuilder()->ok();
    }
}