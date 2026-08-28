<?php

declare(strict_types=1);

namespace App;

use App\Controller\ArticleController;
use App\Controller\CategoryController;
use App\Controller\HomeController;

final class Router
{
    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        if ($method === 'GET' && $path === '/') {
            (new HomeController())->index();

            return;
        }

        if ($method === 'GET' && preg_match('#^/category/(\d+)$#', $path, $matches)) {
            (new CategoryController())->show((int) $matches[1]);

            return;
        }

        if ($method === 'GET' && preg_match('#^/article/(\d+)$#', $path, $matches)) {
            (new ArticleController())->show((int) $matches[1]);

            return;
        }

        http_response_code(404);
        (new View())->render('404.tpl', [
            'title' => 'Страница не найдена',
        ]);
    }
}
