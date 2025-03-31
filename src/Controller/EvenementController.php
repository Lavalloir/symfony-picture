<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $evenementRepository = $entityManager->getRepository(Evenement::class);

        $evenement = $evenementRepository->findAll();
        return $this->render('evenement/index.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/evenement/create', name: 'app_evenement_create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        // Création d'un nouvelle objet (entity)
        $evenement = new Evenement();
        
        // Création du formulaire pour l'affichage
        // @param PictureType : correspond à la class du formulaire
        // @param $evenement :l'objet qui sera remplit par le form
        $formEvenementCreate = $this->createForm(EvenementType::class,$evenement);

        $formEvenementCreate-> handleRequest($request);

        if ($formEvenementCreate->isSubmitted() && $formEvenementCreate->isValid()){
    
            // // Prépare les données a être enregistrer en basse
            $entityManager->persist($evenement);
    
            // // Enregister les données en base, créer l'Id unique
            $entityManager->flush();

            $this->addFlash(
                'success',
                "L'ajout a été enregistrées"
            );

        }
        


        return $this->render('evenement/create.html.twig', [
            'formCreate'=> $formEvenementCreate,
            'request' => $request,
            'evenement' => $evenement
        ]);
    }

    #[Route('/evenement/{id<\d+>}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        

        
        

        return $this->render('evenement/show.html.twig', [
            
            'evenement'=>$evenement
        ]);
    }
    
    
    #[Route('/evenement/edit/{id<\d+>}', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(EntityManagerInterface $entityManager, Evenement $evenement, Request $request ): Response
    {
        
        
        // Création du formulaire pour l'affichage
        // @param EvenementType : correspond à la class du formulaire
        // @param $evenement :l'objet qui sera remplit par le form
        $formEvenementEdit = $this->createForm(EvenementType::class,$evenement);

        $formEvenementEdit-> handleRequest($request);

        if ($formEvenementEdit->isSubmitted() && $formEvenementEdit->isValid()){
    
            // // Prépare les données a être enregistrer en basse
            $entityManager->persist($evenement);
    
            // // Enregister les données en base, créer l'Id unique
            $entityManager->flush();

            $this->addFlash(
                'success',
                "Les modifications ont été enregistrées"
            );

        }
        return $this->render('evenement/edit.html.twig', [
            'formCreate'=> $formEvenementEdit,
            'request' => $request,
            'evenement' => $evenement
        ]);
    }

    #[Route('/evenement/delete/{id<\d+>}', name: 'app_evenement_delete')]
    public function delete(Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        try {
            //prepare obj a la suppression
            $entityManager->remove($evenement);

            //on lance la suppression en base
            $entityManager->flush();

            //si tout cest bien passé je redirige vers la liste
            $this->addFlash(
                'success', "La suppression a été effectuée"
            );

            // si la suppression se passe correctement
            return $this->redirectToRoute('app_evenement');
        }
        catch(\Exception $exc){

            // En cas d'erreur/Exeception je prépare le flash
            $this->addFlash(
                'error', $exc->getMessage()
            );
            //
            return $this->redirectToRoute('app_evenement_show', ['id' => $evenement->getId()], 304);
        }


    }
}
