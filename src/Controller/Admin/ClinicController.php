<?php

namespace App\Controller\Admin;


use App\Entity\Unit;
use App\Entity\Clinic;
use App\Repository\ClinicRepository;
use App\Form\ClinicType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin/clinics", name="admin.")
 */
class ClinicController extends AdminPanelController
{
     /**
     * @Route("/", name="clinics_show")
     */
    public function show(ClinicRepository $clinicRepo)
    {
        $clinics = $clinicRepo->findAll();

        return $this->render('admin_panel/clinic/index.html.twig',[
            'clinics' => $clinics
        ]);
    }

    

    /**
     * @Route("/add", name="clinic_add")
     */
    public function clinic_add(Request $request)
    {
        $clinic = new Clinic();
        $form = $this->createForm(ClinicType::class, $clinic);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clinic);
            $entityManager->flush();

             $this->addFlash(
            'success',
            'Poradnia została pomyślnie dodana'
        );
            return $this->redirectToRoute('admin.clinics_show');

        }

        return $this->render('admin_panel/clinic/add.html.twig', [
            'form' => $form->createView(),
        ]);
       
    }
    
}
