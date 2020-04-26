<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AppointmentController extends AbstractController
{
    /**
     * @Route("/rejestracja", name="rejestracja")
     */
    public function index()
    {
        return $this->render('appointment/index.html.twig', [

        ]);
    }
}
