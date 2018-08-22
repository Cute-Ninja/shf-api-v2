<?php

namespace App\Controller\Front;

use App\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Response;

class PageFrontController extends AbstractBaseController
{
    /**
     * @return Response
     */
    public function dashboard(): Response
    {
        return $this->render('front/front-dashboard.html.twig');
    }

    /**
     * @return Response
     */
    public function profile(): Response
    {
        return $this->render('front/front-profile.html.twig');
    }

    /**
     * @return Response
     */
    public function workouts(): Response
    {
        return $this->render('front/front-workouts.html.twig');
    }

    /**
     * @param int $id
     *
     * @return Response
     */
    public function workout(int $id): Response
    {
        return $this->render('front/front-workout.html.twig', ['workoutId' => $id]);
    }
}