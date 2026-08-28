<?php

declare(strict_types=1);

namespace App;

final class Router
{
    public function dispatch(): void
    {
        http_response_code(404);
        (new View())->render('404.tpl', [
            'title' => 'Page not found',
        ]);
    }
}
