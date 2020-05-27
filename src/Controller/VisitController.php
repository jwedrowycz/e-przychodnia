<?php

namespace App\Controller;
use App\Entity\Clinic;
use App\Entity\Unit;
use App\Entity\Visit;
use App\Entity\WorkTime;
use App\Repository\ClinicRepository;
use App\Repository\WorkTimeRepository;
use App\Repository\VisitRepository;
use App\Form\VisitType;
use App\Repository\UnitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/visit")
*/
class VisitController extends AbstractController
{
    /**
     * @Route("/", name="visit")
     */
    public function index(UnitRepository $unitRepo, ClinicRepository $clinicRepo)
    {   

        $units = $unitRepo->findAllWithClinicAndDoctor();
        $clinics = $clinicRepo->findAllOrderedByName();
        
        return $this->render('visit/index.html.twig', [
            'units' => $units,
            'clinics' => $clinics
        ]);
    }


    /**
     * @Route("/choice/{id}", name="visit_choose")
     */
    public function choose($id, UnitRepository $unitRepo, ClinicRepository $clinicRepo, WorkTimeRepository $workTimeRepo)
    {   
        $clinic = $clinicRepo->find($id);
        $unit = $unitRepo->findAllByJoinedId($id);
        // $j = $unitRepo->findOneById(16);
        return $this->render('visit/choice.html.twig', [
            'clinic' => $clinic,
            'unit' => $unit,
        ]);
    }

    
    public function work_time_show($idClinic, $idUnit, WorkTimeRepository $workTimeRepo, ClinicRepository $clinicRepo)
    {   
        $clinic = $clinicRepo->find($idClinic);
        $time = $workTimeRepo->findAllWithLekarzData($idUnit);
        return $this->render('visit/_worktime.html.twig', [
            'clinic' => $clinic,
            'time' => $time
        ]);
    }
    
    
    /**
     * @Route("/terms/{id}", name="visit_terms")
     */
    public function terms_show($id, WorkTimeRepository $workTimeRepo){
        $workTime = $workTimeRepo->findBy([
            'unit' => $id
        ]);
        return $this->render('visit/terms.html.twig',[
            'id' => $id,
            'workTime' => $workTime
        ]);
    }

    /**
     * @Route("/terms/reservation/{id}/", name="visit_add")
     */
    public function add($id, Request $request, UnitRepository $unitRepo, WorkTimeRepository $workTimeRepo, VisitRepository $visitRepo){
        $visit = new Visit();
        
        $unit = $unitRepo->find($id);
        $workTime = $workTimeRepo->findAllByUnitId($id);
        $doctor = $unit->getDoctor();
        $clinic = $unit->getClinic();
        $start = $request->query->get('start');
        $end = $request->query->get('end');
        $start = new \DateTime($start);
        $end = new \DateTime($end);
        $visit->setStart($start);
        $visit->setEnd($end);
        $visit->setUnit($unit);
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);
        // echo $start->format('Y-m-d H:i:s');
        // echo $end->format('Y-m-d H:i:s');
        $v = $visitRepo->findOverlapping($start,$end, $unit->getId());
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $visit->setUser($user);
            $entityManager->persist($visit);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Pomyślnie zarejestrowałeś się na badanie, przejdź na swój profil aby zobaczyć szczegóły'
                );
            return $this->redirectToRoute('visit');

        }
        $diff = $start->diff($end);

        $test = $workTimeRepo->checkWorkDay($start->format('H:i:s'), $end->format('H:i:s'), $unit->getId(), $start->format('w'));
        return $this->render('visit/reservation.html.twig', [
            'clinic' => $clinic,
            'doctor' => $doctor,
            'unit' => $unit,
            'start' => $start,
            'end' => $end,
//            'test' => $test,
//            'w' => $start->format('w'),
            'form' => $form->createView()
        ]);


    }

   
}
