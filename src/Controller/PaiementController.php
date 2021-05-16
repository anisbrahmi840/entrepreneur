<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Form\PaiementType;
use App\Entity\Declaration;
use App\Repository\PaiementRepository;
use App\Repository\DeclarationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/entrepreneur/declaration/paiement")
 * @Security("is_granted('ROLE_USER') and user.getEtat()===true")
 */
class PaiementController extends AbstractController
{
    /**
     * @Route("/liste", name="paiement_index", methods={"GET"})
     */
    public function index(DeclarationRepository $declarationRepository, PaginatorInterface $paginator, Request $request): Response
    {

        return $this->render('paiement/index.html.twig', [
            'declarations' => $paginator->paginate($declarationRepository->findBy(['entrepreneur' => $this->getUser(), 'etat' => true], array('date_dec' => 'DESC')),
                                $request->query->getInt('page', 1),
                                10),]);
    }

    /**
     * @Route("/{ref}/new", name="paiement_new", methods={"GET","POST"})
     */
    public function new(Request $request, Declaration $declaration): Response
    {
        $paiement = new Paiement();        
        $paiement->setDatePai(new \DateTime('now'));
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $paiement
                ->setDeclaration($declaration)
                ->settype('versement')
                ->setEtatEnt(true)
                ->setRef(uniqid('Pai-'))
                ;
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($paiement);
            $entityManager->flush();

            return $this->redirectToRoute('declaration_index');
        }

        return $this->render('paiement/new.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paiement_show", methods={"GET"})
     */
    public function show(Paiement $paiement): Response
    {
        return $this->render('paiement/show.html.twig', [
            'paiement' => $paiement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="paiement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paiement $paiement): Response
    {
        $form = $this->createForm(PaiementType::class, $paiement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paiement_index');
        }

        return $this->render('paiement/edit.html.twig', [
            'paiement' => $paiement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paiement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Paiement $paiement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$paiement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($paiement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('paiement_index');
    }
}
