<?php

namespace App\ExternalContent\Article\Domain\Repository;

use App\ExternalContent\Article\Domain\ArticleCollection;

interface NYTApiRepositoryInterface
{
    public function findRecentArticles(int $limit): ArticleCollection;
}