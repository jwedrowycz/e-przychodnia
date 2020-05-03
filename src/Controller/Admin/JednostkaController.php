<?php

namespace App\Controller\Admin;

use App\Entity\Jednostka;
use App\Form\AddJednostkaFormType;
use App\Repository\LekarzRepository;
use App\Repository\PoradniaInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin.")
 */
class JednostkaController extends AbstractController
{

    /**
     * @Route("/poradnia/jednostka/dodaj/{id_poradni}", name="jednostka_add")
     */
    public function jednostka_add($id_poradni, Request $request, LekarzRepository $lekarzRepo, PoradniaInfoRepository $poradniaRepo): Response
    {
        $lekarze = $lekarzRepo->findAll();
        $poradnia = $poradniaRepo->find($id_poradni);
        $jednostka = new Jednostka();
        $form = $this->createForm(AddJednostkaFormType::class, $jednostka);
        $form->handleRequest($request);

        return $this->render('admin_panel/poradnie/jednostka_add.html.twig', [
            'lekarze' => $lekarze,
            'poradnia' => $poradnia
        ]);

    }
    /**
     * @Route("/poradnia/jednostka/create/{id_lekarza}/{id_poradni}", name="jednostka_create")
     */
    public function jednostka_create($id_lekarza, $id_poradni)
    {
        $jednostka = new Jednostka();


        $entityManager = $this->getDoctrine()->getManager();
        $lekarz = $entityManager->getRepository('App:Lekarz')->find($id_lekarza);
        $poradnia = $entityManager->getRepository('App:PoradniaInfo')->find($id_poradni);

        $jednostka->setIdLekarza($lekarz);
        $jednostka->setIdPoradni($poradnia);
        $entityManager->persist($jednostka);
        $entityManager->flush();

        return $this->redirectToRoute('admin.poradnia_show', ['id'=>$id_poradni]);


    }

    /**
     * @Route("/poradnia/jednostka/delete/{idLekarza}/{idPoradni}", name="jednostka_delete")
     */
    public function jednostka_delete(Int $idLekarza, Int $idPoradni)
    {
        $entityManager = $this->getDoctrine()->getManager();



        $jednostka = $entityManager->getRepository('App:Jednostka')->findOneBy([
            'id_poradni' => $idPoradni,
            'id_lekarza' => $idLekarza
        ]);
//        $jednostka = $entityManager->getRepository('App:Jednostka')->find(3);

//        $lek = $jednostka->getIdLekarza()->getImie();
        $entityManager->remove($jednostka);
        $entityManager->flush();
//        return $this->render('admin_panel/poradnie/test.html.twig', [
//            'jednostka' => $jednostka
//        ]);
        return $this->redirectToRoute('admin.poradnia_show', ['id'=>$idPoradni]);

    }



}
