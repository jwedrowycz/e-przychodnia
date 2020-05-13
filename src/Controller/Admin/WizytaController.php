<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class WizytaController extends AbstractController
{
    /**
     * @Route("/admin/wizyta", name="admin_wizyta")
     */
    public function index()
    {
        return $this->render('admin/wizyta/index.html.twig', [
            'controller_name' => 'WizytaController',
        ]);
    }
}
