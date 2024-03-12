<?php

use Phpx\Templates\TemplateOptions;

readonly class TestTemplateOptions extends TemplateOptions
{
    public function __construct(public mixed $test)
    {
        parent::__construct(Mockery::mock(\Buttress\Phpx\Phpx::class));
    }
}
