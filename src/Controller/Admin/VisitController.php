<?php

namespace App\Controller\Admin;

use App\Entity\Visit;
use App\Form\Filter\FilterType;
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
        $visits = $visitRepo->findAllWithJoined('','');
        $form = $this->createForm(FilterType::class);
        $form->handleRequest($request);
        $t1 = 0;
        $t2 = 0;
        if($form->isSubmitted()) {
            $clinic = $form->get('clinic')->getData();
            $clinic = empty($clinic) ? '' : $clinic->getName();

            $doctor = $form->get('doctor')->getData();
            $doctor = empty($doctor) ? '' : $doctor->getId();

            $visits = $visitRepo->findAllWithJoined($clinic, $doctor);
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
}
