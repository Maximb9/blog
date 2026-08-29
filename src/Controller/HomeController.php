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

        $categoryList = $categoryRepository->findWithArticles();
        $articlesByCategory = $articleRepository->findLatestGroupedByCategoryIds(
            array_column($categoryList, 'id')
        );

        $categories = [];

        foreach ($categoryList as $category) {
            $categories[] = [
                'category' => $category,
                'articles' => $articlesByCategory[(int) $category['id']] ?? [],
            ];
        }

        $this->view->render('home.tpl', [
            'title' => 'Блог',
            'categories' => $categories,
        ]);
    }
}
