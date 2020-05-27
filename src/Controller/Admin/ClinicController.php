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
     * @Route("/", name="clinics")
     */
    public function clinics(Request $request, ClinicRepository $clinicRepo)
    {
        $clinics = $clinicRepo->findAll();

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
            return $this->redirectToRoute('admin.clinics');

        }
        return $this->render('admin_panel/clinic/index.html.twig',[
            'clinics' => $clinics,
            'form' => $form->createView(),
        ]);
    }

    

    /**
     * @Route("/delete/{id}", name="clinic_delete")
     */
    public function delete($id, Clinic $clinic)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($clinic);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'Poradnia została pomyślnie usunięta'
        );
        return $this->redirectToRoute('admin.clinics');

       
    }
    
}
