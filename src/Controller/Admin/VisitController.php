<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VisitRepository;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/wizyty", name="admin.")
 */
class VisitController extends AbstractController
{
    /**
     * @Route("/", name="visit")
     */
    public function index(VisitRepository $visitRepo)
    {   
        $visit = $visitRepo->findAllWithJoined();
    

        return $this->render('admin_panel/visit/visit.html.twig', [
            'visit' => $visit,
            // 'pacjent' => $pacjent
        ]);
    }
}
