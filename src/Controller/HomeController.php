<?php

namespace App\Controller;

use App\Service\QuoteGenerator;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HomeController extends AbstractController{
    #[Route('/', name: 'app_home')]
    public function index(QuoteGenerator $quoteGenerator): Response
    {
        $quote = $quoteGenerator->getRandomQuote();
        return $this->render('home/index.html.twig', [
            'quote' => $quote
        ]);
    }


    #[Route('/mail', name: 'app_mail')]
    public function mail(MailerInterface $mailer): Response
    {
        $email = (new Email())
        ->from('hello@example.com')
        ->to('test@hotmail.fr')
        ->subject('Objet du mail')
        ->text('Sending emails is fun again!') // Format TEXT
        ->html('<p>See Twig integration for better HTML integration!</p>'); // Format HTML
        $mailer->send($email);
        return $this->render('home/mail.html.twig', [
            'mailer' => $mailer
        ]);
    }
}
