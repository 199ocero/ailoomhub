<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Crypt;
use FiveamCode\LaravelNotionApi\Notion;

class NotionImporter
{
    protected $notion;

    public function __construct(string $notionToken)
    {
        $this->notion = new Notion(Crypt::decryptString($notionToken));
    }

    public static function make(string $notionToken): self
    {
        return new self($notionToken);
    }

    public function importPage(): Collection
    {
        return $this->notion->search()->onlyPages()->query()->asCollection();
    }
}
