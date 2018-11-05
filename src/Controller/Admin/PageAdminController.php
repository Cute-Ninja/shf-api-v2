<?php

namespace App\Controller\Admin;

use App\Controller\AbstractBaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;

class PageAdminController extends AbstractBaseController
{
    /**
     * @return Response
     *
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN_DASHBOARD_READ')", statusCode=403)
     */
    public function dashboard(): Response
    {
        return $this->render('admin/admin-dashboard.html.twig');
    }

    /**
     * @return Response
     *
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN_USER_READ')", statusCode=403)
     */
    public function users(): Response
    {
        return $this->render('admin/admin-users.html.twig');
    }

    /**
     * @return Response
     *
     * @Security("is_granted('ROLE_SUPER_ADMIN') or is_granted('ROLE_ADMIN_WORKOUT_READ')", statusCode=403)
     */
    public function workouts(): Response
    {
        return $this->render('admin/admin-workouts.html.twig');
    }
}