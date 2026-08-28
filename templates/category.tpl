{extends file="layouts/main.tpl"}

{block name="content"}
    <h1>{$category.name|escape}</h1>
    <p>{$category.description|escape}</p>

    <div class="sorting">
        <span>Sort:</span>
        <a href="/category/{$category.id}?sort=date"{if $sort === 'date'} class="active"{/if}>По дате</a>
        <a href="/category/{$category.id}?sort=views"{if $sort === 'views'} class="active"{/if}>По количеству просмотров</a>
    </div>

    {if $articles|@count === 0}
        <p>В этой категории пока нет статей.</p>
    {/if}

    <div class="articles">
        {foreach $articles as $article}
            {include file="partials/article-card.tpl" article=$article}
        {/foreach}
    </div>

    {if $totalPages > 1}
        <div class="pagination">
            {if $page > 1}
                <a href="/category/{$category.id}?sort={$sort}&page={$page - 1}">Предыдущий</a>
            {/if}

            <span>Страница {$page} из {$totalPages}</span>

            {if $page < $totalPages}
                <a href="/category/{$category.id}?sort={$sort}&page={$page + 1}">Следующий</a>
            {/if}
        </div>
    {/if}
{/block}
