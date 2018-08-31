<?php

namespace App\Controller\Api\ActionHelper\Workout;

use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\AbstractWorkoutStep;
use App\Entity\Workout\PersonalWorkout;
use App\Exception\Http\NotImplementedHttpException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchWorkoutActionHelper
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
     *
     * @return AbstractWorkout
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException|NotImplementedHttpException
     */
    public function doPatchAction(string $action, int $workoutId): AbstractWorkout
    {
        if (self::PATCH_ACTION_COMPLETE === $action) {
            return $this->completeWorkout($workoutId);
        }

        if (self::PATCH_ACTION_UNDO === $action) {
            return $this->undoCompleteWorkout($workoutId);
        }

        throw new NotImplementedHttpException();
    }

    /**
     * @param int $workoutId
     *
     * @return AbstractWorkout
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    public function completeWorkout(int $workoutId): AbstractWorkout
    {
        $workout = $this->getWorkout($workoutId);
        if ($workout instanceof PersonalWorkout) {
            return $this->doStatusUpdate(
                $workout,
                PersonalWorkout::STATUS_COMPLETED
            );

        }

        throw new AccessDeniedHttpException();
    }

    /**
     * @param int $workoutId
     *
     * @return AbstractWorkout
     *
     * @throws NotFoundHttpException|AccessDeniedHttpException
     */
    public function undoCompleteWorkout(int $workoutId): AbstractWorkout
    {
        $workout = $this->getWorkout($workoutId);
        if ($workout instanceof PersonalWorkout) {
            return $this->doStatusUpdate(
                $workout,
                PersonalWorkout::STATUS_ACTIVE
            );

        }

        throw new AccessDeniedHttpException();
    }

    /**
     * @param AbstractWorkout $workout
     * @param string               $status
     *
     * @return AbstractWorkout
     */
    private function doStatusUpdate(AbstractWorkout $workout, $status): AbstractWorkout
    {
        $this->doStepStatusUpdate($workout, $status);
        $workout->setStatus($status);

        $this->entityManager->flush();

        return $workout;
    }

    /**
     * @param AbstractWorkout $workout
     * @param string          $workoutStatus
     */
    private function doStepStatusUpdate(AbstractWorkout $workout, string $workoutStatus): void
    {
        $steps = $this->entityManager
                      ->getRepository(AbstractWorkoutStep::class)
                      ->findManyByCriteria(['workout' => $workout]);

        $stepStatus = $this->convertToStepStatus($workoutStatus);
        foreach ($steps as $step) {
            $step->setStatus($stepStatus);
        }
    }

    /**
     * @param string $workoutStatus
     *
     * @return string
     */
    private function convertToStepStatus(string $workoutStatus): string
    {
        $stepStatus = AbstractWorkoutStep::STATUS_ACTIVE;
        if (PersonalWorkout::STATUS_COMPLETED === $workoutStatus) {
            $stepStatus = AbstractWorkoutStep::STATUS_DONE;
        }

        return $stepStatus;
    }

    /**
     * @param int $workoutId
     *
     * @return AbstractWorkout
     *
     * @throws NotFoundHttpException
     */
    private function getWorkout(int $workoutId): AbstractWorkout
    {
        $repository = $this->entityManager->getRepository(AbstractWorkout::class);

        $workout = $repository->findOneByCriteria(
            ['id' => $workoutId]
        );

        if (null === $workout) {
            throw new NotFoundHttpException();
        }

        return $workout;
    }
}