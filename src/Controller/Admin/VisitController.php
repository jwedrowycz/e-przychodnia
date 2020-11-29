<?php

namespace App\Controller\Admin;

use App\Entity\Visit;
use App\Form\Filter\VisitsFilterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\VisitRepository;
use App\Repository\DoctorRepository;
use App\Repository\ClinicRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
     * @param Request $request
     * @param VisitRepository $visitRepo
     * @return Response
     */
    public function index(Request $request, VisitRepository $visitRepo): Response
    {
        $visits = $visitRepo->findAllWithJoined('','', 0);
        $form = $this->createForm(VisitsFilterType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $clinic = $form->get('clinic')->getData();
            $clinic = empty($clinic) ? '' : $clinic->getId();

            $doctor = $form->get('doctor')->getData();
            $doctor = empty($doctor) ? '' : $doctor->getDoctor()->getId();

            $visitType = $form->get('type')->getData();
            $visitStatus = $form->get('status')->getData();

            $visits = $visitRepo->findAllWithJoined($clinic, $doctor, $visitType, $visitStatus);
        }

        return $this->render('admin_panel/visit/visits.html.twig', [
            'visits' => $visits,
            'form' => $form->createView(),

        ]);
    }


    /**
     * @Route("/delete/{id}", name="visit_delete")
     * @param Visit $visit
     * @return RedirectResponse
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

    /**
     * @Route("/cancel/{id}", name="visit_cancel")
     * @param Visit $visit
     * 
     */
    public function cancel(Visit $visit)
    {   
        $entityManager = $this->getDoctrine()->getManager();
        $visit->setStatus(1);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Pomyślnie anulowano wizytę'
        );

        return $this->redirectToRoute('admin.visits');
    }
}
