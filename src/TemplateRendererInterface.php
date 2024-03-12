<?php

namespace Phpx\Templates;

/**
 * @template T of TemplateOptions
 */
interface TemplateRendererInterface
{
    /**
     * @param non-empty-string $key The template key, probably a path
     * @param T $options
     * @return string
     */
    public function render(string $key, TemplateOptions $options): string;
}
