<?php

namespace App\Controller\Api\ActionHelper;

use App\Entity\AbstractWorkout;
use App\Entity\AbstractWorkoutStep;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchWorkoutStepActionHelper
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
    public function undoStep(int $workoutId, int $workoutStepId): AbstractWorkoutStep
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