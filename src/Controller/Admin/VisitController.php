<?php

namespace App\Controller\Admin;

use App\Entity\Visit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VisitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



/**
 * @Route("/admin/visits", name="admin.")
 */
class VisitController extends AbstractController
{
    /**
     * @Route("/", name="visits")
     */
    public function index(VisitRepository $visitRepo)
    {   
        $visit = $visitRepo->findAllWithJoined();
    

        return $this->render('admin_panel/visit/visits.html.twig', [
            'visit' => $visit,
            // 'pacjent' => $pacjent
        ]);
    }

    /**
     * @Route("/delete/{id}", name="visit_delete")
     */
    public function delete(Visit $visit)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($visit);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'Pomyślnie usunięto wizytę'
        );

        return $this->redirectToRoute('admin.visits');
    }
}
