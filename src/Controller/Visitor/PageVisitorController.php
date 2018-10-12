<?php

namespace App\Controller\Visitor;

use App\Controller\AbstractBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class PageVisitorController extends AbstractBaseController
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('visitor/visitor-index.html.twig');
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     *
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('visitor/visitor-login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @return Response
     */
    public function registration(): Response
    {
        return $this->render('visitor/visitor-registration.html.twig');
    }
}