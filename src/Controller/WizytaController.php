<?php

namespace App\Controller;
use App\Entity\PoradniaInfo;
use App\Entity\Jednostka;
use App\Repository\PoradniaInfoRepository;
use App\Repository\JednostkaRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/wizyta")
*/
class WizytaController extends AbstractController
{
    /**
     * @Route("/", name="wizyta")
     */
    public function index(JednostkaRepository $jednostkaRepo, PoradniaInfoRepository $poradniaRepo)
    {   

        $jednostki = $jednostkaRepo->findAllWithPoradniaAndLekarz();
        $poradnie = $poradniaRepo->findAllOrderedByName();
        return $this->render('wizyta/index.html.twig', [
            'jednostki' => $jednostki,
            'poradnie' => $poradnie
        ]);
    }


    /**
     * @Route("/termin/{id}", name="wizyta_termin")
     */
    public function termin($id, Request $request, JednostkaRepository $jednostkaRepo)
    {
        $jednostka = $jednostkaRepo->findAllByJoinedId($id);
        return $this->render('wizyta/termin.html.twig', [
            'jednostka' => $jednostka,
            
        ]);
    }
}
