<?php

namespace Buttress\PhpxTemplates\Exception;

use Buttress\PhpxTemplates\TemplateOptions;
use Throwable;

class TemplateRenderException extends \RuntimeException implements Exception
{
    public function __construct(
        string $message,
        public readonly string $path,
        public readonly ?TemplateOptions $options,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, 0, $previous);
    }
}
