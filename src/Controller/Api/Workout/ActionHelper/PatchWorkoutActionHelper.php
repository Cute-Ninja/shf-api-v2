<?php

namespace App\Controller\Api\Workout\ActionHelper;

use App\Domain\Persister\Workout\PersonalWorkoutPersister;
use App\Entity\User\User;
use App\Entity\Workout\AbstractWorkout;
use App\Entity\Workout\PersonalWorkout;
use App\Exception\Http\NotImplementedHttpException;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatchWorkoutActionHelper
{
    private const PATCH_ACTION_COMPLETE = 'complete';
    private const PATCH_ACTION_UNDO = 'undo-complete';
    private const PATCH_ACTION_SCHEDULE = 'schedule';

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
     * @param string $action
     * @param int    $workoutId
     * @param array  $extraParams
     *
     * @return AbstractWorkout
     *
     * @throws NotImplementedHttpException
     */
    public function doPatchAction(string $action, int $workoutId, array  $extraParams): AbstractWorkout
    {
        if (self::PATCH_ACTION_COMPLETE === $action) {
            return $this->completeWorkout($workoutId);
        }

        if (self::PATCH_ACTION_UNDO === $action) {
            return $this->undoCompleteWorkout($workoutId);
        }

        if (self::PATCH_ACTION_SCHEDULE === $action) {
            return $this->scheduleWorkout($workoutId, $extraParams['user'], $extraParams['scheduledDate']);
        }

        throw new NotImplementedHttpException();
    }

    /**
     * @param int            $workoutId
     * @param User           $user
     * @param \DateTime|null $scheduledDate
     *
     * @return AbstractWorkout
     */
    protected function scheduleWorkout(int $workoutId, User $user, \DateTime $scheduledDate = null): AbstractWorkout
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
    protected function completeWorkout(int $workoutId): AbstractWorkout
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
    protected function undoCompleteWorkout(int $workoutId): AbstractWorkout
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