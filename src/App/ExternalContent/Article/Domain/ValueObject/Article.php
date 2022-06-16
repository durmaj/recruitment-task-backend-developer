<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Domain\ValueObject;

class Article implements \JsonSerializable
{
    public function __construct(
        private string $title,
        private \DateTime $publicationDate,
        private string $lead,
        private string $image,
        private string $url
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'title' => $this->title,
            'publicationDate' => $this->publicationDate->format('d-m-Y h:i:s'),
            'lead' => $this->lead,
            'image' => $this->image,
            'url' => $this->url
        ];
    }
}
