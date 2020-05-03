<?php

namespace App\Controller\Admin;

use App\Entity\Pacjent;
use App\Entity\PoradniaInfo;
use App\Form\AddUserType;
use App\Repository\PoradniaInfoRepository;
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
    public function index()
    {
        return $this->render('admin_panel/index.html.twig', [

        ]);
    }

}
