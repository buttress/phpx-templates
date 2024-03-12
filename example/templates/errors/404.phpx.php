<?php

$options ??= null;
$xt ??= null;

assert($options instanceof \Phpx\Templates\TemplateOptions);
assert($xt instanceof Phpx\Templates\TemplateRendererInterface);

$x = $options->x;
return \Phpx\Templates\ThemedResult::create('theme')
    ->withBlock('content', $x->div(class: 'container mx-auto', c: [
        $x->div(class: 'flex h-full w-full items-center text-center justify-center', c: [
            $x->div(class: 'h-16', c: [
                $x->div(class: 'outline-gray-200 outline', c: [
                    $x->code(class: 'mb-2 block bg-gray-100 text-xs border-b', c: '404 Not Found'),
                    $x->div(class: 'px-2 pb-2', c: [
                        $x->span(class: 'font-bold block', c: 'That page doesn\'t exist. '),
                        $x->a(class: ThemeClass::Link->value, href: '/', c: 'Go Home'),
                    ]),
                ]),
            ]),
        ]),
    ]));
