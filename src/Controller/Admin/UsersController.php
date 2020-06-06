<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Clinic;
use App\Form\Filter\UsersFilterType;
use App\Form\Filter\VisitsFilterType;
use App\Form\UserEditType;
use App\Form\UserType;
use App\Repository\ClinicRepository;
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
 * @Route("/admin/users", name="admin.")
 */
class UsersController extends AbstractController
{
    /**
     * @Route("/", name="users")
     * @param UserRepository $usersRepo
     * @param Request $request
     * @return Response
     */
    public function users(UserRepository $usersRepo, Request $request)
    {
        $users = $usersRepo->findAll();
        $form = $this->createForm(UsersFilterType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()) {
            $role = $form->get('type')->getData();
            $role = empty($role) ? '' : $role;

            $users = $usersRepo->findAllUsersWithFilters($role);
        }

        return $this->render('admin_panel/users/users.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/add", name="user_add")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function add_user(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {   //TODO: OGARNĄĆ KURWA TWORZENIE UŻYTKOWNIKÓW-OPERATORÓW BO WYPIERDALA NULLE
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
     * @Route("/clinic/users/delete/{id}", name="user_delete")
     */
    public function delete(User $user)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'Pomyślnie usunięto użytkownika'
        );
        return $this->redirectToRoute('admin.users');

    }


    /**
     * @Route("/edit/{id}", name="user_edit")
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        // TODO: OGARNĄĆ KURWA TE ROLE BO COŚ NIE BANGLA

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Pomyślnie edytowano użytkownika'
            );
            return $this->redirectToRoute('admin.users');

        }

        return $this->render('admin_panel/users/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
