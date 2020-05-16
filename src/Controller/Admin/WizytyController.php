<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\WizytaRepository;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/admin/wizyty", name="admin.")
 */
class WizytyController extends AbstractController
{
    /**
     * @Route("/", name="wizyta")
     */
    public function index(WizytaRepository $wizytaRepo)
    {   
        $wizyta = $wizytaRepo->findAllWithJoined();
    

        return $this->render('admin_panel/wizyta/wizyta.html.twig', [
            'wizyta' => $wizyta,
            // 'pacjent' => $pacjent
        ]);
    }
}
