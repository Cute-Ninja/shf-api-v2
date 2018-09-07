<?php

namespace App\Domain\Manager;

use App\Entity\Notification\AbstractNotification;
use App\Entity\Notification\WebNotification;
use App\Entity\User\User;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class NotificationManager
{
    /**
     * @var ObjectManager
     */
    protected $entityManager;

    /**
     * @var FilesystemAdapter
     */
    protected $cache;

    /**
     * NotificationManager constructor.
     *
     * @param ObjectManager $entityManager
     */
    public function __construct(ObjectManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User $user
     *
     * @return int
     */
    public function getWebNotificationCount(User $user): int
    {
        $cache = $this->getNotificationCache();
        try {
            $notificationCount = $cache->getItem('notifications.count.user_' . $user->getId())->get();
        } catch (InvalidArgumentException $e) {
            var_dump('an error has occurred'); die;
        }

        return $notificationCount ?? 0;
    }

    /**
     * @param User $user
     * @param int  $numberOfNotifications
     */
    public function decrementNotificationCount(User $user, int $numberOfNotifications): void
    {
        $cache = $this->getNotificationCache();
        try {
            $item = $cache->getItem('notifications.count.user_' . $user->getId());
            $item->set($item->get() - $numberOfNotifications);
            $cache->save($item);
        } catch (InvalidArgumentException $e) {
            var_dump('an error has occurred'); die;
        }
    }

    /**
     * @param User $user
     */
    public function notify(User $user): void
    {
        $notification = new WebNotification();
        $notification->setTarget(AbstractNotification::NOTIFICATION_TARGET_MISSION);
        $notification->setTitle('test');
        $notification->setUser($user);

        $this->entityManager->persist($notification);
        $this->entityManager->flush();

        $this->incrementNotificationCount($user);
    }

    /**
     * @param User $user
     */
    protected function incrementNotificationCount(User $user): void
    {
        $cache = $this->getNotificationCache();
        try {
            $item = $cache->getItem('notifications.count.user_' . $user->getId());
            $item->set($item->get() + 1);
            $cache->save($item);
        } catch (InvalidArgumentException $e) {
            var_dump('an error has occurred'); die;
        }
    }

    /**
     * @return FilesystemAdapter
     */
    protected function getNotificationCache(): FilesystemAdapter
    {
        if (null === $this->cache) {
            $this->cache = new FilesystemAdapter();
        }

        return $this->cache;
    }
}