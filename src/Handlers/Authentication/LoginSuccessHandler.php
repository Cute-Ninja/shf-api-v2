<?php

namespace App\Handlers\Authentication;

use App\Entity\User;
use App\Entity\WaterTracker;
use App\Repository\WaterTrackerRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @param RouterInterface $router
     * @param Registry        $doctrine
     */
    public function __construct(
        RouterInterface $router,
        Registry $doctrine
    ) {
        $this->router = $router;
        $this->doctrine = $doctrine;
    }

    /**
     * @param Request        $request
     * @param TokenInterface $token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        if ($token->getUser()->isAdmin()) {
            $response = new RedirectResponse($this->router->generate('admin_page_dashboard'));
        } else {
            $this->saveLastLogin($token->getUser());
            $this->handleWaterTrackerDay($token->getUser());

            $response = new RedirectResponse($this->router->generate('front_page_dashboard'));
        }

        $this->doctrine->getManager()->flush();

        return $response;
    }

    /**
     * @param User $user
     */
    private function saveLastLogin(User $user): void
    {
        $user->setLastLogin(new \DateTime());
        $this->doctrine->getManager()->persist($user);
    }

    /**
     * @param User $user
     */
    private function handleWaterTrackerDay(User $user): void
    {
        $trackerDay = $this->getWaterTrackerRepository()
                           ->findOneByCriteria(
                               [
                                   'user' => $user->getId(),
                                   'createdBetween' => [
                                       'start' => new \DateTime('today'),
                                       'end'   => new \DateTime('tomorrow')
                                   ]
                               ]
                           );

        if (null === $trackerDay) {
            $trackerDay = new WaterTracker();
            $trackerDay->setTarget(2000);
            $trackerDay->setUser($user);

            $this->doctrine->getManager()->persist($trackerDay);
        }
    }

    /**
     * @return WaterTrackerRepository
     */
    private function getWaterTrackerRepository(): WaterTrackerRepository
    {
        return $this->doctrine->getManager()->getRepository(WaterTracker::class);
    }
}
