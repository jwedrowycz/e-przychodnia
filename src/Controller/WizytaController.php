<?php

namespace App\Controller;
use App\Entity\PoradniaInfo;
use App\Entity\Unit;
use App\Entity\Visit;
use App\Entity\CzasPracy;
use App\Repository\PoradniaInfoRepository;
use App\Repository\CzasPracyRepository;
use App\Form\WizytaFormType;
use App\Repository\UnitRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Security;


/**
 * @Route("/wizyta")
*/
class WizytaController extends AbstractController
{
    /**
     * @Route("/", name="wizyta")
     */
    public function index(UnitRepository $jednostkaRepo, PoradniaInfoRepository $poradniaRepo)
    {   

        $jednostki = $jednostkaRepo->findAllWithPoradniaAndLekarz();
        $poradnie = $poradniaRepo->findAllOrderedByName();
        
        return $this->render('wizyta/index.html.twig', [
            'jednostki' => $jednostki,
            'poradnie' => $poradnie
        ]);
    }


    /**
     * @Route("/wybor/{id}", name="wizyta_choose")
     */
    public function choose($id, Request $request, UnitRepository $jednostkaRepo, PoradniaInfoRepository $poradniaRepo, CzasPracyRepository $czasPracyRepo)
    {   
        $poradnia = $poradniaRepo->find($id);
        $jednostka = $jednostkaRepo->findAllByJoinedId($id);
        // $j = $jednostkaRepo->findOneById(16);
        return $this->render('wizyta/wybor.html.twig', [
            'poradnia' => $poradnia,
            'unit' => $jednostka,
        ]);
    }

    
    public function czas_pracy_show($idPoradni, $idJednostki, Request $request, CzasPracyRepository $czasPracyRepo, PoradniaInfoRepository $poradniaRepo)
    {   
        $poradnia = $poradniaRepo->find($idPoradni);
        $czas = $czasPracyRepo->findAllWithLekarzData($idJednostki);
        return $this->render('wizyta/_czas.html.twig', [
            'poradnia' => $poradnia,
            'czas' => $czas
        ]);
    }
    
    
    /**
     * @Route("/terminy/{id}", name="wizyta_terminy")
     */
    public function terminy_show($id, CzasPracyRepository $czasPracyRepo){
        $czasPracy = $czasPracyRepo->findBy([
            'unit' => $id
        ]);
        return $this->render('wizyta/terminy.html.twig',[
            'id' => $id,
            'czasPracy' => $czasPracy
        ]);
    }

    /**
     * @Route("/terminy/rezerwuj/{id}/", name="wizyta_add")
     */
    public function add($id, Request $request, UnitRepository $jednostkaRepo){
        $wizyta = new Visit();
        
        $jednostka = $jednostkaRepo->find($id);
        $lekarz = $jednostka->getIdLekarza();
        $poradnia = $jednostka->getIdPoradni();
        $start = $request->query->get('poczatek');
        $end = $request->query->get('koniec');
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(WizytaFormType::class, $wizyta);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $wizyta->setJednostka($jednostka);
            $wizyta->setPacjent($user);
            $wizyta->setRozpoczecie(new \DateTime($start));
            $wizyta->setZakonczenie(new \DateTime($end));
            $entityManager->persist($wizyta);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Pomyślnie zarejestrowałeś się na badanie, przejdź na swój profil aby zobaczyć szczegóły'
                );
            return $this->redirectToRoute('wizyta');
            
        }
        return $this->render('wizyta/rezerwuj.html.twig', [
            'poradnia' => $poradnia,
            'doctor' => $lekarz,
            'unit' => $jednostka,
            'start' => $start,
            'end' => $end,
            'form' => $form->createView()
        ]);


    }

   
}
