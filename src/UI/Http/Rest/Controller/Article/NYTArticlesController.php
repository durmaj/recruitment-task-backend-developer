<?php

declare(strict_types=1);

namespace UI\Http\Rest\Controller\Article;

use App\ExternalContent\Article\Application\Query\Article\Find10RecentArticles\Find10RecentArticlesQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nytimes', name: 'api_recent_nyt_articles', methods: 'GET')]
final class NYTArticlesController extends AbstractController
{
    use HandleTrait;

    public function __invoke(MessageBusInterface $bus): JsonResponse
    {
        $envelope = $bus->dispatch(new Find10RecentArticlesQuery());

        $stamp = $envelope->last(HandledStamp::class);

        $articles = $stamp->getResult();

        return $this->json($articles);
    }
}
