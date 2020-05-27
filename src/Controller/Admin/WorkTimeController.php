<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\WorkTimeType;
use App\Entity\WorkTime;
use App\Entity\Unit;
use App\Repository\UnitRepository;
use App\Repository\WorkTimeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @Route("/admin", name="admin.")
 */
class WorkTimeController extends AbstractController
{

    public function add($id, RequestStack $requestStack)
    {   

        $time = new WorkTime();
        $form = $this->createForm(WorkTimeType::class, $time);
        $request = $requestStack->getMasterRequest();
        
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $unit = $entityManager->getRepository('App:Unit')->find($id);

            $time->setUnit($unit);
            $entityManager->persist($time);
            $entityManager->flush();

             $this->addFlash(
                'success',
                'Czas pracy dla jednostki został dodany'
                );
            ;
        }
        return $this->render('admin_panel/work_time/_add.html.twig', [
            'form' => $form->createView(),
            'unit' => $id
        ]);
    }

    /**
     * @Route("/work-time/{id}", name="work_time", methods={"GET", "POST"})
     */
    public function showAndAdd($id, unitRepository $unitRepo, Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        
        $time = $entityManager->getRepository('App:WorkTime')->findAllByUnitId($id);
        $unit = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findOneBy(['id'=>$id]);
        
        $timeGet = new WorkTime();

        $form = $this->createForm(WorkTimeType::class, $timeGet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $unitId = $entityManager->getRepository('App:Unit')->find($id);

            $timeGet->setUnit($unitId);
            $entityManager->persist($timeGet);
            $entityManager->flush();

             
            return $this->redirectToRoute('admin.work_time', [
                'id'=>$id
                ]);
        }
    
        return $this->render('admin_panel/work_time/index.html.twig', [
            'id' => $id,
            'time' => $time,
            'unit' => $unit,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/work_time/delete/{id}/{idUnit}", name="work_time-delete")
     */
    public function delete($idUnit, WorkTime $time)
    {   

        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($time);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'Czas pracy został pomyślnie usunięty'
            );
        return $this->redirectToRoute('admin.work_time', [
            'id'=>$idUnit
            ]);

    }
}
