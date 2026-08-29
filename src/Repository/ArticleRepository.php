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

    public function findLatestGroupedByCategoryIds(array $categoryIds, int $limit = 3): array
    {
        if ($categoryIds === []) {
            return [];
        }

        $categoryIds = array_map('intval', $categoryIds);
        $placeholders = implode(', ', array_fill(0, count($categoryIds), '?'));

        $statement = Database::connection()->prepare(
            "SELECT a.id, a.title, a.description, a.image, a.views, a.published_at,
                    ac.category_id
             FROM articles a
             INNER JOIN article_categories ac ON ac.article_id = a.id
             WHERE ac.category_id IN ($placeholders)
             ORDER BY ac.category_id, a.published_at DESC"
        );
        $statement->execute($categoryIds);

        $grouped = [];

        foreach ($statement->fetchAll() as $row) {
            $categoryId = (int) $row['category_id'];

            if (!isset($grouped[$categoryId])) {
                $grouped[$categoryId] = [];
            }

            if (count($grouped[$categoryId]) >= $limit) {
                continue;
            }

            unset($row['category_id']);
            $grouped[$categoryId][] = $row;
        }

        return $grouped;
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
