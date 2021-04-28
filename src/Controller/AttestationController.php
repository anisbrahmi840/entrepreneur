<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttestationController extends AbstractController
{
    /**
     * @Route("/entrepreneur/attestations", name="attestation_index")
     */
    public function index(): Response
    {
        return $this->render('attestation/index.html.twig', [            
            'attestations' => $this->getUser()->getAttestationChiffreAffaires(),
            'controller_name' => 'Attestations',
        ]);
    }
}
