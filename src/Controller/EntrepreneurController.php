<?php

namespace App\Controller;

use App\Entity\Entrepreneur;
use App\Form\EntrepreneurType;
use App\Repository\EntrepreneurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/entrepreneur")
 */
class EntrepreneurController extends AbstractController
{
    /**
     * @Route("/", name="entrepreneur_index", methods={"GET"})
     */
    public function index(EntrepreneurRepository $entrepreneurRepository): Response
    {
        return $this->render('entrepreneur/index.html.twig', [
            'entrepreneurs' => $entrepreneurRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="entrepreneur_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $entrepreneur = new Entrepreneur();
        $form = $this->createForm(EntrepreneurType::class, $entrepreneur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entrepreneur->setPassword($encoder->encodePassword($entrepreneur, $entrepreneur->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($entrepreneur);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('entrepreneur/new.html.twig', [
            'entrepreneur' => $entrepreneur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entrepreneur_show", methods={"GET"})
     */
    public function show(Entrepreneur $entrepreneur): Response
    {
        return $this->render('entrepreneur/show.html.twig', [
            'entrepreneur' => $entrepreneur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="entrepreneur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Entrepreneur $entrepreneur): Response
    {
        $form = $this->createForm(EntrepreneurType::class, $entrepreneur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrepreneur_index');
        }

        return $this->render('entrepreneur/edit.html.twig', [
            'entrepreneur' => $entrepreneur,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="entrepreneur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Entrepreneur $entrepreneur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$entrepreneur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($entrepreneur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('entrepreneur_index');
    }
}
