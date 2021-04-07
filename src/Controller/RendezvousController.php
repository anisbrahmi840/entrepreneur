<?php

namespace App\Controller;

use App\Entity\Rendezvous;
use App\Form\RendezvousType;
use App\Form\RendezvousAgentType;
use App\Repository\RendezvousRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RendezvousController extends AbstractController
{
    /**
     * @Route("/entrepreneur/rendezvous/liste", name="rendezvous_index", methods={"GET"})
     */
    public function index(Request $request, RendezvousRepository $rendezvousRepository, PaginatorInterface $paginator): Response
    {
        $entrepreneur = $this->getUser();
        $rendezvous = $paginator->paginate($rendezvousRepository->findBy(['entrepreneur' => $entrepreneur], array('createdAt' => 'DESC')),
        $request->query->getInt('page', 1,
        10));
        return $this->render('rendezvous/index.html.twig', [
            'rendezvous' => $rendezvous,
        ]);
    }

    /**
     * @Route("/entrepreneur/rendezvous/new", name="rendezvous_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rendezvou = new Rendezvous();
        $form = $this->createForm(RendezvousType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezvou->setEntrepreneur($this->getUser());
            $rendezvou->setCreatedAt(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rendezvou);
            $entityManager->flush();

            return $this->redirectToRoute('rendezvous_index');
        }

        return $this->render('rendezvous/new.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("entrepreneur/rendezvous/{slug}", name="rendezvous_show", methods={"GET"})
     */
    public function show(Rendezvous $rendezvou): Response
    {
        return $this->render('rendezvous/show.html.twig', [
            'rendezvou' => $rendezvou,
        ]);
    }


//------------------Agent Rendez-vous----control-------------------------------------------------------    
  
    /**
     * @Route("/agent/rendezvous/liste", name="agent_rendezvous_index", methods={"GET"})
     */
    public function indexAgent(Request $request, RendezvousRepository $rendezvousRepository, PaginatorInterface $paginator): Response
    {   
        $rendezvous = $paginator->paginate($rendezvousRepository->findBy(['etat' => false, 'observation' => null]),
        $request->query->getInt('page', 1,
        10));
        return $this->render('rendezvous/agent/index.html.twig', [
            'rendezvous' => $rendezvous,
        ]);
    }

    /**
     * @Route("/agent/{slug}/mesrendezvous", name="agent_rendezvous_mesrendezvous", methods={"GET"})
     */
    public function mesRendezous(Request $request, RendezvousRepository $rendezvousRepository, PaginatorInterface $paginator): Response
    {   
        $rendezvous = $paginator->paginate($rendezvousRepository->findBy(['agent' => $this->getUser()]),
        $request->query->getInt('page', 1,
        10));
        return $this->render('rendezvous/agent/mesrendezvous.html.twig', [
            'rendezvous' => $rendezvous,
        ]);
    }

    /**
     * @Route("/agent/rendezvous/{slug}/edit", name="agent_rendezvous_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rendezvous $rendezvou): Response
    {
        $form = $this->createForm(RendezvousAgentType::class, $rendezvou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rendezvou->setAgent($this->getUser());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agent_rendezvous_index');
        }

        return $this->render('rendezvous/agent/edit.html.twig', [
            'rendezvou' => $rendezvou,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{slug}", name="rendezvous_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rendezvous $rendezvou): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezvou->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rendezvou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rendezvous_index');
    }
}
