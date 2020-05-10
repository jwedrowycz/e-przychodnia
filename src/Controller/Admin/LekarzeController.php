<?php

namespace App\Controller\Admin;

use App\Entity\Lekarz;
use App\Repository\LekarzRepository;
use App\Form\AddLekarzFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/admin/lekarze", name="admin.")
 */
class LekarzeController extends AbstractController
{
    /**
     * @Route("/", name="lekarze")
     */
    public function lekarze(LekarzRepository $lekarzRepo )
    {   
        $lekarze = $lekarzRepo->findAll();

        return $this->render('admin_panel/lekarz/index.html.twig', [
            'lekarze' => $lekarze
        ]);
    }

    /**
     * @Route("/add", name="lekarz_add")
     */
    public function add(Request $request)
    {   
        $lekarz = new Lekarz();
        $form = $this->createForm(AddLekarzFormType::class, $lekarz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lekarz);
            $entityManager->flush();
            $this->addFlash(
            'success',
            'Pomyślnie dodano lekarza'
            );
            return $this->redirectToRoute('admin.lekarze');
            
        }
        return $this->render('admin_panel/lekarz/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    
    /**
     * @Route("/delete/{id}", name="lekarz_delete")
     */
    public function delete(Request $request, Lekarz $lekarz)
    {    
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($lekarz);
        $entityManager->flush();   
        
        $this->addFlash(
            'success',
            'Pomyślnie usunięto lekarza'
            );
        return $this->render('admin_panel/lekarz/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/edit/{id}", name="lekarz_edit")
     */
    public function edit(Request $request, Lekarz $lekarz): Response
    {
        $form = $this->createForm(AddLekarzFormType::class, $lekarz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Pomyślnie usunięto lekarza'
                );
            return $this->redirectToRoute('admin.lekarze');
            
        }

        return $this->render('admin_panel/lekarz/edit.html.twig', [
            'lekarz' => $lekarz,
            'form' => $form->createView(),
        ]);
    }

}