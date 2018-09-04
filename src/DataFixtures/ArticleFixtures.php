<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\DataFixtures\BaseFixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixture
{

    private static $articleTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
    ];
    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];
    private static $articleAuthors = [
        'Mike Ferengi',
        'Amy Oort',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count, $manager) {
            $article->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setContent('CONTENT HERE');

            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-110 days', '-1 days'));
            }

            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));

            $comment1 = new Comment();
            $comment1->setAuthorName('Mike Ferengi');
            $comment1->setContent('I ate a normal rock once.');
            $comment1->setArticle($article);
            $manager->persist($comment1);

            $comment2 = new Comment();
            $comment2->setAuthorName('Mike Ferengi');
            $comment2->setContent('Lol');
            $comment2->setArticle($article);
            $manager->persist($comment2);
        });

        $manager->flush();
    }
}
