<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Security\CustomAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Service\MailSender;
use Symfony\Component\Uid\Uuid;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, MailSender $mailSender): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('home',['msg'=>'fail']);
        }
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uid = Uuid::v1();
            $user->setUid($uid);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $mailSender->sendRegisterConfirmation($user);

            $this->addFlash(
            'success',
            'Rejestracja przebiegła pomyślnie! Wysłaliśmy link do potwierdzenia rejestracji na podany mail.'
            );

            return $this->redirectToRoute('login');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/register/activation/", name="register_activation")
     */
    public function activation(Request $request, UserRepository $userRepo)
    {   
        $uid = $request->query->get('uid');
        $user = $userRepo->findOneBy(['uid'=>$uid]);
        if($user)
        {
            if($user->getStatus() != 1){
                $user->setStatus(1);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                
                $this->addFlash(
                    'success',
                    'Pomyślnie aktywowałeś konto. Teraz możesz się zalogować.'
                    );
            }
            else {
                $this->addFlash(
                    'info',
                    'Konto jest już aktywne.'
                    );
            }
        }
       
        
        return $this->redirectToRoute('login');
    }
}
