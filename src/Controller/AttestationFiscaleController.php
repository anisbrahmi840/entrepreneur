<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\AttestationFiscale;
use App\Form\AttestationSearchType;
use App\Form\AttestationFiscaleType;
use App\Entity\AttestationChiffreAffaire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AttestationFiscaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/entrepreneur/attestation/fiscale")
 */
class AttestationFiscaleController extends AbstractController
{
    /**
     * @Route("/", name="attestation_fiscale_index")
     */
    public function index(AttestationFiscaleRepository $attestationFiscaleRepository, Request $request): Response
    {
        $entrepreneur = $this->getUser();
        $attestationsfiscale = $entrepreneur->getAttestationFiscales();
        $form = $this->createForm(AttestationSearchType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $date= $form->getData()['Date']; 
            foreach ($attestationsfiscale as $attestation) {
                if($attestation->getAnnee() == $date){
                    $this->toDelete($attestation->getRef());
                }
            }
           
            $entityManager = $this->getDoctrine()->getManager();
            $attestationsfiscale = new AttestationFiscale();
            $attestationsfiscale
                ->setDateCr(new \DateTime())
                ->setEntrepreneur($entrepreneur)
                ->setRef(uniqid('AFi-'))
                ->setAnnee($date)
                ->setNom("Attestation Fiscale")
                ;
            $declarations = $entrepreneur->getDeclarations();
            $declarationsAnnee =[];
            foreach ($declarations as $declaration) {
                if($declaration->getPaiement() && $declaration->getEtat() && $declaration->getDateCr()->format('Y') == $date)
                    $declarationsAnnee[] = $declaration;
            }
            if(count($declarationsAnnee) == 0){
                $this->addFlash('error', "Il n'y a pas des des déclarations pour cette année");
                return $this->redirectToRoute('attestation_fiscale_index');
            }else{
                foreach ($declarationsAnnee as $key => $declaration) {                
                    $attestationsfiscale->addDeclaration($declaration);
                }
            }
            $entityManager->persist($attestationsfiscale);
            $entityManager->flush();
            return $this->redirectToRoute('attestation_fiscale_index');
        }
        return $this->render('attestation_fiscale/index.html.twig', [
            'attestations' => $entrepreneur->getAttestationFiscales(),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="attestation_fiscale_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attestationFiscale = new AttestationFiscale();
        $form = $this->createForm(AttestationFiscaleType::class, $attestationFiscale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attestationFiscale);
            $entityManager->flush();

            return $this->redirectToRoute('attestation_fiscale_index');
        }

        return $this->render('attestation_fiscale/new.html.twig', [
            'attestation_fiscale' => $attestationFiscale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{ref}", name="attestation_fiscale_show", methods={"GET"})
     */
    public function show(AttestationFiscale $attestationFiscale): Response
    {
        $options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf();        
        $dompdf->setOptions($options);
        $dompdf->output();
        $dompdf->loadHtml($this->render('attestation_fiscale/show.html.twig', [
            'attestation_fiscale' => $attestationFiscale,
        ])->getContent());
        
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');
        
        // Render the HTML as PDF
        $dompdf->render();
        
        // Output the generated PDF to Browser
        $dompdf->stream();

        return $this->render('attestation_fiscale/show.html.twig', [
            'attestation_fiscale' => $attestationFiscale,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attestation_fiscale_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AttestationFiscale $attestationFiscale): Response
    {
        $form = $this->createForm(AttestationFiscaleType::class, $attestationFiscale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attestation_fiscale_index');
        }

        return $this->render('attestation_fiscale/edit.html.twig', [
            'attestation_fiscale' => $attestationFiscale,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attestation_fiscale_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AttestationFiscale $attestationFiscale): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attestationFiscale->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attestationFiscale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attestation_fiscale_index');
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
