<?php

namespace App\Controller;

use App\Entity\Temoignage;
use App\Form\TemoignageType;
use App\Repository\TemoignageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/temoignage")
 */
class TemoignageController extends AbstractController
{
    /**
     * @Route("/liste", name="temoignage_index", methods={"GET"})
     */
    public function index(TemoignageRepository $temoignageRepository, PaginatorInterface $paginator, Request $request): Response
    {
        return $this->render('temoignage/index.html.twig', [
            'temoignages' => $paginator->paginate($temoignageRepository->findAll(), $request->query->getInt('page', 1), 10),
        ]);
    }

    /**
     * @Route("/new", name="temoignage_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $temoignage = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $temoignage->setRef(uniqid('Tem-'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($temoignage);
            $entityManager->flush();

            return $this->redirectToRoute('temoignage_index');
        }

        return $this->render('temoignage/new.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{ref}", name="temoignage_show", methods={"GET"})
     */
    public function show(Temoignage $temoignage): Response
    {
        return $this->render('temoignage/show.html.twig', [
            'temoignage' => $temoignage,
        ]);
    }


    /**
     * @Route("/{id}", name="temoignage_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Temoignage $temoignage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$temoignage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($temoignage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('temoignage_index');
    }
}
