<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\AttestationChiffreAffaire;
use App\Form\AttestationChiffreAffaireType;
use App\Form\AttestationSearchType;
use App\Repository\AttestationChiffreAffaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/entrepreneur/attestation/chiffreaffaire")
 */
class AttestationChiffreAffaireController extends AbstractController
{
    /**
     * @Route("/", name="attestation_chiffre_affaire_index")
     */
    public function index(AttestationChiffreAffaireRepository $attestationChiffreAffaireRepository, Request $request): Response
    {
        $entrepreneur = $this->getUser();
        $attestationsChiffreAffaire = $entrepreneur->getAttestationChiffreAffaires();
        $form = $this->createForm(AttestationSearchType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $date= $form->getData()['Date']; 
            foreach ($attestationsChiffreAffaire as $attestation) {
                if($attestation->getAnnee() == $date){
                    $this->toDelete($attestation->getRef());
                }
            }
           
            $entityManager = $this->getDoctrine()->getManager();
            $attestationChiffreAffaire = new AttestationChiffreAffaire();
            $attestationChiffreAffaire
                ->setDate(new \DateTime())
                ->setEntrepreneur($entrepreneur)
                ->setRef(uniqid('ACh-'))
                ->setAnnee($date)
                ->setNom("Attestation chiffre d'affaire")
                ;
            $declarations = $entrepreneur->getDeclarations();
            $declarationsAnnee =[];
            foreach ($declarations as $declaration) {
                if($declaration->getEtat() && $declaration->getDateCr()->format('Y') == $date)
                    $declarationsAnnee[] = $declaration;
            }
            if(count($declarationsAnnee) == 0){
                $this->addFlash('error', "Il n'y a pas des des déclarations pour cette année");
                return $this->redirectToRoute('attestation_chiffre_affaire_index');
            }else{
                foreach ($declarationsAnnee as $key => $declaration) {                
                    $attestationChiffreAffaire->addDeclaration($declaration);
                }
            }
        
            $entityManager->persist($attestationChiffreAffaire);
            $entityManager->flush();
            return $this->redirectToRoute('attestation_chiffre_affaire_index');
        }
        return $this->render('attestation_chiffre_affaire/index.html.twig', [
            'attestations' => $entrepreneur->getAttestationChiffreAffaires(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="attestation_chiffre_affaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attestationChiffreAffaire = new AttestationChiffreAffaire();
        $form = $this->createForm(AttestationChiffreAffaireType::class, $attestationChiffreAffaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attestationChiffreAffaire);
            $entityManager->flush();

            return $this->redirectToRoute('attestation_chiffre_affaire_index');
        }

        return $this->render('attestation_chiffre_affaire/new.html.twig', [
            'attestation_chiffre_affaire' => $attestationChiffreAffaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{ref}", name="attestation_chiffre_affaire_show", methods={"GET"})
     */
    public function show(AttestationChiffreAffaire $attestationChiffreAffaire): Response
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf();        
        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml($this->render('attestation_chiffre_affaire/show.html.twig', [
            'attestation_chiffre_affaire' => $attestationChiffreAffaire,
        ])->getContent());
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();

        return $this->render('attestation_chiffre_affaire/show.html.twig', [
            'attestation_chiffre_affaire' => $attestationChiffreAffaire,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attestation_chiffre_affaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AttestationChiffreAffaire $attestationChiffreAffaire): Response
    {
        $form = $this->createForm(AttestationChiffreAffaireType::class, $attestationChiffreAffaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attestation_chiffre_affaire_index');
        }

        return $this->render('attestation_chiffre_affaire/edit.html.twig', [
            'attestation_chiffre_affaire' => $attestationChiffreAffaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{ref}", name="attestation_chiffre_affaire_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AttestationChiffreAffaire $attestationChiffreAffaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attestationChiffreAffaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attestationChiffreAffaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attestation_chiffre_affaire_index');
    }

    /**
     * @Route("/{ref}", name="attestation_chiffre_affaire_delete")
     */
    public function toDelete(string $ref)
    {
        $attestationChiffreAffaireRepository = $this->getDoctrine()->getRepository(AttestationChiffreAffaire::class);
        $attestationChiffreAffaire = $attestationChiffreAffaireRepository->findBy(['ref' => $ref])[0];
        $request = new Request();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attestationChiffreAffaire);
    }
}
