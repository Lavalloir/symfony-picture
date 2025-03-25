<?php

namespace App\Controller;

use App\Service\QuoteGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController{
    #[Route('/', name: 'app_home')]
    public function index(QuoteGenerator $quoteGenerator): Response
    {
        $quote = $quoteGenerator->getRandomQuote();
        return $this->render('home/index.html.twig', [
            'quote' => $quote
        ]);
    }
}
