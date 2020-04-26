<?php

namespace App\Controller;

use App\Entity\Pacjent;
use App\Form\AddUserType;
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

    /**
     * @Route("/add", name="add_user")
     */
    // DODAWANIE UŻYTKOWNIKA-PRACOWNIKA
    public function add_user(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Pacjent();
        $form = $this->createForm(AddUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $user->setRoles(['ROLE_OPERATOR']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('admin.add_user', ['msg'=>'success']);
        }
        return $this->render('admin_panel/add_user.html.twig', [
            'addUserForm' => $form->createView(),
        ]);
    }
}
