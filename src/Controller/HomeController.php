<?php

namespace App\Controller;

use App\Entity\Contacts;
use App\Form\ContactsType;
use App\Repository\ArticlesRepository;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoriesRepository $categoriesRepository, ArticlesRepository $articlesRepository): Response
    {
        $articles = $articlesRepository->findHomeData();
        $firstBlock = array_slice($articles, 0, 3);
        $secondBlock = array_slice($articles, -8);

        return $this->render('home/index.html.twig', [
            'categories' => $categoriesRepository->findAll(),
            "first" => $firstBlock,
            "second" => $secondBlock
        ]);
    }

    #[Route("/about", name: "app_about")]
    public function about(): Response
    {
        return $this->render("home/about.html.twig");
    }

    #[Route("/articles", name: "app_articles")]
    public function articles(ArticlesRepository $articlesRepository): Response
    {
        return $this->render("home/articles.html.twig", [
            "articles" => $articlesRepository->findArticleByPage(1)
        ]);
    }

    #[Route("/article/pagination/{page}", name: "app_article_pagination")]
    public function pagination(int $page, ArticlesRepository $articlesRepository): Response
    {
        return $this->json(
            ["articles" => $articlesRepository->findArticleByPage($page)],
            200,
            [],
            ["groups" => "articles"]
        );
    }


    #[Route("/article/{slug}", name: "app_article_slug")]
    public function showArticle(ArticlesRepository $articlesRepository, string $slug): Response
    {
        return $this->render("articles/show.html.twig", [
            "article" => $articlesRepository->findOneBy(["slug" => $slug])
        ]);
    }

    #[Route("/articles/search", name: "app_article_search")]
    public function search(
        #[MapQueryParameter] string $q = "",
        #[MapQueryParameter] string $category = "",
        ArticlesRepository $articlesRepository,
        CategoriesRepository $categoriesRepository
    ): Response {
        $selectedCategory = null;
        if ($category && strtolower($category) != "all") {
            $selectedCategory = $categoriesRepository->findOneBy(["name" => $category])->getId();
        }

        return $this->render("articles/search.html.twig", [
            "articles" => $articlesRepository->searchArticle($q, $selectedCategory),
            "categories" => $categoriesRepository->findAll(),
            "q" => $q,
            "category" => $category
        ]);
    }

    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contacts();
        $form = $this->createForm(ContactsType::class, $contact);
        $form->handleRequest($request);
        $success = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            $contact = new Contacts();
            $form = $this->createForm(ContactsType::class, $contact);
            $success = "message sent";
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
            'success' => $success
        ]);
    }
}
