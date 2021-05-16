<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Declaration;
use App\Form\DeclarationType;
use App\Repository\DeclarationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/entrepreneur/declaration") 
 * @Security("is_granted('ROLE_USER') and user.getEtat()===true")
 */
class DeclarationController extends AbstractController
{
    /**
     * @Route("/encours/liste", name="declaration_encours", methods={"GET"})
     */
    public function encours(DeclarationRepository $declarationRepository, Request $request): Response
    {
        return $this->render('declaration/encours.html.twig', [
            'declaration' => $declarationRepository->encours($this->getUser(), new \DateTime()),
        ]);
    }

    /**
     * @Route("/regulariser/liste", name="declaration_regulariser", methods={"GET"})
     */
    public function regulariser(DeclarationRepository $declarationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        return $this->render('declaration/regulariser.html.twig', [
            'declarations' => $paginator->paginate($declarationRepository->regulariser($this->getUser(), new \DateTime()), $request->query->getInt('page',1), 10),
        ]);
    }

    /**
     * @Route("/liste", name="declaration_index", methods={"GET"})
     */
    public function index(DeclarationRepository $declarationRepository, PaginatorInterface $paginator, Request $request): Response
    {

        return $this->render('declaration/index.html.twig', [
            'declarations' => $paginator->paginate($declarationRepository->findBy(['entrepreneur' => $this->getUser(), 'etat' => true], array('date_dec' => 'DESC')),
                                $request->query->getInt('page', 1),
                                5),]);
    }

    /**
     * @Route("/{id}", name="declaration_show", methods={"GET"})
     */
    public function show(Declaration $declaration): Response
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf();        
        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml($this->render('declaration/show.html.twig', [
            'declaration' => $declaration,
        ])->getContent());
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();
        return $this->render('declaration/show.html.twig', [
            'declaration' => $declaration,
        ]);
    }

    /**
     * @Route("/{ref}/declarer", name="declaration_declarer", methods={"GET","POST"})
     */
    public function edit(Request $request, Declaration $declaration): Response
    {
        $daysDt = 0;
        if (date_create("now") > $declaration->getDateEx()){
            $daysDt = (date_diff(date_create("now"), $declaration->getDateEx()))->format("%a");
        }        
        $declaration->setPenalite(10*$daysDt);
        $form = $this->createForm(DeclarationType::class, $declaration);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $declaration
                ->setCotisation(($declaration->getChiffre()* $this->getUser()->getCategorie()->getActivite()->getTaux())/100)
                ->setTotalapayer($declaration->getCotisation() + $declaration->getPenalite())
                ->setEntrepreneur($this->getUser())
                ->setEtat(true)
                ->setDateDec( new \DateTime("now"))
            ;
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($declaration);
            $entityManager->flush();

            return $this->redirectToRoute('declaration_index');
        }

        return $this->render('declaration/new.html.twig', [
            'declaration' => $declaration,
            'form' => $form->createView(),
        ]);
    }
}
