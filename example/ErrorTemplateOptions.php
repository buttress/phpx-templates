<?php

use Phpx\Templates\TemplateOptions;

readonly class ErrorTemplateOptions extends TemplateOptions
{
    public function __construct(
        public string $message,
        public \Throwable $exception,
        public int $code,
        \Buttress\Phpx\Phpx $x,
    ) {
        parent::__construct($x);
    }
}
