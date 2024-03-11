<?php

use Buttress\PhpxTemplates\TemplateOptions;

readonly class TestTemplateOptions extends TemplateOptions
{
    public function __construct(public mixed $test)
    {
        parent::__construct(Mockery::mock(\Buttress\PHPX::class));
    }
}
