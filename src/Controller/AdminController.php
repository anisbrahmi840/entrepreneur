<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Agent;
use App\Form\AdminType;
use App\Form\AgentType;
use App\Entity\Entrepreneur;
use App\Form\EntrepreneurAdminType;
use App\Repository\AdminRepository;
use App\Repository\AgentRepository;
use App\Repository\EntrepreneurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(AdminRepository $adminRepository, EntrepreneurRepository $entrepreneurRepository): Response
    {
        return $this->render('admin/index.html.twig', [
            'admins' => $adminRepository->findAll(),
            'nbEntrepreneurs' => count($entrepreneurRepository->findAll())
        ]);
    }

    /**
     * @Route("/new", name="admin_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/new.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_show", methods={"GET"})
     */
    public function show(Admin $admin): Response
    {
        return $this->render('admin/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Admin $admin, UserPasswordEncoderInterface $encoder): Response
    {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setPassword($encoder->encodePassword($admin, $admin->getPassword()));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/edit.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Admin $admin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

// ------------Controle Entrepreneur -----------

    /**
     * @Route("/entrepreneurs/liste", name="entrepreneur_index", methods={"GET"})
     */
    public function indexEntrepreneur(Request $request, EntrepreneurRepository $entrepreneurRepository, PaginatorInterface $paginator): Response
    {
        $entrepreneurs = $paginator->paginate($entrepreneurRepository->findAll(),
        $request->query->getInt('page', 1),
        10);
        return $this->render('entrepreneur/admin/index.html.twig', [
            'entrepreneurs' => $entrepreneurs
        ]);
    }

    /**
     * @Route("/entrepreneur/{slug}", name="entrepreneur_show_admin", methods={"GET"})
     */
    public function showEntrepreneur(Entrepreneur $entrepreneur): Response
    {
        return $this->render('entrepreneur/admin/show.html.twig', [
            'entrepreneur' => $entrepreneur,
        ]);
    }

    /**
     * @Route("/entrepreneur/{slug}/edit", name="entrepreneur_edit_admin", methods={"GET","POST"})
     */
    public function editEntrepreneur(Request $request, Entrepreneur $entrepreneur): Response
    {
        $form = $this->createForm(EntrepreneurAdminType::class, $entrepreneur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('entrepreneur_index');
        }

        return $this->render('entrepreneur/admin/editAdmin.html.twig', [
            'entrepreneur' => $entrepreneur,
            'form' => $form->createView(),
        ]);
    }

// -----------------------------Controle Agnet --------------------------------------------------------------

    /**
     * @Route("/agents/liste", name="agent_index_admin", methods={"GET"})
     */
    public function indexAgent( Request $request, PaginatorInterface $paginator, AgentRepository $agentRepository): Response
    {
        $agents = $paginator->paginate($agentRepository->findAll(),
        $request->query->getInt('page', 1),
        10);
        return $this->render('agent/admin/index.html.twig', [
            'agents' => $agents,
        ]);
    }

    /**
     * @Route("/agent/new", name="agent_new_admin", methods={"GET","POST"})
     */
    public function newAgent(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $agent = new Agent();
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $agent->setPassword($encoder->encodePassword($agent, $agent->getPassword()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($agent);
            $entityManager->flush();

            return $this->redirectToRoute('agent_index_admin');
        }

        return $this->render('agent/admin/new.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/agent/{slug}", name="agent_show_admin", methods={"GET"})
     */
    public function showAgent(Agent $agent): Response
    {
        return $this->render('agent/admin/show.html.twig', [
            'agent' => $agent,
        ]);
    }

    /**
     * @Route("/agent/{slug}/edit", name="agent_edit_admin", methods={"GET","POST"})
     */
    public function editAgent(Request $request, Agent $agent): Response
    {
        $form = $this->createForm(AgentType::class, $agent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('agent_index');
        }

        return $this->render('agent/admin/edit.html.twig', [
            'agent' => $agent,
            'form' => $form->createView(),
        ]);
    }

}
