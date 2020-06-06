<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Repository\UserRepository;
use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     * @param VisitRepository $visitRepo
     * @return Response
     */
    public function index(VisitRepository $visitRepo)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $countVisits = $visitRepo->countAllUserVisits($user);

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'countVisits' => $countVisits
        ]);
    }
    //TODO: ZROBIĆ EDYCJE DANYCH, ZMIANE HASŁA, PRZEGLĄD WIZYT -- W PRZYSZŁOŚCI DORZUCIĆ HISTORIE CHOROBY
}
