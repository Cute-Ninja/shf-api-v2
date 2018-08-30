<?php

namespace App\Controller\Api\ActionHelper;

use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\AbstractWorkoutStep;
use App\Exception\Http\NotImplementedHttpException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchWorkoutStepActionHelper
{
    private const PATCH_ACTION_COMPLETE = 'complete';
    private const PATCH_ACTION_UNDO = 'undo-complete';

    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $action
     * @param int    $workoutId
     * @param int    $workoutStepId
     *
     * @return AbstractWorkoutStep
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException|NotImplementedHttpException
     */
    public function doPatchAction(string $action, int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        if (self::PATCH_ACTION_COMPLETE === $action) {
            return $this->completeStep($workoutId, $workoutStepId);
        }

        if (self::PATCH_ACTION_UNDO === $action) {
            return $this->undoCompleteStep($workoutId, $workoutStepId);
        }

        throw new NotImplementedHttpException();
    }

    /**
     * @param int $workoutId
     * @param int $workoutStepId
     *
     * @return AbstractWorkoutStep
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    public function completeStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        return $this->doStepStatusUpdate(
            $this->getWorkoutStep($workoutId, $workoutStepId),
            AbstractWorkoutStep::STATUS_DONE
        );
    }

    /**
     * @param int $workoutId
     * @param int $workoutStepId
     *
     * @return AbstractWorkoutStep
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    public function undoCompleteStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        return $this->doStepStatusUpdate(
            $this->getWorkoutStep($workoutId, $workoutStepId),
            AbstractWorkoutStep::STATUS_ACTIVE
        );
    }

    /**
     * @param AbstractWorkoutStep|null $step
     * @param                          $status
     *
     * @return AbstractWorkoutStep
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    private function doStepStatusUpdate(?AbstractWorkoutStep $step, $status): AbstractWorkoutStep
    {
        if (null === $step) {
            throw new NotFoundHttpException();
        }

        if (AbstractWorkout::TYPE_REFERENCE === $step->getWorkout()->getType()) {
            throw new AccessDeniedHttpException();
        }

        $step->setStatus($status);
        $this->entityManager->flush();

        return $step;
    }

    /**
     * @param int $workoutId
     * @param int $workoutStepId
     *
     * @return AbstractWorkoutStep
     */
    private function getWorkoutStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        $repository = $this->entityManager->getRepository(AbstractWorkoutStep::class);

        return $repository->findOneByCriteria(
                        ['workout' => $workoutId, 'id' => $workoutStepId],
                        ['workout', 'exercise']
                    );
    }
}