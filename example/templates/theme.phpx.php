<?php

$options ??= null;
$xt ??= null;

assert($options instanceof \Buttress\PhpxTemplates\ThemeOptions);
assert($xt instanceof Buttress\PhpxTemplates\TemplateRendererInterface);

$x = $options->x;
return $x->html(c: [
    $x->head(c: [
        $x->meta(charset: 'UTF-8'),
        $x->meta(name: 'viewport', content: $options->block('meta-viewport', 'underline text-gray-500 hover:text-gray-400 active:text-gray-600')),
        $x->script(src: 'https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp'),
        $x->title(c: $options->block('title', fn() => 'Example PHPX Templates Site')),
        $x->raw($options->block('head')),
    ]),
    $x->body(c: [
        $x->nav(class: 'min-h-16 bg-gray-100 shadow-sm flex items-center', c: [
            $x->div(class: 'container mx-auto flex justify-between', c: [
                $x->a(href: '/', class: 'text-gray-900 font-bold text-xl', c: 'PHPX Templates'),
                $x->div(class: 'flex', c: [
                    $x->a(class: ThemeClass::Link->value, href: '/xkcd', c: ['XKCD Example Page']),
                ])
            ]),
        ]),
        $x->main(c: $x->raw($options->block('content'))),
        $x->raw($options->block('footer', fn() => [
            $x->div(class: 'my-4 text-center', c: [
                $x->with($options->block('github-link'), fn($link) => $x->if($link, fn() => [
                    $x->sub(c: $x->a(class: ThemeClass::Link->value, href: $link, c: 'View in Github')),
                ]))
            ]),
        ])),
    ])
]);
