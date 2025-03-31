<?php

namespace App\Controller;

use DateTime;
use App\Entity\Picture;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

final class PictureController extends AbstractController
{
    #[Route('/picture', name: 'app_picture')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $pictureRepository = $entityManager->getRepository(Picture::class);

        // $pictureRepository = $entityManager->getRepository(Picture::class)
        $picture = $pictureRepository->findAll();

        return $this->render('picture/index.html.twig', [
            'picture'=>$picture
        ]);
    }
    
    
    #[Route('/picture/create', name: 'app_picture_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Création d'un nouvelle objet (entity)
        $picture = new Picture();
        
        // Création du formulaire pour l'affichage
        // @param PictureType : correspond à la class du formulaire
        // @param $picture :l'objet qui sera remplit par le form
        $formPictureCreate = $this->createForm(PictureType::class,$picture);

        $formPictureCreate-> handleRequest($request);

        if ($formPictureCreate->isSubmitted() && $formPictureCreate->isValid()){
    
            // // Prépare les données a être enregistrer en basse
            $entityManager->persist($picture);
    
            // // Enregister les données en base, créer l'Id unique
            $entityManager->flush();

        }
        


        return $this->render('picture/create.html.twig', [
            'formCreate'=> $formPictureCreate,
            'request' => $request,
            'picture' => $picture
        ]);
    }

    #[Route('/picture/{id<\d+>}', name: 'app_picture_show', methods: ['GET'])]
    public function show(Picture $picture): Response
    {
        

        return $this->render('picture/show.html.twig', [
            
            'picture'=>$picture
        ]);
    }

    #[Route('/picture/edit/{id<\d+>}', name: 'app_picture_edit', methods: ['GET', 'POST'])]
    public function edit(EntityManagerInterface $entityManager, Picture $picture, Request $request ): Response
    {
        
        
        // Création du formulaire pour l'affichage
        // @param PictureType : correspond à la class du formulaire
        // @param $picture :l'objet qui sera remplit par le form
        $formPictureEdit = $this->createForm(PictureType::class,$picture);

        $formPictureEdit-> handleRequest($request);

        if ($formPictureEdit->isSubmitted() && $formPictureEdit->isValid()){
    
            // // Prépare les données a être enregistrer en basse
            $entityManager->persist($picture);
    
            // // Enregister les données en base, créer l'Id unique
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Les modifications ont été enregistrées"
            );

        }
        return $this->render('picture/edit.html.twig', [
            'formCreate'=> $formPictureEdit,
            'request' => $request,
            'picture' => $picture
        ]);
    }


    #[Route('/picture/delete/{id<\d+>}', name: 'app_picture_delete')]
    public function delete(Picture $picture, EntityManagerInterface $entityManager): Response
    {
        try {
            //prepare obj a la suppression
            $entityManager->remove($picture);

            //on lance la suppression en base
            $entityManager->flush();

            //si tout cest bien passé je redirige vers la liste
            $this->addFlash(
                'success', "La suppression a été effectuée"
            );

            // si la suppression se passe correctement
            return $this->redirectToRoute('app_picture');
        }
        catch(\Exception $exc){

            // En cas d'erreur/Exeception je prépare le flash
            $this->addFlash(
                'error', $exc->getMessage()
            );
            //
            return $this->redirectToRoute('app_picture_show', ['id' => $picture->getId()], 304);
        }


    }


    
}
