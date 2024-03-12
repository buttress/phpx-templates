<?php

use Phpx\Compile\Compiler;
use Phpx\Templates\Renderer\LazyCompiledTemplateRenderer;
use Phpx\Templates\TemplateOptions;
use PhpParser\ParserFactory;

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../ExampleCache.php';
require_once __DIR__ . '/../ErrorTemplateOptions.php';
require_once __DIR__ . '/../XkcdTemplateOptions.php';
require_once __DIR__ . '/../ThemeClass.php';

$root = __DIR__ . '/../templates';
$templateRenderer = new LazyCompiledTemplateRenderer(
    $root,
    new Compiler((new ParserFactory())->createForHostVersion()),
    new ExampleCache(),
    5,
);

$xkcd = function (\Phpx\Templates\TemplateRendererInterface $renderer, \Buttress\Phpx\Phpx $x, ?string $id) {
    $itemId = (int) $id;

    $response = null;
    $code = 0;
    if ($itemId > 0) {
        $curl = curl_init("https://xkcd.com/{$itemId}/info.0.json");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    }
    if (!$response || $code !== 200) {
        $curl = curl_init("https://xkcd.com/info.0.json");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    }

    if (!$response || $code !== 200) {
        throw new \RuntimeException('Unable to fetch XKCD API.');
    }

    $response = json_decode($response, true, 3, JSON_THROW_ON_ERROR);
    return $renderer->render('pages/xkcd', new XkcdTemplateOptions(
        (int) ($response['num'] ?? 0),
        $response['transcript'] ?? '',
        $response['alt'] ?? '',
        $response['img'] ?? '',
        $response['title'] ?? '',
        $response['safe_title'] ?? '',
        $x,
    ));
};

$requestPath = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$phpx = new \Buttress\Phpx\Phpx();
try {
    $result = match (true) {
        $requestPath === '' || $requestPath === '/' => $templateRenderer->render('pages/home', new TemplateOptions($phpx)),
        preg_match('~^/xkcd/?(\d+)?/?~', $requestPath, $matches) !== false => $xkcd($templateRenderer, $phpx, $matches[1] ?? null),
        default => $templateRenderer->render('errors/404', new TemplateOptions($phpx)),
    };
} catch (\Phpx\Templates\Exception\Exception $e) {
    $result = $templateRenderer->render('errors/error', new ErrorTemplateOptions($e->getMessage(), $e, 500, $phpx));
} catch (\Throwable $e) {
    $result = $templateRenderer->render('errors/error', new ErrorTemplateOptions('Unknown error.', $e, 500, $phpx));
}

echo $result;
