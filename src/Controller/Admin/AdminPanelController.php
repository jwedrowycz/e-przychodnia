<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
  * @IsGranted("ROLE_OPERATOR")
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
        return null;
    }

}
