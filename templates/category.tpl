{extends file="layouts/main.tpl"}

{block name="content"}
    <div class="category-page">
        <a href="/" class="category-page__back">На главную</a>

        <header class="category-page__header">
            <p class="category-page__label">Категория</p>
            <h1 class="category-page__title">{$category.name|escape}</h1>
            <p class="category-page__description">{$category.description|escape}</p>
        </header>

        <div class="category-page__sorting">
            <span class="category-page__sorting-label">Сортировать:</span>
            <a href="/category/{$category.id}?sort=date" class="category-page__sort{if $sort === 'date'} category-page__sort--active{/if}">По дате</a>
            <a href="/category/{$category.id}?sort=views" class="category-page__sort{if $sort === 'views'} category-page__sort--active{/if}">По просмотрам</a>
        </div>

        {if $articles|@count === 0}
            <p class="category-page__empty">В этой категории пока нет статей.</p>
        {/if}

        <div class="article-list">
            {foreach $articles as $article}
                {include file="partials/article-card.tpl" article=$article}
            {/foreach}
        </div>

        {if $totalPages > 1}
            <nav class="pagination">
                {if $page > 1}
                    <a class="pagination__link" href="/category/{$category.id}?sort={$sort}&page={$page - 1}">Предыдущая</a>
                {/if}

                <span class="pagination__current">{$page} / {$totalPages}</span>

                {if $page < $totalPages}
                    <a class="pagination__link" href="/category/{$category.id}?sort={$sort}&page={$page + 1}">Следующая</a>
                {/if}
            </nav>
        {/if}
    </div>
{/block}
