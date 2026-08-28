<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;

final class CategoryController extends Controller
{
    private const PER_PAGE = 6;

    public function show(int $id): void
    {
        $categoryRepository = new CategoryRepository();
        $category = $categoryRepository->findById($id);

        if ($category === null) {
            $this->notFound();

            return;
        }

        $sort = $_GET['sort'] ?? 'date';
        if (!in_array($sort, ['date', 'views'], true)) {
            $sort = 'date';
        }

        $page = max(1, (int) ($_GET['page'] ?? 1));
        $totalArticles = $categoryRepository->countArticles($id);
        $totalPages = max(1, (int) ceil($totalArticles / self::PER_PAGE));

        if ($page > $totalPages) {
            $page = $totalPages;
        }

        $articles = $categoryRepository->findArticles(
            $id,
            $sort,
            self::PER_PAGE,
            ($page - 1) * self::PER_PAGE
        );

        $this->view->render('category.tpl', [
            'title' => $category['name'],
            'category' => $category,
            'articles' => $articles,
            'sort' => $sort,
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
