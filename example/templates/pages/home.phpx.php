<?php

$options ??= null;
$xt ??= null;

assert($options instanceof \Phpx\Templates\TemplateOptions);
assert($xt instanceof Phpx\Templates\TemplateRendererInterface);

$highlight = [
    'default' => 'text-indigo-100',
    'keyword' => 'text-emerald-300',
    'string' => 'text-red-200',
];

foreach ($highlight as $key => $class) {
    ini_set('highlight.' . $key, "\" class=\"{$class}");
}
$x = $options->x;

return \Phpx\Templates\ThemedResult::create('theme')
    ->withBlock('github-link', 'https://github.com/buttress/phpx/blob/main/eample/templates/pages/home.phpx.php')
    ->withBlock(
        'content',
        $x->div(class: 'flex container mx-auto justify-between', c:[
            $x->div(class: 'w-96 pt-4', c: [
                $x->ul(c: [
                    $x->li(c: [
                        $x->a(class: ThemeClass::Link->value, href: '#nav-phpx', c: 'PHPX Templates'),
                        $x->ul(class: 'ml-6 list-disc', c: [
                            $x->li(c: $x->a(class: ThemeClass::Link->value, href: '#nav-compose', c: 'Composable Template')),
                            $x->li(c: $x->a(class: ThemeClass::Link->value, href: '#nav-compose', c: 'Theme')),
                        ])
                    ])
                ])
            ]),
            $x->div(class: 'max-w-none prose lg:prose-xl container pt-4', c: [
                $x->h1(id: 'nav-phpx', class: 'text-3xl my-2 mb-4', c: 'PHPX Templates'),
                $x->p(c: [
                    'PHPX Templates is a template engine built around ',
                    $x->a(href: 'https://github.com/buttress/phpx', c: 'PHPX'),
                    $x->sup(c: $x->mark(c: '(Safe HTML)')),
                    ' and ',
                    $x->a(href: 'https://github.com/buttress/phpx-compile', c: 'PHPX Compile'),
                    $x->sup(c: $x->mark(c: '(Fast PHPX)')),
                    '.',
                ]),
                $x->h2(id: 'nav-compose', class: 'text-2xl my-2 mb-4', c: 'Composable Template'),
                $x->code(c: '/templates/pages/home.phpx.php'),
                $x->raw(
                    highlight_string(<<<'PHP'
                    <?php
                    assert($options instanceof \Phpx\Templates\TemplateOptions);
                    $x = $options->x;
                    
                    return \Phpx\Templates\ThemedResult::create('my/theme')
                        ->withBlock('content', $x->div('Here\'s the content'));
                    PHP, true)
                ),
                $x->h2(id: 'nav-theme', class: 'text-2xl my-2 mb-4', c: 'Theme'),
                $x->raw(
                    str_replace(
                        '<span style="color: " class="text-indigo-100">$x</span><span style="color: " class="text-emerald-300">-&gt;</span><span style="color: " class="text-indigo-100">block</span>',
                        '<span class="text-indigo-200 bg-violet-900">$x</span><span class="text-emerald-400 bg-violet-900">-&gt;</span><span class="text-indigo-200 bg-violet-900">block</span>',
                        highlight_string(<<<'PHP'
                            <?php
                            assert($options instanceof \Phpx\Templates\ThemeOptions);
                            
                            return $x->html(c: [
                                $x->head(c: [
                                    $x->title(c: $x->block('head-title', 'My site title')),
                                    $x->raw($x->block('head-extra')),
                                ]),
                                $x->body(c: [
                                    $x->header(c: $x->h1($x->block('title', 'My Site')),
                                    $x->main(c: [
                                        $x->raw($x->block('content', fn() => $x->div('No content provided.')))
                                    ])
                                ])
                            ])
                            PHP, true)
                    )
                ),
            ]),
        ])
    );
