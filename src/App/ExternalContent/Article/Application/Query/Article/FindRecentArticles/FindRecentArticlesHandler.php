<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Application\Query\Article\FindRecentArticles;

use App\ExternalContent\Article\Application\Factory\ArticleFactory;
use App\ExternalContent\Article\Domain\ArticleViewCollection;
use App\ExternalContent\Article\Domain\Repository\NYTApiRepositoryInterface;
use App\ExternalContent\Article\Infrastructure\Repository\NYTApiArticlesRepository;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class FindRecentArticlesHandler implements MessageHandlerInterface
{
    private NYTApiArticlesRepository $repository;

    public function __construct(NYTApiRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FindRecentArticlesQuery $findRecentArticlesQuery): ArticleViewCollection
    {
        $articlesCollection = $this->repository->findRecentArticles($findRecentArticlesQuery->limit);

        $articlesArray = [];

        foreach ($articlesCollection as $article) {
            $publicationDate = new \DateTime($article['pub_date']);
            $superJumboImageKey = array_search('superJumbo', array_column($article['multimedia'], 'subtype'));

            $articleValueObject = ArticleFactory::create(
                $article['headline']['main'],
                $publicationDate,
                $article['lead_paragraph'],
                $article['multimedia'][$superJumboImageKey]['url'],
                $article['web_url']
            );
            $articlesArray[] = $articleValueObject;
        }

        return new ArticleViewCollection($articlesArray);
    }
}
