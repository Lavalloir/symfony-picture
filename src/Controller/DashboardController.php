<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController{
    
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(Request $request, LoggerInterface $logger): Response
    {
        $intLastPictures = $request->query->get('lastpictures', 10);
        $logger->info('Last Picture form URL : ' . $intLastPictures);
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
