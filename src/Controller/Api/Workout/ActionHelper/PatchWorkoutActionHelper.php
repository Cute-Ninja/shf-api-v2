<?php

namespace App\Controller\Api\Workout\ActionHelper;

use App\Domain\Persister\Workout\PersonalWorkoutPersister;
use App\Entity\User\User;
use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\PersonalWorkout;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchWorkoutActionHelper
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var PersonalWorkoutPersister
     */
    protected $personalWorkoutPersister;

    public function __construct(ObjectManager $entityManager, PersonalWorkoutPersister $personalWorkoutPersister)
    {
        $this->entityManager = $entityManager;
        $this->personalWorkoutPersister = $personalWorkoutPersister;
    }

    /**
     * @param User           $user
     * @param                $workoutId
     * @param \DateTime|null $scheduledDate
     *
     * @return AbstractWorkout
     */
    public function scheduleWorkout(User $user, $workoutId, \DateTime $scheduledDate = null): AbstractWorkout
    {
        return $this->personalWorkoutPersister->scheduleOnce(
            $user,
            $this->getWorkout($workoutId),
            $scheduledDate
        );
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
            return $this->personalWorkoutPersister->doStatusUpdate(
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
            return $this->personalWorkoutPersister->doStatusUpdate(
                $workout,
                PersonalWorkout::STATUS_ACTIVE
            );
        }

        throw new AccessDeniedHttpException();
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
        $workout    = $repository->findOneByCriteria(['id' => $workoutId]);

        if (null === $workout) {
            throw new NotFoundHttpException();
        }

        return $workout;
    }
}