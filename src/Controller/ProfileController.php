<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        return $this->render('profile/index.html.twig', [
            'user' => $user
        ]);
    }
}
