<?php

namespace App\Controller\Admin;

use App\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Response;

class PageAdminController extends AbstractBaseController
{
    /**
     * @return Response
     */
    public function dashboard(): Response
    {
        return $this->render('admin/admin-dashboard.html.twig');
    }

    /**
     * @return Response
     */
    public function user(): Response
    {
        return $this->render('admin/admin-user.html.twig');
    }
}