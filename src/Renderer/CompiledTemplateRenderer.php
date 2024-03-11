<?php

namespace Buttress\PhpxTemplates\Renderer;

use Buttress\PhpxTemplates\Exception\TemplateMissingException;
use Buttress\PhpxTemplates\Exception\TemplateRenderException;
use Buttress\PhpxTemplates\TemplateOptions;
use Buttress\PhpxTemplates\TemplateRendererInterface;
use Buttress\PhpxTemplates\ThemeOptions;
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
        ): string|iterable {
            try {
                return eval($__compiled_template);
            } catch (\Throwable $e) {
                throw new TemplateRenderException($e->getMessage(), $__template_key, $options, $e);
            }
        };

        return $this->assemble($renderContext($key, $compiled, $options, $this), $options);
    }

    protected function assemble(string|iterable $result, TemplateOptions $options): string
    {
        if (is_string($result)) {
            return $result;
        }

        if ($result instanceof \Iterator) {
            $result = iterator_to_array($result);
        }

        $theme = $result['theme'] ?? null;
        if ($theme) {
            return $this->render($theme, new ThemeOptions($result, $options));
        }

        return implode('', $result);
    }

    protected function getCacheKey(string $key): string
    {
        return hash('sha256', $key);
    }
}
