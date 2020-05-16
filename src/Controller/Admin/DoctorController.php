<?php

namespace App\Controller\Admin;

use App\Entity\Doctor;
use App\Repository\DoctorRepository;
use App\Form\DoctorType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin/doctors", name="admin.")
 */
class DoctorController extends AbstractController
{
    /**
     * @Route("/", name="doctors")
     */
    public function doctors(DoctorRepository $doctorRepo )
    {   
        $doctors = $doctorRepo->findAll();

        return $this->render('admin_panel/doctor/index.html.twig', [
            'doctors' => $doctors
        ]);
    }

    /**
     * @Route("/add", name="doctor_add")
     */
    public function add(Request $request)
    {   
        $doctor = new Doctor();
        $form = $this->createForm(DoctorType::class, $doctor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($doctor);
            $entityManager->flush();
            $this->addFlash(
            'success',
            'Pomyślnie dodano doctora'
            );
            return $this->redirectToRoute('admin.doctors');

        }
        return $this->render('admin_panel/doctor/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    
    /**
     * @Route("/delete/{id}", name="doctor_delete")
     */
    public function delete(Request $request, Doctor $doctor)
    {    
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($doctor);
        $entityManager->flush();   
        
        $this->addFlash(
            'success',
            'Pomyślnie usunięto doctora'
            );
        return $this->redirectToRoute('admin.doctors');
    }



    /**
     * @Route("/edit/{id}", name="doctor_edit")
     */
    public function edit(Request $request, Doctor $doctor): Response
    {
        $form = $this->createForm(DoctorType::class, $doctor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Pomyślnie usunięto doctora'
                );
            return $this->redirectToRoute('admin.doctors');
            
        }

        return $this->render('admin_panel/doctor/edit.html.twig', [
            'doctor' => $doctor,
            'form' => $form->createView(),
        ]);
    }

}