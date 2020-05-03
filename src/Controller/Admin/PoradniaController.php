<?php

namespace App\Controller\Admin;


use App\Entity\Jednostka;
use App\Entity\PoradniaInfo;
use App\Repository\PoradniaInfoRepository;
use App\Form\AddPoradniaFormType;
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
     * @Route("/poradnia/add", name="poradnia_add")
     */
    public function poradnia_add(Request $request): Response
    {
        $poradnia = new PoradniaInfo();
        $form = $this->createForm(AddPoradniaFormType::class, $poradnia);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($poradnia);
            $entityManager->flush();

            return $this->redirectToRoute('admin.poradnie', ['msg'=>'success']);
            
        }
        return $this->render('admin_panel/poradnie/poradnia_add.html.twig', [
            'addPoradniaForm' => $form->createView(),
        ]);
       
    }

    
}
