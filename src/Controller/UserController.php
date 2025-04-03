<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $userRepository = $entityManager->getRepository(User::class);

        $user = $userRepository->findAll();
        return $this->render('user/index.html.twig', [
            'user'=>$user
        ]);
    }

    #[Route('/user/delete/{id<\d+>}', name: 'app_user_delete')]
    public function delete(User $user, EntityManagerInterface $entityManager): Response
    {
        try {
            //prepare obj a la suppression
            $entityManager->remove($user);

            //on lance la suppression en base
            $entityManager->flush();

            //si tout cest bien passé je redirige vers la liste
            $this->addFlash(
                'success', "La suppression a été effectuée"
            );

            // si la suppression se passe correctement
            return $this->redirectToRoute('app_user');
        }
        catch(\Exception $exc){

            // En cas d'erreur/Exeception je prépare le flash
            $this->addFlash(
                'error', $exc->getMessage()
            );
            //
            return $this->redirectToRoute('app_picture_show', ['id' => $user->getId()], 304);
        }
    }
}
