<?php

namespace App\Entities\Article;

class ArticleCreateTDO
{
    public string $title;
    public string $text;
    public bool $isActive;
    public array $authorIds;

    public function __construct(string $title, string $text, bool $isActive, array $authorIds)
    {
        $this->title = $title;
        $this->text = $text;
        $this->isActive = $isActive;
        $this->authorIds = $authorIds;
    }
}
