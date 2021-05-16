<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityRenderController extends AbstractController
{
    /**
     * @Route("/security/error", name="security_render_error")
     */
    public function index(): Response
    {
        return $this->render('security_render/index.html.twig', [
            'controller_name' => 'SecurityRenderController',
        ]);
    }
}
