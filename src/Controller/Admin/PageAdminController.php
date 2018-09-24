<?php

namespace App\Controller\Admin;

use App\Controller\AbstractBaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;

class PageAdminController extends AbstractBaseController
{
    /**
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN_DASHBOARD_READ", statusCode=403)
     */
    public function dashboard(): Response
    {
        return $this->render('admin/admin-dashboard.html.twig');
    }

    /**
     * @return Response
     *
     * @IsGranted("ROLE_ADMIN_USER_READ", statusCode=403)
     */
    public function user(): Response
    {
        return $this->render('admin/admin-user.html.twig');
    }
}