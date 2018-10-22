<?php

namespace App\Controller\Api\Workout;

use App\Controller\Api\AbstractApiController;
use App\Controller\Api\StandardApiInterface;
use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\ReferenceWorkout;
use App\Exception\Http\NotImplementedHttpException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class WorkoutApiController extends AbstractApiController implements StandardApiInterface
{
    private const PATCH_ACTION_COMPLETE = 'complete';
    private const PATCH_ACTION_UNDO = 'undo-complete';
    private const PATCH_ACTION_SCHEDULE = 'schedule';

    /**
     * @var Request $request
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list Workouts",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=AbstractWorkout::class, groups={"default"}))
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="No Workout found for the search parameters used"
     * )
     *
     * @SWG\Tag(name="Workout")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request): Response
    {
        $type = $request->get('type');

        $actionHelper = $this->get('shf_api.action_helper.workout.get_many');
        $builder      = $actionHelper->getWorkoutBuilder($request);

        if (ReferenceWorkout::TYPE_REFERENCE === $type && $userId = $request->get('user')) {
            $actionHelper->loadFavoriteWorkoutIds($userId);
        }

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
     * @SWG\Tag(name="Workout")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, int $id): Response
    {
        $workout = $this->getWorkoutRepository()
                        ->findOneByCriteria(['id' => $id]);

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $workout,
            $this->getSerializationGroup($request)
        );
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
     * @SWG\Tag(name="Workout")
     * @Security(name="Bearer")
     */
    public function post(Request $request): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $workoutType
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="The Workout has been successfully add and returned",
     *     @Model(type=AbstractWorkout::class, groups={"default"})
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No id was matching an existing Workout"
     * )
     * @SWG\Response(
     *     response=422,
     *     description="Error in the form you are submitted (details in Response body).",
     * )
     *
     * @SWG\Tag(name="Workout")
     * @Security(name="Bearer")
     */
    public function postWithType(Request $request, string $workoutType): Response
    {
        $helper  = $this->get('shf_api.action_helper.workout.post');
        $workout = $helper->buildWorkoutFromType($workoutType, $this->getUser());

        $form = $this->createForm($helper->buildFormNameFromType($workoutType), $workout, ['method' => 'POST']);

        $form->handleRequest($request);
        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $this->getClientErrorResponseBuilder()->jsonResponseFormError($form);
        }

        $this->getEntityManager()->persist($workout);
        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->created(
            $workout,
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
     * @SWG\Tag(name="Workout")
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
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="Workout")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @param Request $request
     * @param string  $action
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="The action has been successfully realized"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed to do this action"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No id was matching an existing Workout"
     * )
     * @SWG\Response(
     *     response=501,
     *     description="The selected action is not available"
     * )
     *
     * @SWG\Tag(name="Workout")
     * @Security(name="Bearer")
     */
    public function patch(Request $request, string $action): Response
    {
        $helper    = $this->get('shf_api.action_helper.workout.patch');
        $workoutId = $request->query->get('id');

        try {
            if (self::PATCH_ACTION_COMPLETE === $action) {
                $workout = $helper->completeWorkout($workoutId);
            } elseif (self::PATCH_ACTION_UNDO === $action) {
                $workout = $helper->undoCompleteWorkout($workoutId);
            } elseif (self::PATCH_ACTION_SCHEDULE === $action) {
                $dateAsString = $request->query->get('scheduledDate');
                $workout = $helper->scheduleWorkout(
                    $this->getUser(),
                    $workoutId,
                    $dateAsString ? new \DateTime($dateAsString) : null
                );
            } else {
                return $this->getServerErrorResponseBuilder()->notImplemented();
            }

            $this->getEntityManager()->flush();

            return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
                $workout,
                $this->getSerializationGroup($request)
            );
        }  catch (NotFoundHttpException $exception) {
            return $this->getClientErrorResponseBuilder()->notFound();
        } catch (AccessDeniedHttpException $exception) {
            return $this->getClientErrorResponseBuilder()->forbidden();
        }
    }
}
