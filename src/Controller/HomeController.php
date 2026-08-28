<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;

final class HomeController extends Controller
{
    public function index(): void
    {
        $categoryRepository = new CategoryRepository();
        $articleRepository = new ArticleRepository();

        $categories = [];

        foreach ($categoryRepository->findWithArticles() as $category) {
            $categories[] = [
                'category' => $category,
                'articles' => $articleRepository->findLatestByCategoryId((int) $category['id']),
            ];
        }

        $this->view->render('home.tpl', [
            'title' => 'Блог',
            'categories' => $categories,
        ]);
    }
}
