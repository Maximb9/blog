<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database;
use PDO;

final class ArticleRepository
{
    public function findById(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, title, description, content, image, views, published_at
             FROM articles
             WHERE id = :id'
        );
        $statement->execute(['id' => $id]);
        $article = $statement->fetch();

        return $article ?: null;
    }

    public function findLatestByCategoryId(int $categoryId, int $limit = 3): array
    {
        $statement = Database::connection()->prepare(
            'SELECT a.id, a.title, a.description, a.image, a.views, a.published_at
             FROM articles a
             INNER JOIN article_categories ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id
             ORDER BY a.published_at DESC
             LIMIT :limit'
        );
        $statement->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue('limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function findCategoriesByArticleId(int $articleId): array
    {
        $statement = Database::connection()->prepare(
            'SELECT c.id, c.name
             FROM categories c
             INNER JOIN article_categories ac ON ac.category_id = c.id
             WHERE ac.article_id = :article_id
             ORDER BY c.name'
        );
        $statement->execute(['article_id' => $articleId]);

        return $statement->fetchAll();
    }

    public function incrementViews(int $id): void
    {
        $statement = Database::connection()->prepare(
            'UPDATE articles SET views = views + 1 WHERE id = :id'
        );
        $statement->execute(['id' => $id]);
    }

    public function findRelated(int $articleId, int $limit = 3): array
    {
        $statement = Database::connection()->prepare(
            'SELECT DISTINCT a.id, a.title, a.description, a.image, a.views, a.published_at
             FROM articles a
             INNER JOIN article_categories ac ON ac.article_id = a.id
             WHERE ac.category_id IN (
                 SELECT category_id FROM article_categories WHERE article_id = :article_id
             )
             AND a.id != :exclude_id
             ORDER BY a.published_at DESC
             LIMIT :limit'
        );
        $statement->bindValue('article_id', $articleId, PDO::PARAM_INT);
        $statement->bindValue('exclude_id', $articleId, PDO::PARAM_INT);
        $statement->bindValue('limit', $limit, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
