<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Image;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\File;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository, ImageRepository $images): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
    

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $post->setUserId($user);
       

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($form['images']->getData() as $file) {
                $originalFileName = $file->getClientOriginalName();
                $baseFileName = pathinfo($originalFileName, PATHINFO_FILENAME);
                $fileName = $baseFileName . '-' . uniqid() . '-' . $file->guessExtension();
                $file->move('/var/www/html/public/uploads', $fileName);
                $url = "/uploads/" . $fileName;
                $image = (new Image())
                ->setLink($url);

                $entityManager->persist($image);
                $entityManager->persist($post);
                
                $post->addImage($image);
                $entityManager->flush();
            }


            $postRepository->save($post, true);
            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_show', methods: ['GET'])]
    public function show(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Post $post, PostRepository $postRepository, ImageRepository $imageRepository, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $image = $imageRepository->findOneBy(["postId"=>$post]);
            // dd($image);
            $imageRepository->remove($image, true);

            foreach ($form['images']->getData() as $file) {
                $originalFileName = $file->getClientOriginalName();
                $baseFileName = pathinfo($originalFileName, PATHINFO_FILENAME);
                $fileName = $baseFileName . '-' . uniqid() . '-' . $file->guessExtension();
                $file->move('/var/www/html/public/uploads', $fileName);
                $url = "/uploads/" . $fileName;
                $image = (new Image())
                ->setLink($url);

                $entityManager->persist($image);
                $entityManager->persist($post);
                
                $post->addImage($image);
                $entityManager->flush();
            }

            $postRepository->save($post, true);

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository, ImageRepository $imageRepository, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {

            // $image = $imageRepository->findBy(["postId"=>$post]);
            // $imageRepository->remove($image, true);
            // Filesystem remove() deletes files, directories and symlinks:
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
