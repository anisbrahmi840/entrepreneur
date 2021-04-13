<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Form\PaiementAgentType;
use App\Repository\PaiementRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementAgentController extends AbstractController
{
    /**
     * @Route("/agent/paiement/liste", name="paiement_agent_liste")
     */
    public function index(PaiementRepository $paiementRepository): Response
    {
        return $this->render('paiement/agent/index.html.twig', [
            'paiements' => $paiementRepository->findAll(),
            'titre' => 'Liste des paiements'
        ]);
    }

    /**
     * @Route("/agent/paiement/regulariser", name="paiement_agent_regulariser")
     */
    public function regulariser(PaiementRepository $paiementRepository): Response
    {        
        $paies =  $paiementRepository->findAll();
        foreach ($paies as $paiement) {
            if($paiement->getEtatEnt() && !$paiement->getEtat())
                $paiements [] = $paiement;
        }
        return $this->render('paiement/agent/index.html.twig', [
            'paiements' => $paiements,
            'titre' => 'Liste des paiements à régulariser'
        ]);
    }

    /**
     * @Route("/agent/paiement/{ref}/edit", name="paiement_agent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paiement $paiement): Response
    {
        $form = $this->createForm(PaiementAgentType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiement_agent_liste');
        }

        return $this->render('paiement/agent/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }
}
