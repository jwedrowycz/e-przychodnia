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
 * @Route("/admin/poradnie", name="admin.")
 */
class PoradniaController extends AdminPanelController
{
     /**
     * @Route("/", name="poradnie")
     */
    public function poradnie(PoradniaInfoRepository $poradniaRepo)
    {
        $poradnie = $poradniaRepo->findAll();

        return $this->render('admin_panel/poradnia/index.html.twig',[
            'poradnie' => $poradnie
        ]);
    }

    

    /**
     * @Route("/dodaj", name="poradnia_add")
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

        return $this->render('admin_panel/poradnia/add.html.twig', [
            'addPoradniaForm' => $form->createView(),
        ]);
       
    }
    
}
