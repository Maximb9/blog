<?php

declare(strict_types=1);

namespace App\Controller;

use App\View;

abstract class Controller
{
    protected View $view;

    public function __construct()
    {
        $this->view = new View();
    }

    protected function notFound(): void
    {
        http_response_code(404);
        $this->view->render('404.tpl', [
            'title' => 'Страницв не найдена',
        ]);
    }
}
