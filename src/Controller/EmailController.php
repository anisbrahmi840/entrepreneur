<?php

namespace App\Controller;

use App\Form\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmailController extends AbstractController
{
    /**
     * @Route("/contactus", name="contactus_index")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(EmailType::class, null);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message($request->request->get('email')['sujet']))
            ->setFrom($request->request->get('email')['email'])
            ->setTo('entrepreneur840@gmail.com')
            ->setBody(
                $this->renderView(
                    // templates/hello/email.txt.twig
                    'email/index.html.twig', [ 'message' => $request->request->get('email')['message'] ]
                )
            )
        ;
        $mailer->send($message);
         return $this->redirectToRoute('contactus_index');
        }
        return $this->render('home/contactus/contactus.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
