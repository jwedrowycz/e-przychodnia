<?php

namespace App\Controller;
use App\Entity\Clinic;
use App\Entity\Unit;
use App\Entity\Visit;
use App\Entity\WorkTime;
use App\Repository\ClinicRepository;
use App\Repository\WorkTimeRepository;
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

        $units = $unitRepo->findAllWithPoradniaAndLekarz();
        $clinics = $clinicRepo->findAllOrderedByName();
        
        return $this->render('visit/index.html.twig', [
            'units' => $units,
            'clinics' => $clinics
        ]);
    }


    /**
     * @Route("/wybor/{id}", name="visit_choose")
     */
    public function choose($id, Request $request, UnitRepository $unitRepo, ClinicRepository $clinicRepo, WorkTimeRepository $workTimeRepo)
    {   
        $clinic = $clinicRepo->find($id);
        $unit = $unitRepo->findAllByJoinedId($id);
        // $j = $unitRepo->findOneById(16);
        return $this->render('visit/wybor.html.twig', [
            'clinic' => $clinic,
            'unit' => $unit,
        ]);
    }

    
    public function work_time_show($idClinic, $idUnit, Request $request, WorkTimeRepository $workTimeRepo, ClinicRepository $clinicRepo)
    {   
        $clinic = $clinicRepo->find($idClinic);
        $time = $workTimeRepo->findAllWithLekarzData($idUnit);
        return $this->render('visit/_time.html.twig', [
            'clinic' => $clinic,
            'time' => $time
        ]);
    }
    
    
    /**
     * @Route("/terminy/{id}", name="visit_terminy")
     */
    public function terminy_show($id, WorkTimeRepository $workTimeRepo){
        $workTime = $workTimeRepo->findBy([
            'unit' => $id
        ]);
        return $this->render('visit/terminy.html.twig',[
            'id' => $id,
            'workTime' => $workTime
        ]);
    }

    /**
     * @Route("/terminy/rezerwuj/{id}/", name="visit_add")
     */
    public function add($id, Request $request, UnitRepository $unitRepo){
        $visit = new Visit();
        
        $unit = $unitRepo->find($id);
        $lekarz = $unit->getIdLekarza();
        $clinic = $unit->getIdPoradni();
        $start = $request->query->get('poczatek');
        $end = $request->query->get('koniec');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(VisitType::class, $visit);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $visit->setJednostka($unit);
            $visit->setPacjent($user);
            $visit->setRozpoczecie(new \DateTime($start));
            $visit->setZakonczenie(new \DateTime($end));
            $entityManager->persist($visit);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Pomyślnie zarejestrowałeś się na badanie, przejdź na swój profil aby zobaczyć szczegóły'
                );
            return $this->redirectToRoute('visit');
            
        }
        return $this->render('visit/rezerwuj.html.twig', [
            'clinic' => $clinic,
            'doctor' => $lekarz,
            'unit' => $unit,
            'start' => $start,
            'end' => $end,
            'form' => $form->createView()
        ]);


    }

   
}
