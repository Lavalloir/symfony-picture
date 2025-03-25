<?php

namespace App\Controller;

use DateTime;
use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class PictureController extends AbstractController
{
    #[Route('/picture', name: 'app_picture')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $pictureRepository = $entityManager->getRepository(Picture::class);
        $picture = $pictureRepository->findAll();

        return $this->render('picture/index.html.twig', [
            'picture'=>$picture
        ]);
    }
    
    
    #[Route('/picture/create', name: 'app_picture_create')]
    public function create(EntityManagerInterface $entityManager): Response
    {
        // Création d'un nouvelle objet (entity)
        $picture = new Picture();
        
        // Définition des différents attributs de l'objet
        $picture->setDescription("photo des vacances")
            ->setDate(new DateTime())
            ->setFilename("fichier.img");

        // Prépare les données a être enregistrer en basse
        $entityManager->persist($picture);

        // Enregister les données en base, créer l'Id unique
        $entityManager->flush();

        return $this->render('picture/create.html.twig', [
            'picture'=> $picture
        ]);
    }

    
}
