<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Clinic;
use App\Form\UserType;
use App\Repository\ClinicRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
  * @IsGranted("ROLE_ADMIN")
  */

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
        return $this->render('admin_panel/index.html.twig', [

        ]);
    }
}
