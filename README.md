<p align="center">
    <code lang="html">&lt;PHPX templates /&gt;</code><br><br>
    PHPX Templates is a template engine built around <a href="/buttress/phpx">PHPX</a> and <a href="/buttress/phpx-compile">PHPX Compile</a> 
</p>

---

### Theme
```php
<?php
assert($options instanceof \Buttress\PhpxTemplates\ThemeOptions);
$x = $options->x;

return $x->html(c: [
    $x->head(c: [
        $x->title(c: $options->block('head-title', 'My default site title')),
        $x->raw($options->block('head-extra')),
    ]),
    $x->body(c: [
        $x->header(c: $x->h1($options->block('title', 'My Site')),
        $x->main(c: [
            $x->raw($options->block('content', fn() => $x->div('No content provided.')))
        ])
    ])
]);
```

### Page
```php
<?php
// Change this to match what your template expects
assert($options instanceof \Buttress\PhpxTemplates\TemplateOptions);
$x = $options->x;

return [
    'theme' => 'my/theme',
    'title' => 'My custom page title',
    'content' => $x->div('Here\'s the content'),
];
```

## Installation

To install PHPX, use composer:

```bash
composer require buttress/templates
```

## Usage

See the example for basic usage

## Related Projects
- [PHPX](https://github.com/buttress/phpx) A fluent DOMDocument wrapper that makes it easy to write safe valid HTML in plain PHP.
- [PHPX Compile](https://github.com/buttress/phpx-compile) An experimental compiler for PHPX. Significantly reduces function calls.


## Contributing

Contributions to PHPX Templates are always welcome! Feel free to fork the repository and submit a pull request.

## License

PHPX Templates is released under the MIT License.

## Githooks
To add our githooks and run tests before commit:
```bash
git config --local core.hooksPath .githooks
```

## Support

If you encounter any problems or have any questions, please open an issue on GitHub.

Thanks for checking out PHPX Templates ❤️