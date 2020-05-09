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

    public function czas_pracy_add($id, RequestStack $requestStack)
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
            unset($czas); 
            unset($form);
            $czas = new CzasPracy();
            $form = $this->createForm(CzasPracyFormType::class, $czas);

        }
        return $this->render('admin_panel/czas_pracy/_add.html.twig', [
            'form' => $form->createView(),
            'jednostka' => $id
        ]);
    }

    /**
     * @Route("/czas_pracy/show/{id}", name="czas_pracy_show")
     */
    public function czas_pracy_show($id, JednostkaRepository $jednostkaRepo){

        $entityManager = $this->getDoctrine()->getManager();
        
        $czas = $entityManager->getRepository('App:CzasPracy')->findAllByJednostkaId($id);
        $jednostka = $this->getDoctrine()
            ->getRepository(Jednostka::class)
            ->findOneById($id);

        return $this->render('admin_panel/czas_pracy/show.html.twig', [
            'czas' => $czas,
            'jednostka' => $jednostka,
            'id' => $id
        ]);
    }

     /**
     * @Route("/czas_pracy/delete/{id_jednostki}/{id}", name="czas_pracy_delete")
     */
    public function czas_pracy_delete($id, $id_jednostki)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $czas = $entityManager->getRepository('App:CzasPracy')->findOneBy([
            'id' => $id
        ]);
        $entityManager->remove($czas);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'Czas pracy został pomyślnie usunięty'
            );
        return $this->redirectToRoute('admin.czas_pracy_show', [
            'id'=>$id_jednostki
            ]);

    }
}
