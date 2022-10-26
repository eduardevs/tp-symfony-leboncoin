<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Form\SearchBarType;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/post')]
class PostController extends AbstractController
{
    #[Route('/', name: 'app_post_index', methods: ['GET','POST'])]
    public function index(PostRepository $postRepository , Request $request ): Response
    {
        $allDataToShow = null ;
        $results = null;
        $price = null ;
        $category =null ;
        $dateDay = null ;
        $dateMonth = null ;
        $dateYear = null ;
        $date = null ;
        $formSearch = $this->createForm(SearchBarType::class)
                    ->handleRequest($request);
        

        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $requestData = $request->request->all();
            $requestData['search_bar'];
            $price = $requestData['search_bar']['price'] ;
            $category = $requestData['search_bar']['category'] ;
            $dateDay = $requestData['search_bar']['date']['day'] ;
            $dateMonth = $requestData['search_bar']['date']['month'];
            $dateYear = $requestData['search_bar']['date']['year'];

            if(($dateYear && isset($dateYear)) && ($dateMonth && isset($dateMonth)) && ($dateDay && isset($dateDay))) {
                $cleanDateDay = strlen($dateDay) > 1 ? $dateDay : '0'. $dateDay ;
                $cleanDateMonth = strlen($dateMonth) > 1 ? $dateMonth : '0'. $dateMonth ;
                $date = $dateYear . '-' . $cleanDateMonth . '-' . $cleanDateDay  ;
            }
            
            $results = $postRepository->searchElementsWithForm($date,$price,$category);
            if(empty($results)){
                $this->addFlash(
                    'failed',
                    'Aucun produit ne correspond à votre recherche'
                );
             } 
            
            if (!empty($results)){
                $allDataToShow = $results ;
                $countResult = count($results) ;
                $this->addFlash(
                    'success',
                    "Nous avons trouver ${countResult} résultat(s) pour votre recherche"
                );
            }
        }


        return $this->render('post/index.html.twig', [
            'form_search' => $formSearch->createView(),
            'posts' => $postRepository->findAll(),
            'allDataToShow' =>$allDataToShow
        ]);
    }
    

    #[Route('/new', name: 'app_post_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PostRepository $postRepository): Response
    {
        $user = $this->getUser();
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        $post->setUserId($user);
       

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function edit(Request $request, Post $post, PostRepository $postRepository): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $postRepository->save($post, true);

            return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_post_delete', methods: ['POST'])]
    public function delete(Request $request, Post $post, PostRepository $postRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $postRepository->remove($post, true);
        }

        return $this->redirectToRoute('app_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
