<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Form\SearchBarType;
use App\Form\PaiementAgentType;
use App\Repository\PaiementRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PaiementAgentController extends AbstractController
{
    /**
     * @Route("/agent/paiement/liste", name="paiement_agent_liste")
     */
    public function index(PaiementRepository $paiementRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $form = $this->createForm(SearchBarType::class, null, ['attr' => ['class' => 'd-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search']]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form-> isValid()){
            $apiementSearched = $paiementRepository->search($request->request->get('search_bar')['text']);
            return $this->render('paiement/agent/index.html.twig', [
                'paiementss' => $apiementSearched,
                'form' =>$form->createView(),
                'titre' => 'Liste des paiements'
            ]);
        }

        return $this->render('paiement/agent/index.html.twig', [
            'paiements' => $paginator->paginate($paiementRepository->findAll(),
            $request->query->getInt('page', 1),
            10),
            'form' =>$form->createView(),
            'titre' => 'Liste des paiements'
        ]);
    }

    /**
     * @Route("/agent/paiement/regulariser", name="paiement_agent_regulariser")
     */
    public function regulariser(PaiementRepository $paiementRepository, Request $request, PaginatorInterface $paginator): Response
    { 
        $form = $this->createForm(SearchBarType::class, null, ['attr' => ['class' => 'd-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search']]);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form-> isValid()){
            $apiementSearched = $paiementRepository->search($request->request->get('search_bar')['text']);
            return $this->render('paiement/agent/index.html.twig', [
                'paiementss' => $apiementSearched,
                'form' =>$form->createView(),
                'titre' => 'Liste des paiements à régulariser'
            ]);
        }       
        $paiements = [];
        $paies =  $paiementRepository->findAll();
        foreach ($paies as $paiement) {
            if($paiement->getEtatEnt() && !$paiement->getEtat())
                $paiements [] = $paiement;
        }
        return $this->render('paiement/agent/index.html.twig', [
            'paiements' => $paginator->paginate($paiementRepository->findByEtat(false),
            $request->query->getInt('page', 1),
            10),
            'titre' => 'Liste des paiements à régulariser',            
            'form' =>$form->createView(),
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
