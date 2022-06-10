<?php

declare(strict_types=1);

namespace App\ExternalContent\Article\Application\Service\NYTService;

class NYTApiQuery
{
    protected string $path;
    protected string $keywords;
    protected ?string $responseFields = null;
    protected ?string $sort = null;

    const PATH_ARTICLES = 'articlesearch.json';
    const METHOD_GET = 'GET';

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        if(!empty($path)) {
            $this->path = $path;
        }
    }

    public function getKeywords(): string
    {
        return "q=" . $this->keywords;
    }
    public function setKeywords(array $keywords): void
    {
        if(!empty($keywords)) {
            $this->keywords = implode(',', $keywords);
        }
    }

    public function getResponseFields(): ?string
    {
        if (!empty($this->responseFields)) {
            return "fl=" . $this->responseFields;
        }
        return null;
    }

    public function setResponseFields(array $responseFields): void
    {
        if (!empty($responseFields)) {
            $this->responseFields = implode(',', $responseFields);
        }
    }

    public function getSort(): ?string
    {
        if (!empty($this->sort)) {
            return "sort=" . $this->sort;
        }
        return null;
    }

    public function setSort(string $sort): void
    {
        if(!empty($sort)) {
            $this->sort = $sort;
        }
    }
}
