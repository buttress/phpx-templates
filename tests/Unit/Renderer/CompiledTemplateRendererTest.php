<?php

require_once __DIR__ . '/TestTemplateOptions.php';

it('renders from cache', function () {
    $cache = Mockery::spy(\Psr\SimpleCache\CacheInterface::class);
    $renderer = new \Buttress\PhpxTemplates\Renderer\CompiledTemplateRenderer($cache);

    $expect = random_int(0, 1e9);
    $testKey = 'foo/baz';
    $options = new TestTemplateOptions($expect);

    $cache->expects('get')->with(hash('sha256', $testKey))->andReturn('return $options->test;');

    expect($renderer->render($testKey, $options))->toBe((string) $expect);
});

it('throws if template isn\'t cached', function () {
    $cache = Mockery::spy(\Psr\SimpleCache\CacheInterface::class);
    $renderer = new \Buttress\PhpxTemplates\Renderer\CompiledTemplateRenderer($cache);

    expect(fn() => $renderer->render('foo', new TestTemplateOptions('')))
        ->toThrow(\Buttress\PhpxTemplates\Exception\TemplateMissingException::class);
});

it('throws if template throws', function () {
    $cache = Mockery::spy(\Psr\SimpleCache\CacheInterface::class);
    $renderer = new \Buttress\PhpxTemplates\Renderer\CompiledTemplateRenderer($cache);

    $cache->expects('get')->with(hash('sha256', 'foo'))->andReturn('throw new \RuntimeException("test");');

    expect(fn() => $renderer->render('foo', new TestTemplateOptions('')))
        ->toThrow(\Buttress\PhpxTemplates\Exception\TemplateRenderException::class);
});
