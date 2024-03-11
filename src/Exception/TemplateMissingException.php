<?php

namespace Buttress\PhpxTemplates\Exception;

use Buttress\PhpxTemplates\TemplateOptions;
use Throwable;

class TemplateMissingException extends \InvalidArgumentException implements Exception
{
    public function __construct(
        public readonly string $template,
        public readonly ?TemplateOptions $options,
        ?Throwable $previous = null
    ) {
        parent::__construct(sprintf('Unable to find template "%s"', $template), 0, $previous);
    }
}
