<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Application\Query\Article\FindRecentArticles;

final class FindRecentArticlesQuery
{
    public int $limit;

    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }
}
