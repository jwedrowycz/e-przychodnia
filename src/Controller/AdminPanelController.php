<?php

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin", name="admin.")
 */
class AdminPanelController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index() // Strona główna panelu administratora
    {
        return $this->render('admin_panel/admin_page.html.twig', [

        ]);
    }
}






/**
  * @IsGranted("ROLE_ADMIN")
  */
