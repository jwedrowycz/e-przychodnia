<?php

namespace App\Controller;

use App\Entity\Visit;
use App\Repository\UserRepository;
use App\Repository\VisitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile", name="profile.")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param VisitRepository $visitRepo
     * @return Response
     */
    public function index(VisitRepository $visitRepo)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $countVisits = $visitRepo->countAllUserVisits($user);
        $visits = $visitRepo->findAssociatedVisits($user);
        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'visits' => $visits,
            'countVisits' => $countVisits
        ]);
    }


    /**
     * @Route("/visit/{id}", name="visit_show")
     * @param $id
     * @param VisitRepository $visitRepository
     * @return Response
     */
    public function show($id, VisitRepository $visitRepository)
    {
        return $this->render('profile/show.html.twig', [

        ]);
    }
    //TODO: ZROBIĆ EDYCJE DANYCH, ZMIANE HASŁA, PRZEGLĄD WIZYT -- W PRZYSZŁOŚCI DORZUCIĆ HISTORIE CHOROBY
}
