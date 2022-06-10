<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Application\Query\Article\Find10RecentArticles;

use App\ExternalContent\Article\Application\Service\NYTService\NYTApiProxyService;
use App\ExternalContent\Article\Application\Service\NYTService\NYTApiQuery;
use App\ExternalContent\Article\Domain\DTO\Article;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class Find10RecentArticlesHandler implements MessageHandlerInterface
{
    private NYTApiProxyService $NYTApiProxyService;

    public function __construct(NYTApiProxyService $NYTApiProxyService)
    {
        $this->NYTApiProxyService = $NYTApiProxyService;
    }

    public function __invoke(Find10RecentArticlesQuery $find10RecentArticlesQuery): array
    {
        $parameters = new NYTApiQuery();
        $parameters->setPath(NYTApiQuery::PATH_ARTICLES);
        $parameters->setKeywords(['automobiles', 'cars']);
        $parameters->setResponseFields(['headline', 'pub_date', 'lead_paragraph', 'multimedia', 'web_url']);
        $parameters->setSort('newest');

        $apiResponse = $this->NYTApiProxyService->createRequest(NYTApiQuery::METHOD_GET, $parameters);

        if (isset($apiResponse['response']['docs'])) {
            $articles = $apiResponse['response']['docs'];
        }

        $DTOarticlesArray = [];

        foreach ($articles as $article) {
            $articleDTO = new Article();
            $articleDTO->setTitle($article['headline']['main']);
            $articleDTO->setPublicationDate(new \DateTime($article['pub_date']));
            $articleDTO->setLead($article['lead_paragraph']);
            $articleDTO->setUrl($article['web_url']);

            $superJumboImageKey = array_search('superJumbo', array_column($article['multimedia'], 'subtype'));
            $articleDTO->setImage($article['multimedia'][$superJumboImageKey]['url']);

            $DTOarticlesArray[] = $articleDTO;
        }

        return $DTOarticlesArray;
    }
}
