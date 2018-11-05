<?php

namespace App\Controller\Api\Workout\ActionHelper;

use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\AbstractWorkoutStep;
use App\Exception\Http\NotImplementedHttpException;
use App\Utils\Clock;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchWorkoutStepActionHelper
{
    private const PATCH_ACTION_COMPLETE      = 'complete';
    private const PATCH_ACTION_UNDO_COMPLETE = 'undo-complete';
    private const PATCH_ACTION_START         = 'start';
    private const PATCH_ACTION_UNDO_START    = 'undo-start';

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
        if (self::PATCH_ACTION_START === $action) {
            return $this->startStep($workoutId, $workoutStepId);
        }

        if (self::PATCH_ACTION_UNDO_START === $action) {
            return $this->undoStartStep($workoutId, $workoutStepId);
        }

        if (self::PATCH_ACTION_COMPLETE === $action) {
            return $this->completeStep($workoutId, $workoutStepId);
        }

        if (self::PATCH_ACTION_UNDO_COMPLETE === $action) {
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
    protected function completeStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        $step = $this->getWorkoutStep($workoutId, $workoutStepId);
        if (AbstractWorkoutStep::STATUS_DONE === $step->getStatus()
            || AbstractWorkout::TYPE_REFERENCE === $step->getWorkout()->getType()) {
            throw new AccessDeniedHttpException();
        }

        $step->setCompletionDate(Clock::now());

        $this->entityManager->flush();

        return $step;
    }

    /**
     * @param int $workoutId
     * @param int $workoutStepId
     *
     * @return AbstractWorkoutStep
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    protected function undoCompleteStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        $step = $this->getWorkoutStep($workoutId, $workoutStepId);
        if (AbstractWorkoutStep::STATUS_DONE !== $step->getStatus()
            || AbstractWorkout::TYPE_REFERENCE === $step->getWorkout()->getType()) {
            throw new AccessDeniedHttpException();
        }

        $step->setCompletionDate(null);

        $this->entityManager->flush();

        return $step;
    }

    /**
     * @param int $workoutId
     * @param int $workoutStepId
     *
     * @return AbstractWorkoutStep
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    protected function startStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        $step = $this->getWorkoutStep($workoutId, $workoutStepId);
        if (AbstractWorkoutStep::STATUS_STARTED === $step->getStatus()
            || AbstractWorkout::TYPE_REFERENCE === $step->getWorkout()->getType()) {
            throw new AccessDeniedHttpException();
        }

        $step->setStartingDate(Clock::now());

        $this->entityManager->flush();

        return $step;
    }

    /**
     * @param int $workoutId
     * @param int $workoutStepId
     *
     * @return AbstractWorkoutStep
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    protected function undoStartStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        $step = $this->getWorkoutStep($workoutId, $workoutStepId);
        if (AbstractWorkoutStep::STATUS_STARTED !== $step->getStatus()
            || AbstractWorkout::TYPE_REFERENCE === $step->getWorkout()->getType()) {
            throw new AccessDeniedHttpException();
        }

        $step->setStartingDate(null);

        $this->entityManager->flush();

        return $step;
    }

    /**
     * @param int $workoutId
     * @param int $workoutStepId
     *
     * @return AbstractWorkoutStep
     *
     * @throws NotFoundHttpException
     */
    private function getWorkoutStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
    {
        $repository = $this->entityManager->getRepository(AbstractWorkoutStep::class);
        $step       = $repository->findOneByCriteria(
                        ['workout' => $workoutId, 'id' => $workoutStepId],
                        ['workout', 'exercise']
                    );

        if (null === $step) {
            throw new NotFoundHttpException();
        }

        return $step;
    }
}