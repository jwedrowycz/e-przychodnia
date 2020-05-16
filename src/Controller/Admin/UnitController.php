<?php

namespace App\Controller\Admin;

use App\Entity\Unit;
use App\Entity\Clinic;
use App\Entity\WorkTime;
use App\Form\UnitType;
use App\Repository\DoctorRepository;
use App\Repository\UnitRepository;
use App\Repository\ClinicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/unit", name="admin.")
 */
class UnitController extends AbstractController
{

    /**
     * @Route("/", name="unit")
     */
    public function index(UnitRepository $unitRepo)
    {   
        $unit = $unitRepo->findAllJoined();
        return $this->render('admin_panel/unit/index.html.twig',[
            'unit' => $unit
        ]);

    }

    /**
     * @Route("/{id}", name="unit_show")
     */
    public function show($id, Clinic $clinic)
    {   
        $unit = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findAllByJoinedId($id);
        return $this->render('admin_panel/unit/show.html.twig',[
            'doctore' => $unit,
            'clinic' => $clinic,
        ]);

    }

    /**
     * @Route("/dodaj/{idClinic}", name="unit_add")
     */
    public function add($idClinic, Request $request, DoctorRepository $doctorRepo, ClinicRepository $clinicRepo): Response
    {
        $doctore = $doctorRepo->findAllExceptAlreadyIn($idClinic);
        // $doctore = $doctorRepo->findAll();
        $clinic = $clinicRepo->find($idClinic);
        $unit = new Unit();
        $form = $this->createForm(UnitType::class, $unit);
        $form->handleRequest($request);

        return $this->render('admin_panel/unit/add.html.twig', [
            'doctore' => $doctore,
            'clinic' => $clinic
        ]);

    }
    /**
     * @Route("/utworz/{idDoctor}/{idClinic}", name="unit_create")
     */
    public function create($idDoctora, $idClinic)
    {
        $unit = new Unit();


        $entityManager = $this->getDoctrine()->getManager();
        $doctor = $entityManager->getRepository('App:Doctor')->find($idDoctora);
        $clinic = $entityManager->getRepository('App:Clinic')->find($idClinic);

        $unit->setIdLekarza($doctor);
        $unit->setIdPoradni($clinic);
        $entityManager->persist($unit);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'Pomyślnie przypisano doctora do poradni'
        );
        return $this->redirectToRoute('admin.unit_show', [
            'id'=>$idClinic
            ]);
    }

   

    /**
     * @Route("/delete/{idDoctor}/{idClinic}", name="unit_delete")
     */
    public function delete($idDoctor, $idClinic)
    {
        $entityManager = $this->getDoctrine()->getManager();



        $unit = $entityManager->getRepository('Unit')->findOneBy([
            'idClinic' => $idClinic,
            'idDoctor' => $idDoctor
        ]);

        $entityManager->remove($unit);
        $entityManager->flush();

        return $this->redirectToRoute('admin.unit_show', [
            'id'=>$idClinic
            ]);

    }



}
