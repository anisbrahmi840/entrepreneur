<?php

namespace App\Controller;

use App\Repository\DeclarationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SoldeController extends AbstractController
{
    /**
     * @Route("/entreprenuer/solde", name="solde_index")
     * @Security("is_granted('ROLE_USER') and user.getEtat()===true")
     */
    public function index(DeclarationRepository $declarationRepository): Response
    {
        $declarations = $declarationRepository->findBy(['entrepreneur' => $this->getUser()]);
        $totalDeclare = 0;
        $totaleDeclareCetteAnnee = 0;
        $totalePaye = 0;
        $totalePayeCetteAnnee = 0;
        foreach ($declarations as $declaration) {
            $totalDeclare  += $declaration->getChiffre();
            if ( $declaration->getDateDec() && $declaration->getDateDec()->format('Y') === date('Y')){
                $totaleDeclareCetteAnnee += $declaration->getChiffre();
            } 
            if ($declaration->getPaiement() && $declaration->getPaiement()->getEtat() && $declaration->getPaiement()->getEtatEnt()){
                if( $declaration->getPaiement()->getDatePai()  && $declaration->getPaiement()->getDatePai()->format('Y') === date('Y'))
                    $totalePayeCetteAnnee += $declaration->getTotalapayer();
            }
            if( $declaration->getPaiement() && $declaration->getPaiement()->getEtat() && $declaration->getPaiement()->getEtatEnt())
                $totalePaye += $declaration->getTotalapayer();
        }
        return $this->render('solde/index.html.twig', [
            'totalDeclare' => $totalDeclare,
            'totaleDeclareCetteAnnee' => $totaleDeclareCetteAnnee,
            'totalePaye' => $totalePaye,
            'totalePayeCetteAnnee' => $totalePayeCetteAnnee,
        ]);
    }
}
