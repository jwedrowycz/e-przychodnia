<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\WorkTimeFormType;
use App\Entity\WorkTime;
use App\Entity\Unit;
use App\Repository\UnitRepository;
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
        $form = $this->createForm(WorkTimeFormType::class, $time);
        $request = $requestStack->getMasterRequest();
        
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $unit = $entityManager->getRepository('Unit.php')->find($id);

            $time->setUnits($unit);
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
     * @Route("/work_time/{id}", name="work_time", methods={"GET", "POST"})
     */
    public function showAndAdd($id, unitRepository $unitRepo, Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        
        $time = $entityManager->getRepository('App:WorkTime')->findAllByUnitId($id);
        $unit = $this->getDoctrine()
            ->getRepository(Unit::class)
            ->findOneById($id);
        
        $timeGet = new WorkTime();

        $form = $this->createForm(WorkTimeFormType::class, $timeGet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $unitId = $entityManager->getRepository('Unit.php')->find($id);

            $timeGet->setUnits($unitId);
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
    public function delete($id, $idUnit, WorkTime $time)
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
