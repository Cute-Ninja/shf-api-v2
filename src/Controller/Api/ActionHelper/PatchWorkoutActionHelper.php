<?php

namespace App\Controller\Api\ActionHelper;

use App\Entity\AbstractWorkout;
use App\Entity\AbstractWorkoutStep;
use App\Entity\PersonalWorkout;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchWorkoutActionHelper
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
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
    public function undoWorkout(int $workoutId): AbstractWorkout
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
                      ->findManyByCriteria(['workout', $workout]);

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