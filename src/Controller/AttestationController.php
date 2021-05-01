<?php

namespace App\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AttestationController extends AbstractController
{
    /**
     * @Route("/entrepreneur/attestations", name="attestation_index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $attestations = new ArrayCollection(
            array_merge($this->getUser()->getAttestationChiffreAffaires()->toArray(), $this->getUser()->getAttestationFiscales()->toArray())
        );

       $attestions = $paginator->paginate($attestations, $request->query->getInt('page', 1), 5);

        return $this->render('attestation/index.html.twig', [            
            'attestations' => $attestions,
        ]);
    }
}
