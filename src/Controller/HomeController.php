<?php

namespace App\Controller;

use App\Entity\Actualite;
use App\Repository\ActualiteRepository;
use App\Repository\TemoignageRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Entrepreneur | Home',
            'actualites' => $actualiteRepository->getActualites(),
        ]);
    }

    /**
     * @Route("/actualite/{ref}", name="actualite_show_entrepreneur", methods={"GET"})
     */
    public function show(Actualite $actualite, ActualiteRepository $actualiteRepository): Response
    {
        return $this->render('home/actualite/show.html.twig', [
            'actualite' => $actualite,            
            'actualites' => $actualiteRepository->getActualites()
        ]);
    }
    /**
     * @Route("/actualite", name="actualite_index_entrepreneur", methods={"GET"})
     */
    public function indexActualite(Request $request, ActualiteRepository $actualiteRepository, PaginatorInterface $paginator): Response
    {
        return $this->render('home/actualite/index.html.twig', [           
            'actualites' => $paginator->paginate($actualiteRepository->findAll(), $request->query->getInt('page',1), 6),
        ]);
    }

    /**
     * @Route("/faq", name="faq_index")
     */
    public function faq(): Response
    {
        return $this->render('home/faq/show.html.twig');
    }

    /**
     * @Route("temoignage" , name="temoignage_index_entrepreneur")
     */
    public function showTemoignage(TemoignageRepository $temoignageRepository, PaginatorInterface $paginator, Request $request){

        return $this->render('home/temoignage/show.html.twig', [
            'temoignages' => $paginator->paginate($temoignageRepository->findAll(), $request->query->getInt('page',1),4)
        ]);
    }

    /**
     * @Route("/apropos", name="apropos_index")
     */
    public function apropos(){
        return $this->render('home/apropos/apropos.html.twig');
    }
    
    /**
     * @Route("/contactus", name="contactus_index")
     */
    public function contactUs(){
        return $this->render('home/contactus/contactus.html.twig');
    }
}
