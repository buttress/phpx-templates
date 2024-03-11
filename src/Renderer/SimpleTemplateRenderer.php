<?php

namespace Buttress\PhpxTemplates\Renderer;

use Buttress\PhpxTemplates\Exception\TemplateMissingException;
use Buttress\PhpxTemplates\Exception\TemplateRenderException;
use Buttress\PhpxTemplates\TemplateOptions;
use Buttress\PhpxTemplates\TemplateRendererInterface;

class SimpleTemplateRenderer implements TemplateRendererInterface
{
    public function render(string $key, TemplateOptions $options): string
    {
        if (!file_exists($key)) {
            throw new TemplateMissingException($key, $options);
        }

        try {
            return require $key;
        } catch (\Throwable $e) {
            throw new TemplateRenderException($e->getMessage(), $key, $options, $e);
        }
    }

    public function renderTemplateInContext(string $__template_file, TemplateOptions $options)
    {
        return require($__template_file);
    }

}
