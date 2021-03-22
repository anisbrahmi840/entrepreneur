<?php

namespace App\Controller;

use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Facture;
use App\Entity\Produit;
use App\Form\FactureType;
use App\Repository\FactureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @Route("/entrepreneur/facture")
 */
class FactureController extends AbstractController
{
    /**
     * @Route("/liste", name="facture_index", methods={"GET"})
     */
    public function index(FactureRepository $factureRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $factures = $paginator->paginate($factureRepository->findBy(['entrepreneur' => $this->getUser(), 'type' => 'facture']),
        $request->query->getInt('page', 1),
        5);
        return $this->render('facture/index.html.twig', [
            'factures' => $factures,
        ]);
    }

    /**
     * @Route("/new", name="facture_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $facture->setEntrepreneur($this->getUser());
            $facture->setDateFact(new \DateTime('now'));
            $facture->setRef(uniqid('Fac-'));
            $facture->setType('facture');
            $nbt = 0;
            foreach ($facture->getProduits() as $produit) {
                
                $produit->setPrixUnitaire(round($produit->getPrixUnitaire(), 3 ));
                $produit->setPrixTotal(round($produit->getNb() * $produit->getPrixUnitaire(), 3));
                $nbt+= $produit->getPrixTotal();
                $produit->setFacture($facture);
                $facture->addProduit($produit);
                $entityManager->persist($produit);
            }   
            $facture->setPrixHT(round(($nbt*100)/(100 + $facture->getTva()), 3));      
            $facture->setPrixTTC(round($nbt,3));
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/new.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_show", methods={"GET"})
     */
    public function show(Facture $facture): Response
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf();        
        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml($this->render('facture/show.html.twig', [
            'facture' => $facture,
        ])->getContent());
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();
        return $this->render('facture/show.html.twig', [
            'facture' => $facture,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="facture_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Facture $facture): Response
    {
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('facture_index');
        }

        return $this->render('facture/edit.html.twig', [
            'facture' => $facture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="facture_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Facture $facture): Response
    {
        if ($this->isCsrfTokenValid('delete'.$facture->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($facture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('facture_index');
    }
}
