<?php

namespace App\Controller\Admin;

use App\Entity\Pacjent;
use App\Entity\Jednostka;
use App\Entity\Lekarz;
use App\Entity\PoradniaInfo;
use App\Repository\PoradniaInfoRepository;
use App\Form\AddPoradniaFormType;
use App\Form\AddJednostkaFormType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
     * @Route("/poradnia/add_jednostka", name="jednostka_add")
     */
    public function jednostka_create($id, Request $request): Response
    {
        $jednostka = new Jednostka();
     
      
       
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            $id_lekarza = $entityManager->getRepository('App:Lekarz')->find(4);
            $id_poradni = $entityManager->getRepository('App:PoradniaInfo')->find($id);

            $jednostka->setIdLekarza($id_lekarza);
            $jednostka->setIdPoradni($id_poradni);  

            $entityManager->persist($jednostka);
            $entityManager->flush();

            return $this->redirectToRoute('admin.poradnie', ['msg'=>'success']);
            
        }
        return $this->redirectToRoute('admin.jednostka_add.html.twig', [
            'addJednostkaForm' => $form->createView(),
            ]);
            
       
       
    }

    /**
     * @Route("/poradnia/add", name="poradnia_add")
     */
    public function poradnia_add(Request $request): Response
    {
        $poradnia = new PoradniaInfo();
        $form = $this->createForm(AddPoradniaFormType::class, $poradnia);
        $form->handleRequest($request);

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
