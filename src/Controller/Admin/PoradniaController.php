<?php

namespace App\Controller\Admin;


use App\Entity\Jednostka;
use App\Entity\PoradniaInfo;
use App\Repository\PoradniaInfoRepository;
use App\Form\AddPoradniaFormType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin", name="admin.")
 */
class PoradniaController extends AdminPanelController
{
     /**
     * @Route("/poradnie", name="poradnie")
     */
    public function poradnie(PoradniaInfoRepository $poradniaRepo)
    {
        $poradnie = $poradniaRepo->findAll();

        return $this->render('admin_panel/poradnie/poradnie.html.twig',[
            'poradnie' => $poradnie
        ]);
    }

    /**
     * @Route("/poradnie/{id}", name="poradnia_show")
     */
    public function poradnia_show($id, PoradniaInfo $poradnia)
    {   
    
        $jednostka = $this->getDoctrine()
            ->getRepository(Jednostka::class)
            ->findAllByJoinedId($id);
        return $this->render('admin_panel/poradnie/poradnia_show.html.twig',[
            'lekarze' => $jednostka,
            'poradnia' => $poradnia,
            
        ]);

    }

    /**
     * @Route("/poradnia/dodaj", name="poradnia_add")
     */
    public function poradnia_add(Request $request)
    {
        $poradnia = new PoradniaInfo();
        $form = $this->createForm(AddPoradniaFormType::class, $poradnia);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($poradnia);
            $entityManager->flush();

             $this->addFlash(
            'success',
            'Poradnia została pomyślnie dodana'
        );
            return $this->redirectToRoute('admin.poradnie');

        }

        return $this->render('admin_panel/poradnie/poradnia_add.html.twig', [
            'addPoradniaForm' => $form->createView(),
        ]);
       
    }

//     /**
//     * @Route("/poradnia/usun/{id}", name="poradnia_delete")
//     */
//    public function poradnia_delete(PoradniaInfo $poradniaInfo)
//    {
//        $entityManager = $this->getDoctrine()->getManager();
//        try {
//            $entityManager->remove($poradniaInfo);
//            $entityManager->flush();
//            $this->addFlash(
//            'success',
//            'Pomyślnie usunięto jednostkę'
//        );
//            return $this->redirectToRoute('admin.poradnie');
//
//        }
//        catch (\PDOException $e) {
//            $this->addFlash(
//            'fail',
//            'Nie możesz usunąć tej poradni, prawdopodobnie jest w użyciu'
//        );
//            return $this->redirectToRoute('admin.poradnie');
//        }


//    }

    
}
