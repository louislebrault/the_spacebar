<?php

namespace App\Controller;

use Twig\Environment;
use App\Entity\Article;
use App\Service\SlackClient;
use Psr\Log\LoggerInterface;
use App\Service\MarkdownHelper;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    // Currently unused,  just showing
    public function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }
    /**
     * @Route("/", name="app_homepage")
    */
    public function homepage (ArticleRepository $repository)
    {
        $articles = $repository->findAllPublishedOrderedByNewest([], ['publishedAt' => 'DESC']);

        return $this->render('article/homepage.html.twig', [
            'articles' => $articles
        ]);
    }

     /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article, SlackClient $slack)
    {
        if ($article->getSlug() === 'khan') {
            $slack->sendMessage('khanouille', "1 trempe les frites dans l'huile");
        }

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments
        ]);
    }

    /**
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     */
    public function toggleArticleHeart($slug, LoggerInterface $logger)
    {
        $logger->info('Article is being hearted');
        // TODO - actuaaly heart/unheart the article !
        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}
