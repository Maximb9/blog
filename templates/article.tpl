{extends file="layouts/main.tpl"}

{block name="content"}
    <article class="article">
        {if $article.image}
            <img src="{$article.image|escape}" alt="{$article.title|escape}" class="article__image">
        {/if}

        <h1>{$article.title|escape}</h1>
        <p class="article__meta">
            Дата публикации: {$article.published_at|date_format:'%d.%m.%Y'} · Просмотры: {$article.views|escape}
            {if $categories|@count > 0}
                | Категории:
                {foreach $categories as $category name="cats"}
                    <a href="/category/{$category.id}">{$category.name|escape}</a>{if not $smarty.foreach.cats.last}, {/if}
                {/foreach}
            {/if}
        </p>
        <p class="article__description">{$article.description|escape}</p>
        <div class="article__content">{$article.content nofilter}</div>
    </article>

    {if $relatedArticles|@count > 0}
        <section class="related">
            <h2>Похожие статьи</h2>
            <div class="articles">
                {foreach $relatedArticles as $article}
                    {include file="partials/article-card.tpl" article=$article}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
