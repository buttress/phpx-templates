<?php

namespace Phpx\Templates;

readonly class ThemedResult
{
    protected function __construct(
        public string $theme,
        /**
         * @param array<string, mixed> $blocks
         */
        public array $blocks = []
    ) {}

    final public static function create(string $theme, array $blocks = []): self
    {
        return new self($theme, $blocks);
    }

    public function withTheme(string $theme): self
    {
        return self::create($theme, $this->blocks);
    }

    public function withBlock(string $block, mixed $content): self
    {
        return self::create($this->theme, [
            ...$this->blocks,
            $block => $content,
        ]);
    }

    /**
     * @param array<string, string> $blocks
     */
    public function withBlocks(array $blocks): self
    {
        return self::create($this->theme, $blocks);
    }
}
