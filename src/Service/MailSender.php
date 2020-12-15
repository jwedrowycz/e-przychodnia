<?php

namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MailSender
{

    private $mailer;
    private $router;

    public function __construct( MailerInterface $mailer, UrlGeneratorInterface $router)
    {
        $this->mailer = $mailer;
        $this->router = $router;
    }

    public function sendRegisterConfirmation($user): bool
    {   

        $activationUrl = $this->router->generate('register_activation', [],  UrlGeneratorInterface::ABSOLUTE_URL);
        $email = (new TemplatedEmail())
            ->from(new Address('jakub.kopniewski@gmail.com', 'Przychodnia'))
            ->to($user->getEmail())
            ->subject('Potwierdzenie rejestracji')
            ->htmlTemplate('emails/registration.html.twig')
            ->context([
                'name' => $user->getName(),
                'lastName' => $user->getLastName(),
                'uid' => $user->getUid(),
                'link' => $activationUrl . '?uid='.$user->getUid() .'&user=' . $user->getId()
            ]);
            
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            echo 'Wystąpił problem z wysłaniem maila';
            echo $e;
        }
    
        return true;

    }
}