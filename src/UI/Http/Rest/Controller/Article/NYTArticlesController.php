<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Article;

use App\ExternalContent\Article\Application\Query\Article\FindRecentArticles\FindRecentArticlesQuery;
use App\ExternalContent\Article\Domain\ArticleViewCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nytimes/{limit}', name: 'api_recent_nyt_articles', methods: 'GET')]
final class NYTArticlesController extends AbstractController
{
    use HandleTrait;

    public function __invoke(MessageBusInterface $bus, int $limit = 10): JsonResponse
    {
        $envelope = $bus->dispatch(new FindRecentArticlesQuery($limit));

        $stamp = $envelope->last(HandledStamp::class);

        $articles = $stamp->getResult();

        if (! $articles instanceof ArticleViewCollection) {
            return $this->json([], Response::HTTP_NOT_FOUND);
        }

        return $this->json($articles->toArray());
    }
}
