<?php

$options ??= null;
$xt ??= null;

assert($options instanceof XkcdTemplateOptions);
assert($xt instanceof Buttress\PhpxTemplates\TemplateRendererInterface);

$x = $options->x;
return [
    'theme' => 'theme',
    'title' => 'XKCD : ' . $options->id,
    'github-link' => 'https://github.com/buttress/phpx/blob/main/eample/templates/pages/xkcd.phpx.php',
    'content' => [
        $x->div(class: 'container mx-auto pt-4', c: [
            $x->div(class: 'flex flex-col h-100 items-center', c: [
                // XKCD Item
                $x->h1(class: 'text-4xl mb-3', c: $options->title),
                $x->div(class: 'h-[calc(100vh-12rem)] w-1/2 flex justify-center', c: [
                    $x->img(class: 'w-full  object-contain', src: $options->img, title: $options->alt)
                ]),

                // Pagination
                $x->div(class: 'flex', c: [
                    $x->if(
                        $options->id > 0,
                        fn() => $x->a(id: 'xkcdPrev', class: ThemeClass::Link->value, href: sprintf('/xkcd/%d', $options->id - 1), c: 'Prev'),
                        fn() => $x->span(class: 'text-gray-300', c: 'Prev')
                    ),
                    $x->strong(class: 'px-2', c: $options->id),
                    $x->a(id: 'xkcdNext', class: ThemeClass::Link->value, href: sprintf('/xkcd/%d', $options->id + 1), c: 'Next'),
                ])
            ]),

            // Simple keyboard navigation
            $x->script(
                c: <<<'SCRIPT'
                document.addEventListener('keyup', function (e) {
                    if (e.key === 'ArrowRight') {
                        xkcdNext.click();
                    } else if (e.key === 'ArrowLeft') {
                        xkcdPrev.click();
                    }
                });
                SCRIPT
            ),

            // History rewrite if needed
            $x->script(
                c: <<<SCRIPT
                const expectPath = '/xkcd/{$options->id}';
                if (window.location.path !== expectPath) {
                    window.history.replaceState([], '', expectPath);
                }
                SCRIPT
            )
        ]),
    ]
];
