<?php

namespace App\Controller\Api\Notification\ActionHelper;

use App\Domain\Manager\NotificationManager;
use App\Entity\Notification\AbstractNotification;
use App\Entity\Notification\WebNotification;
use App\Entity\User\User;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class GetManyNotificationHelper
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var NotificationManager
     */
    protected $notificationManager;

    /**
     * GetManyNotificationHelper constructor.
     *
     * @param ObjectManager       $entityManager
     * @param NotificationManager $notificationManager
     */
    public function __construct(ObjectManager $entityManager, NotificationManager $notificationManager)
    {
        $this->entityManager = $entityManager;
        $this->notificationManager = $notificationManager;
    }

    /**
     * @param User              $user
     * @param WebNotification[] $notifications
     */
    public function doPostConsultActions(User $user, array $notifications = []): void
    {
        $this->updateDisplayedNotifications($notifications);
        $this->notificationManager->decrementNotificationCount($user, count($notifications));
    }

    /**
     * @param AbstractNotification[] $notifications
     */
    protected function updateDisplayedNotifications(array $notifications): void
    {
        foreach ($notifications as $notification) {
            $notification->setStatus(AbstractNotification::STATUS_SEEN);
        }

        $this->entityManager->flush();
    }

}