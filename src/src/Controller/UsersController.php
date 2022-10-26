<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
   
    #[Route('/users', name: 'app_admin', methods: ['GET',])]
    #[IsGranted('ROLE_ADMIN')]
    public function adminPage(UserRepository $userRepository) 
    {
        // $user = $this->getUser();

        return $this->render('admin/index.html.twig', [
            'users' => $userRepository->findAll()
        ]);
    }

    #[Route('/users/edit/{id}', name: 'user_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function editUser(User $user, Request $request, EntityManagerInterface $manager, UserRepository $repository, int $id): Response {
        // as not retrieving id anymore, int $id and UserRepository $repository not needed as parameter
    
        // we can log the object dd($user); // ? doc  // https://symfony.com/bundles/SensioFrameworkExtraBundle/current/annotations/converters.html
        
    
        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);
     
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'L\'utilisateur a été modifié avec succès'
            );
            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/users/edit.html.twig', [
            'form'=> $form->createView()
        ]);
    }

    #[Route('/users/delete/{id}', 'user_delete', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(EntityManagerInterface $manager, User $user) : Response {
    
        if(!$user) {
            $this->addFlash(
                'success',
                'Oops ! L\'utilisateur n\'a pas été trouvé'
            );

            return $this->redirectToRoute('app_admin');
        }
        //add validation javascript pour demander avant la suppresion
    $manager->remove($user);
    $manager->flush();

    $this->addFlash(
        'success',
        'L\'utilisateur a été supprimé avec succès !'
    );

    return $this->redirectToRoute('app_admin');
    }
}
