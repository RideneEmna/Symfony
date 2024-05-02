<?php

namespace App\Controller;

/*use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;*/

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;


class BlogController extends AbstractController
{
    #[Route('profile/index', name: 'app_blog')]

    public function index(ArticleRepository $repo): Response
    {
        $articles = $repo->findAll('Titre de l\'article');
        return $this->render('blog/index.html.twig', ['controller_name' => 'BlogController', 'articles' => $articles,]);
    }



    // #[Route('/{i}', name: 'home')]
    // public function home($i)
    // {

    //     return $this->render('blog/home.html.twig', ["x" => $i]);
    // }

    #[Route('admin/blog/new', name: 'new_form')]
    public function new(Request $request, EntityManagerInterface
    $entityManager): Response
    {
        // creates a article object and initializes some data for this example
        $article = new Article();
        $article->setCreatedate(new
            \DateTimeImmutable('tomorrow'));
        $form = $this->createFormBuilder($article)
            ->add('title', TextType::class)
            ->add('image', TextType::class)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Article'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$article` variable has also been updated
            $article = $form->getData();
            $entityManager->persist($article);
            $entityManager->flush();
            // ... perform some action, such as saving the article to the database
            return $this->redirectToRoute('app_blog');
        }
        return $this->render('/blog/create.html.twig', ['form' => $form,]);
    }


    #[Route('/blog/{id}', name: 'blog_show')]
    public function show($id, ArticleRepository $repo)
    {
        $article = $repo->find($id);
        return $this->render('blog/show.html.twig', ['article' => $article]);
    }
}
