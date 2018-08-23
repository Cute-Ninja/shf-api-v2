<?php

namespace App\Controller\Api;

use App\Controller\Api\ActionHelper\PatchWorkoutStepActionHelper;
use App\Entity\AbstractWorkout;
use App\Entity\AbstractWorkoutStep;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class WorkoutStepApiController extends AbstractApiController
{
    private const PATCH_ACTION_COMPLETE = 'complete';
    private const PATCH_ACTION_UNDO = 'undo';

    /**
     * @var Request $request
     * @var int     $workoutId
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the list Workouts",
     *     @SWG\Schema(
     *         type="array",
     *         @SWG\Items(ref=@Model(type=AbstractWorkoutStep::class, groups={"default"}))
     *     )
     * )
     * @SWG\Response(
     *     response=204,
     *     description="No Workout found for the search parameters used"
     * )
     *
     * @SWG\Tag(name="WorkoutStep")
     * @Security(name="Bearer")
     */
    public function getMany(Request $request, int $workoutId): Response
    {
        $builder = $this->getWorkoutStepRepository()
                        ->findManyByCriteriaBuilder(['workout' => $workoutId], ['workout', 'exercise'], ['position' => 'ASC']);

        return $this->getSuccessResponseBuilder()->buildMultiObjectResponse(
            $this->paginate($builder, $request),
            $request,
            $this->getRouter(),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @var Request $request
     * @var int     $workoutId
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WorkoutStep")
     * @Security(name="Bearer")
     */
    public function getOne(Request $request, int $workoutId, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var int     $workoutId
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WorkoutStep")
     * @Security(name="Bearer")
     */
    public function post(Request $request, int $workoutId): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var int     $workoutId
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=501,
     *     description="Not implemented"
     * )
     *
     * @SWG\Tag(name="WorkoutStep")
     * @Security(name="Bearer")
     */
    public function put(Request $request, int $workoutId, int $id): Response
    {
        return $this->getServerErrorResponseBuilder()->notImplemented();
    }

    /**
     * @var Request $request
     * @var int     $workoutId
     * @var int     $id
     *
     * @return Response
     *
     * @SWG\Response(
     *     response=204,
     *     description="The WorkoutStep has been deleted successfully"
     * )
     * @SWG\Response(
     *     response=403,
     *     description="You are not allowed to delete this WorkoutStep"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No id was matching an existing WorkoutStep"
     * )
     *
     * @SWG\Tag(name="WorkoutStep")
     * @Security(name="Bearer")
     */
    public function delete(Request $request, int $workoutId, int $id): Response
    {
        $step = $this->getWorkoutStepRepository()
                     ->findOneByCriteria(['id' => $id, 'workout' => $workoutId]);

        if (null === $step) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        $this->getEntityManager()->remove($step);
        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $step->getWorkout(),
            $this->getSerializationGroup($request)
        );
    }

    /**
     * @param Request $request
     * @param int     $workoutId
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
     *     description="You are not allowed to delete this WorkoutStep"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No id was matching an existing WorkoutStep"
     * )
     *
     * @SWG\Tag(name="WorkoutStep")
     * @Security(name="Bearer")
     */
    public function patch(Request $request, int $workoutId, string $action): Response
    {
        $helper = new PatchWorkoutStepActionHelper($this->getEntityManager());
        try {
            if (self::PATCH_ACTION_COMPLETE === $action) {
                $step = $helper->completeStep($workoutId, $request->query->get('id'));
            } elseif(self::PATCH_ACTION_UNDO === $action) {
                $step = $helper->undoStep($workoutId, $request->query->get('id'));
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