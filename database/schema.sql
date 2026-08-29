USE blog;

CREATE TABLE categories
(
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(255) NOT NULL,
    description TEXT         NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE articles
(
    id           INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title        VARCHAR(255) NOT NULL,
    description  TEXT         NOT NULL,
    content      TEXT         NOT NULL,
    image        VARCHAR(255) NOT NULL DEFAULT '',
    views        INT UNSIGNED NOT NULL DEFAULT 0,
    published_at DATETIME     NOT NULL,
    INDEX        idx_articles_published_at (published_at),
    INDEX        idx_articles_views (views)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE article_categories
(
    article_id  INT UNSIGNED NOT NULL,
    category_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (article_id, category_id),
    CONSTRAINT fk_article_categories_article
        FOREIGN KEY (article_id) REFERENCES articles (id)
            ON DELETE CASCADE,
    CONSTRAINT fk_article_categories_category
        FOREIGN KEY (category_id) REFERENCES categories (id)
            ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
