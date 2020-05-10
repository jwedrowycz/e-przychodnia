<?php

namespace App\Controller\Admin;

use App\Entity\Jednostka;
use App\Entity\PoradniaInfo;
use App\Entity\CzasPracy;
use App\Form\AddJednostkaFormType;
use App\Repository\LekarzRepository;
use App\Repository\JednostkaRepository;
use App\Repository\PoradniaInfoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/jednostka", name="admin.")
 */
class JednostkaController extends AbstractController
{

    /**
     * @Route("/{id}", name="jednostka_show")
     */
    public function show($id, PoradniaInfo $poradnia)
    {   
        $jednostka = $this->getDoctrine()
            ->getRepository(Jednostka::class)
            ->findAllByJoinedId($id);
        return $this->render('admin_panel/jednostka/show.html.twig',[
            'lekarze' => $jednostka,
            'poradnia' => $poradnia,
        ]);

    }

    /**
     * @Route("/dodaj/{id_poradni}", name="jednostka_add")
     */
    public function add($id_poradni, Request $request, LekarzRepository $lekarzRepo, PoradniaInfoRepository $poradniaRepo): Response
    {
        $lekarze = $lekarzRepo->findAllExceptAlreadyIn($id_poradni);
        // $lekarze = $lekarzRepo->findAll();
        $poradnia = $poradniaRepo->find($id_poradni);
        $jednostka = new Jednostka();
        $form = $this->createForm(AddJednostkaFormType::class, $jednostka);
        $form->handleRequest($request);

        return $this->render('admin_panel/jednostka/add.html.twig', [
            'lekarze' => $lekarze,
            'poradnia' => $poradnia
        ]);

    }
    /**
     * @Route("/utworz/{id_lekarza}/{id_poradni}", name="jednostka_create")
     */
    public function create($id_lekarza, $id_poradni)
    {
        $jednostka = new Jednostka();


        $entityManager = $this->getDoctrine()->getManager();
        $lekarz = $entityManager->getRepository('App:Lekarz')->find($id_lekarza);
        $poradnia = $entityManager->getRepository('App:PoradniaInfo')->find($id_poradni);

        $jednostka->setIdLekarza($lekarz);
        $jednostka->setIdPoradni($poradnia);
        $entityManager->persist($jednostka);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'Pomyślnie przypisano lekarza do poradni'
        );
        return $this->redirectToRoute('admin.poradnia_show', [
            'id'=>$id_poradni
            ]);
    }

   

    /**
     * @Route("/delete/{idLekarza}/{idPoradni}", name="jednostka_delete")
     */
    public function delete($idLekarza, $idPoradni)
    {
        $entityManager = $this->getDoctrine()->getManager();



        $jednostka = $entityManager->getRepository('App:Jednostka')->findOneBy([
            'id_poradni' => $idPoradni,
            'id_lekarza' => $idLekarza
        ]);

        $entityManager->remove($jednostka);
        $entityManager->flush();

        return $this->redirectToRoute('admin.jednostka_show', [
            'id'=>$idPoradni
            ]);

    }



}
