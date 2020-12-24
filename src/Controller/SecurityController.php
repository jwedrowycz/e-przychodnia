<?php

namespace App\Controller;

use App\Form\ForgotPwdType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Service\MailSender;
use Symfony\Component\Uid\Uuid;
use App\Service\TokenGenerator;
use App\Form\ChangePasswordType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->isGranted('ROLE_USER')) {
            $this->addFlash(
                'fail',
                'Jesteś już zalogowany'
            );
            return $this->redirectToRoute('home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * @Route("/forgot-password/", name="forgot_password")
     */
    public function forgot(Request $request, MailSender $mailSender, UserRepository $userRepository, TokenGenerator $tokenGenerator)
    {   
        $form = $this->createForm(ForgotPwdType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $token = $tokenGenerator->generateToken();
            $email = $form->get('email')->getData();
            $user = $userRepository->findOneBy(['email' => $email]);
            $user->settoken($token);
            $user->setTokenTimestamp(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $mailSender->sendResetPasswordRequest($user, $token);   
            $this->addFlash(
                'success',
                'Wysłaliśmy wiadomość na podany adres ' . $user->getEmail() .' z dalszymi instrukcjami dotyczącymi zmiany hasła.'
            );
            return $this->redirectToRoute('forgot_password');
        }
        return $this->render('security/forgot_pwd.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/reset-password/", name="reset_password")
     */
    public function reset(Request $request, UserRepository $userRepository,  UserPasswordEncoderInterface $passwordEncoder)
    {   
        $token = $request->query->get('token');
      
        $uid = $request->query->get('uid');
        $user = $userRepository->findOneBy(['uid' => $uid, 'token' => $token]);
        if(!$token or !$user){
            $this->addFlash(
                'fail',
                'Wygląda na to, że link do resetowania hasła wygasł.'
            );
            return $this->redirectToRoute('login');
        }
        $form = $this->createForm(ChangePasswordType::class, $user);
        $form->handleRequest($request);

        $timestamp = new \DateTime();
        $tokenTimeStamp = $user->getTokenTimestamp();
        $diff = $timestamp->diff($tokenTimeStamp);
        dump($diff->format('%i'));
        if(intval($diff->format('%i')) >= 15)
        {
            $this->addFlash(
                'fail',
                'Wygląda na to, że link do resetowania hasła wygasł.'
            );
            return $this->redirectToRoute('login');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash(
                'success',
                'Pomyślnie zmnieniono hasło użytkownika'
            );
            return $this->redirectToRoute('login');
        }
        return $this->render('security/change_pwd.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
