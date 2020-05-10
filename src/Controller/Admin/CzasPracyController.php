<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CzasPracyFormType;
use App\Entity\CzasPracy;
use App\Entity\Jednostka;
use App\Repository\JednostkaRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;


/**
 * @Route("/admin", name="admin.")
 */
class CzasPracyController extends AbstractController
{

    public function add($id, RequestStack $requestStack)
    {   

        $czas = new CzasPracy();
        $form = $this->createForm(CzasPracyFormType::class, $czas);
        $request = $requestStack->getMasterRequest();
        
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $jednostka = $entityManager->getRepository('App:Jednostka')->find($id);

            // $data = $form->getData();            
            $czas->setJednostka($jednostka);
            $entityManager->persist($czas);
            $entityManager->flush();

             $this->addFlash(
                'success',
                'Czas pracy dla jednostki został dodany'
                );
            ;
        }
        return $this->render('admin_panel/czas_pracy/_add.html.twig', [
            'form' => $form->createView(),
            'jednostka' => $id
        ]);
    }

    /**
     * @Route("/czas_pracy/{id}", name="czas_pracy", methods={"GET", "POST"})
     */
    public function showAndAdd($id, JednostkaRepository $jednostkaRepo, Request $request){

        $entityManager = $this->getDoctrine()->getManager();
        
        $czas = $entityManager->getRepository('App:CzasPracy')->findAllByJednostkaId($id);
        $jednostka = $this->getDoctrine()
            ->getRepository(Jednostka::class)
            ->findOneById($id);
        
        $czasGet = new CzasPracy();

        $form = $this->createForm(CzasPracyFormType::class, $czasGet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $j_id = $entityManager->getRepository('App:Jednostka')->find($id);

            $czasGet->setJednostka($j_id);
            $entityManager->persist($czasGet);
            $entityManager->flush();

             
            return $this->redirectToRoute('admin.czas_pracy', [
                'id'=>$id
                ]);
        }
    
        return $this->render('admin_panel/czas_pracy/index.html.twig', [
            'id' => $id,
            'czas' => $czas,
            'jednostka' => $jednostka,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/czas_pracy/delete/{id}/{id_jednostki}", name="czas_pracy_delete")
     */
    public function delete($id, $id_jednostki, CzasPracy $czas)
    {   

        
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($czas);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'Czas pracy został pomyślnie usunięty'
            );
        return $this->redirectToRoute('admin.czas_pracy', [
            'id'=>$id_jednostki
            ]);

    }
}
