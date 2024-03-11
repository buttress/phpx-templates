<?php

use Buttress\PhpxTemplates\TemplateOptions;

readonly class ErrorTemplateOptions extends TemplateOptions
{
    public function __construct(
        public string $message,
        public \Throwable $exception,
        public int $code,
        \Buttress\PHPX $x,
    ) {
        parent::__construct($x);
    }
}
