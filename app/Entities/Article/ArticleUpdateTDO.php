<?php

namespace App\Entities\Article;

class ArticleUpdateTDO
{
    public string $id;
    public ?string $title;
    public ?string $text;
    public ?bool $isActive;
    public ?array $authorIds;

    public function __construct(
        int $id,
        ?string $title,
        ?string $text,
        ?bool $isActive,
        ?array $authorIds)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
        $this->isActive = $isActive;
        $this->authorIds = $authorIds;
    }
}
