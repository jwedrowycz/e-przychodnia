<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\PoradniaInfo;
use App\Form\UserType;
use App\Repository\PoradniaInfoRepository;
use App\Repository\UserRepository;
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
class UsersController extends AbstractController
{
   /**
     * @Route("/users", name="users")
     */
    public function users(UserRepository $usersRepo)
    {
        $users = $usersRepo->findAll();

        return $this->render('admin_panel/users/users.html.twig', [
            'users' => $users
        ]);

    }

     /**
     * @Route("/users-only", name="users_only")
     */
     public function users_only(UserRepository $usersRepo)
     {
         $users = $usersRepo->findAllUsers();
        //  $users = $users->getResult();
         return $this->render('admin_panel/users/users_only.html.twig', [
             'users' => $users
         ]);
 
     }
    
    /**
     * @Route("/add", name="add_user")
     */
    public function add_user(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
//            $user->setRoles(['ROLE_USER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
            'success',
            'Pomyślnie dodano nowego użytkownika'
            );
            return $this->redirectToRoute('admin.users');
        }
        return $this->render('admin_panel/users/user_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


     /**
     * @Route("/users/profile/{id}", name="user_profile")
     */
    public function user_profile(User $user)
    {

        return $this->render('admin_panel/users/user_profile.html.twig', [
            'user' => $user
        ]);

    }

    /**
     * @Route("/poradnia/users/delete/{id}", name="user_delete")
     */
    public function user_delete(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirectToRoute('admin.users');

    }
}
