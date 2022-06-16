<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Application\Factory;

use App\ExternalContent\Article\Domain\ValueObject\Article;

class ArticleFactory
{
    public static function create(
        string $title,
        \DateTime $publicationDate,
        string $lead,
        string $image,
        string $url
    ): Article {
        return new Article($title, $publicationDate, $lead, $image, $url);
    }
}
