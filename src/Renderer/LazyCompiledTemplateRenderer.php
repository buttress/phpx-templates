<?php

namespace Buttress\PhpxTemplates\Renderer;

use Buttress\Compiler;
use Buttress\PhpxTemplates\Exception\TemplateMissingException;
use Buttress\PhpxTemplates\TemplateOptions;
use Psr\SimpleCache\CacheInterface;

class LazyCompiledTemplateRenderer extends CompiledTemplateRenderer
{
    public function __construct(
        protected readonly string $baseDir,
        protected readonly Compiler $compiler,
        CacheInterface $cache,
        public readonly int $ttl = 0,
    ) {
        parent::__construct($cache);
    }

    public function render(string $key, TemplateOptions $options): string
    {
        try {
            return parent::render($key, $options);
        } catch (TemplateMissingException $e) {
            $templateFile = $this->baseDir . '/' . $key;
            if (!str_ends_with($templateFile, '.phpx.php')) {
                $templateFile .= '.phpx.php';
            }

            $compiled = substr($this->compiler->compile(file_get_contents($templateFile)), 5);
            $this->cache->set($this->getCacheKey($key), $compiled, $this->ttl);

            return $this->renderCompiled($compiled, $key, $options);
        }
    }
}
