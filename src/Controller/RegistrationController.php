<?php

namespace App\Controller;

use App\Entity\Pacjent;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        $pacjent = new Pacjent();


        $form = $this->createForm(RegistrationType::class, $pacjent);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $pacjent = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pacjent);
            $entityManager->flush();

            return $this->redirect('login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
