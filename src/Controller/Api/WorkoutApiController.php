<?php

namespace App\Controller\Api;

use App\Controller\Api\ActionHelper\GetManyWorkoutActionHelper;
use App\Controller\Api\ActionHelper\PatchWorkoutActionHelper;
use App\Entity\AbstractWorkout;
use App\Entity\PersonalWorkout;
use App\Entity\ReferenceWorkout;
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
    private const PATCH_ACTION_UNDO = 'undo';

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

        $actionHelper = new GetManyWorkoutActionHelper($this->getEntityManager());
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
     * @var string  $id
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
    public function getOne(Request $request, string $id): Response
    {
        $groups = $this->getSerializationGroup($request);

        $workout = $this->getWorkoutRepository()
                        ->findOneByCriteria(['id' => $id]);

        if (null === $workout) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $workout,
            $groups
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
     * @var string  $id
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
    public function put(Request $request, string $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var string  $id
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
    public function delete(Request $request, string $id): Response
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
        $helper = new PatchWorkoutActionHelper($this->getEntityManager());
        try {
            if (self::PATCH_ACTION_COMPLETE === $action) {
                $step = $helper->completeWorkout($request->query->get('id'));
            } elseif(self::PATCH_ACTION_UNDO === $action) {
                $step = $helper->undoWorkout($request->query->get('id'));
            } else {
                return $this->getServerErrorResponseBuilder()->notImplemented();
            }

            return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
                $step,
                $this->getSerializationGroup($request)
            );
        } catch (NotFoundHttpException $exception) {
            $errorResponse = $this->getClientErrorResponseBuilder()->notFound();
        } catch (AccessDeniedHttpException $exception) {
            $errorResponse = $this->getClientErrorResponseBuilder()->forbidden();
        }

        return $errorResponse;
    }
}
