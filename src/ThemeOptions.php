<?php

namespace Buttress\PhpxTemplates;

final readonly class ThemeOptions extends TemplateOptions
{
    public function __construct(public array $blocks, public TemplateOptions $options)
    {
        parent::__construct($this->options->x);
    }

    public function block(string $handle, callable|string|null $default = null): string
    {
        $block = $this->blocks[$handle] ?? null;
        if ($block === null) {
            $block = match (true) {
                $default === null => '',
                is_callable($default) => $default(),
                default => $default,
            };
        }

        if ($block instanceof \Iterator) {
            $block = iterator_to_array($block);
        }
        if (is_array($block)) {
            $block = implode('', $block);
        }

        return $block;
    }
}
