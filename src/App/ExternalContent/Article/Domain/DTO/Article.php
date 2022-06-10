<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Domain\DTO;

class Article implements \JsonSerializable
{
    protected string $title;

    protected \DateTime $publicationDate;

    protected string $lead;

    protected string $image;

    protected string $url;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Article
    {
        $this->title = $title;

        return $this;
    }

    public function getPublicationDate(): \DateTime
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(\DateTime $publicationDate): Article
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getLead(): string
    {
        return $this->lead;
    }

    public function setLead(string $lead): Article
    {
        $this->lead = $lead;

        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): Article
    {
        $this->image = $image;

        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): Article
    {
        $this->url = $url;

        return $this;
    }

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
