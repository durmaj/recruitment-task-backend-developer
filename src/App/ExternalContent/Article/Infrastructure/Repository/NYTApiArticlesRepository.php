<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Infrastructure\Repository;

use App\ExternalContent\Article\Domain\ArticleCollection;
use App\ExternalContent\Article\Domain\Repository\NYTApiRepositoryInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class NYTApiArticlesRepository implements NYTApiRepositoryInterface
{
    private HttpClientInterface $client;

    const PATH_ARTICLES = 'articlesearch.json';
    const METHOD_GET = 'GET';

    public function __construct(HttpClientInterface $nytClient)
    {
        $this->client = $nytClient;
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function findRecentArticles(int $limit): ArticleCollection
    {
        $response = $this->client->request(self::METHOD_GET, self::PATH_ARTICLES, [
            'query' => [
                'q' => 'automobiles, cars',
                'fl' => 'headline, pub_date, lead_paragraph, multimedia, web_url',
                'sort' => 'newest'
            ]
        ])->toArray();

        $articles = [];

        if (isset($response['response']['docs'])) {
            $articles = $response['response']['docs'];
        }

        return new ArticleCollection(array_slice($articles, 0, $limit));
    }

}
