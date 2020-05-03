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
 * @Route("/admin", name="admin.")
 */
class LekarzeController extends AbstractController
{
    /**
     * @Route("/lekarze", name="lekarze")
     */
    public function lekarze(LekarzRepository $lekarzRepo )
    {   
        $lekarze = $lekarzRepo->findAll();

        return $this->render('admin_panel/lekarze/lekarze.html.twig', [
            'lekarze' => $lekarze
        ]);
    }

    /**
     * @Route("/lekarze/add", name="lekarz_add")
     */
    public function lekarz_add(Request $request)
    {
        $lekarz = new Lekarz();
        $form = $this->createForm(AddLekarzFormType::class, $lekarz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lekarz);
            $entityManager->flush();

            return $this->redirectToRoute('admin.lekarze', ['msg'=>'success']);
            
        }
        return $this->render('admin_panel/lekarze/lekarz_add.html.twig', [
            'addLekarzForm' => $form->createView(),
        ]);
    }
}
