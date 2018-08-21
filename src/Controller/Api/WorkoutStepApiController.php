<?php

namespace App\Controller\Api;

use App\Entity\AbstractWorkoutStep;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class WorkoutStepApiController extends AbstractApiController
{
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
                        ->findManyByCriteriaBuilder(['workout' => $workoutId], ['exercise'], ['position' => 'ASC']);

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
}