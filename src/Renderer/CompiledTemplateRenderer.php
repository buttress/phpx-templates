<?php

namespace Phpx\Templates\Renderer;

use Phpx\Templates\ThemedResult;
use Phpx\Templates\Exception\TemplateMissingException;
use Phpx\Templates\Exception\TemplateRenderException;
use Phpx\Templates\TemplateOptions;
use Phpx\Templates\TemplateRendererInterface;
use Phpx\Templates\ThemeOptions;
use Psr\SimpleCache\CacheInterface;

class CompiledTemplateRenderer implements TemplateRendererInterface
{
    public function __construct(protected readonly CacheInterface $cache) {}

    public function render(string $key, TemplateOptions $options): string
    {
        $cacheKey = $this->getCacheKey($key);
        $compiled = $this->cache->get($cacheKey);
        if ($compiled === null) {
            throw new TemplateMissingException($key, $options);
        }

        return $this->renderCompiled($compiled, $key, $options);
    }

    protected function renderCompiled(string $compiled, string $key, TemplateOptions $options): string
    {
        $renderContext = static function (
            string $__template_key,
            string $__compiled_template,
            TemplateOptions $options,
            TemplateRendererInterface $xt,
        ): string|ThemedResult {
            try {
                return eval($__compiled_template);
            } catch (\Throwable $e) {
                throw new TemplateRenderException($e->getMessage(), $__template_key, $options, $e);
            }
        };

        return $this->assemble($renderContext($key, $compiled, $options, $this), $options);
    }

    protected function assemble(string|ThemedResult $result, TemplateOptions $options): string
    {
        if (is_string($result)) {
            return $result;
        }

        if ($result->theme) {
            return $this->render($result->theme, new ThemeOptions($result->blocks, $options));
        }

        return implode('', $result);
    }

    protected function getCacheKey(string $key): string
    {
        return hash('sha256', $key);
    }
}
