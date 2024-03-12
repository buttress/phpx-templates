<?php

namespace Phpx\Templates\Renderer;

use Phpx\Templates\Exception\TemplateMissingException;
use Phpx\Templates\Exception\TemplateRenderException;
use Phpx\Templates\TemplateOptions;
use Phpx\Templates\TemplateRendererInterface;

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
