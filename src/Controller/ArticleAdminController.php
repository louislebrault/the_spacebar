<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $article = new Article();
        $article->setTitle('Why Aseroids Taste like Bacon')
            ->setSlug('why-asteroids-taste-like-bacon-'.rand(100, 999))
            ->setContent('CONTENT HERE');

        if (rand(1, 10) > 2) {
            $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }

        $em->persist($article);
        $em->flush();
        
        return new Response(sprintf(
            'new article id: %d slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}