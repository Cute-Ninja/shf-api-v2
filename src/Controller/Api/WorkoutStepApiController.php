<?php

namespace App\Controller\Api;

use App\Controller\Api\ActionHelper\PatchWorkoutStepActionHelper;
use App\Controller\Api\ActionHelper\PostWorkoutStepActionHelper;
use App\Entity\AbstractWorkoutStep;
use App\Exception\Http\NotImplementedHttpException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @var string  $stepType
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
    public function post(Request $request, int $workoutId, string $stepType): Response
    {
        $workout = $this->getWorkoutRepository()->findOneByCriteria(['id' => $workoutId]);
        if (null === $workout) {
            return $this->getClientErrorResponseBuilder()->notFound();
        }

        $helper = new PostWorkoutStepActionHelper();
        $step   = $helper->buildStepFromType($stepType, $workout);

        $form = $this->createForm($helper->buildFormNameFromType($stepType), $step, ['method' => 'POST']);

        $form->handleRequest($request);
        if (false === $form->isSubmitted() || false === $form->isValid()) {
            return $this->getClientErrorResponseBuilder()->jsonResponseFormError($form);
        }

        $this->getEntityManager()->persist($step);
        $this->getEntityManager()->flush();

        return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
            $step,
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
     *     description="You are not allowed to do this action"
     * )
     * @SWG\Response(
     *     response=404,
     *     description="No id was matching an existing WorkoutStep"
     * )
     * @SWG\Response(
     *     response=501,
     *     description="The selected action is not available"
     * )
     *
     * @SWG\Tag(name="WorkoutStep")
     * @Security(name="Bearer")
     */
    public function patch(Request $request, int $workoutId, string $action): Response
    {
        $helper = new PatchWorkoutStepActionHelper($this->getEntityManager());
        try {
            $step = $helper->doPatchAction($action, $workoutId, $request->query->get('id'));

            return $this->getSuccessResponseBuilder()->buildSingleObjectResponse(
                $step,
                $this->getSerializationGroup($request)
            );
        }  catch (NotFoundHttpException $exception) {
            $errorResponse = $this->getClientErrorResponseBuilder()->notFound();
        } catch (AccessDeniedHttpException $exception) {
            $errorResponse = $this->getClientErrorResponseBuilder()->forbidden();
        } catch (NotImplementedHttpException $exception) {
            $errorResponse = $this->getServerErrorResponseBuilder()->notImplemented();
        }

        return $errorResponse;
    }
}