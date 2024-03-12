<?php

$options ??= null;
$xt ??= null;

assert($options instanceof ErrorTemplateOptions);
assert($xt instanceof Phpx\Templates\TemplateRendererInterface);

$x = $options->x;

return \Phpx\Templates\ThemedResult::create('theme')
    ->withBlock('content', $x->div(class: 'container mx-auto', c: [
        $x->div(class: 'flex h-full w-full items-center text-center justify-center', c: [
            $x->div(class: 'h-16', c: [
                $x->code(class: 'text-xs', c: $options->exception->getMessage()),
                $x->pre(c: (string) $options->exception),
            ]),
        ]),
    ]));
