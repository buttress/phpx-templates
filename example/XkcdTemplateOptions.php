<?php

use Buttress\PhpxTemplates\TemplateOptions;

readonly class XkcdTemplateOptions extends TemplateOptions
{
    public function __construct(
        public int $id,
        public string $transcript,
        public string $alt,
        public string $img,
        public string $title,
        public string $safeTitle,
        \Buttress\PHPX $x,
    ) {
        parent::__construct($x);
    }
}
