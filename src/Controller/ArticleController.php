<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;

final class ArticleController extends Controller
{
    public function show(int $id): void
    {
        $articleRepository = new ArticleRepository();
        $article = $articleRepository->findById($id);

        if ($article === null) {
            $this->notFound();

            return;
        }

        $articleRepository->incrementViews($id);
        $article['views'] = (int) $article['views'] + 1;

        $this->view->render('article.tpl', [
            'title' => $article['title'],
            'article' => $article,
            'categories' => $articleRepository->findCategoriesByArticleId($id),
            'relatedArticles' => $articleRepository->findRelated($id),
        ]);
    }
}
