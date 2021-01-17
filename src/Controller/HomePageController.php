<?php

namespace App\Controller;

use App\Repository\DoctorRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home_page/index.html.twig', [
        ]);
    }

    /**
     * @Route("/doctors", name="doctors")
     */
    public function doctors(DoctorRepository $doctorRepo)
    {
        $doctors = $doctorRepo->findAllAlphabetical();

        return $this->render('home_page/doctors.html.twig', [
            'doctors' => $doctors
        ]);
    }
}
