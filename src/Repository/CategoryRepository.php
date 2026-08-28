<?php

declare(strict_types=1);

namespace App\Repository;

use App\Database;
use PDO;

final class CategoryRepository
{
    public function findById(int $id): ?array
    {
        $statement = Database::connection()->prepare(
            'SELECT id, name, description FROM categories WHERE id = :id'
        );
        $statement->execute(['id' => $id]);
        $category = $statement->fetch();

        return $category ?: null;
    }

    public function findWithArticles(): array
    {
        $statement = Database::connection()->query(
            'SELECT DISTINCT c.id, c.name, c.description
             FROM categories c
             INNER JOIN article_categories ac ON ac.category_id = c.id
             ORDER BY c.name'
        );

        return $statement->fetchAll();
    }

    public function countArticles(int $categoryId): int
    {
        $statement = Database::connection()->prepare(
            'SELECT COUNT(*)
             FROM articles a
             INNER JOIN article_categories ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id'
        );
        $statement->execute(['category_id' => $categoryId]);

        return (int) $statement->fetchColumn();
    }

    public function findArticles(
        int $categoryId,
        string $sort,
        int $limit,
        int $offset
    ): array {
        $orderBy = $sort === 'views'
            ? 'a.views DESC, a.published_at DESC'
            : 'a.published_at DESC';

        $statement = Database::connection()->prepare(
            "SELECT a.id, a.title, a.description, a.image, a.views, a.published_at
             FROM articles a
             INNER JOIN article_categories ac ON ac.article_id = a.id
             WHERE ac.category_id = :category_id
             ORDER BY {$orderBy}
             LIMIT :limit OFFSET :offset"
        );
        $statement->bindValue('category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue('limit', $limit, PDO::PARAM_INT);
        $statement->bindValue('offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
}
