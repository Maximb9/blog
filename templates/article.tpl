{extends file="layouts/main.tpl"}

{block name="content"}
    <div class="article-page">
        <a href="/" class="article-page__back">На главную</a>

        <article class="article">
            <header class="article__header">
                <div class="article__categories">
                    {foreach $categories as $category}
                        <a href="/category/{$category.id}" class="article__category">{$category.name|escape}</a>
                    {/foreach}
                </div>
                <h1 class="article__title">{$article.title|escape}</h1>
                <p class="article__description">{$article.description|escape}</p>
                <p class="article__meta">
                    {$article.published_at|date_format:'%d.%m.%Y'} · {$article.views|escape} просмотров
                </p>
            </header>

            {if $article.image}
                <img src="{$article.image|escape}" alt="{$article.title|escape}" class="article__image">
            {/if}

            <div class="article__content">{$article.content nofilter}</div>
        </article>

        {if $relatedArticles|@count > 0}
            <section class="related">
                <h2 class="related__title">Похожие статьи</h2>
                <div class="article-list">
                    {foreach $relatedArticles as $article}
                        {include file="partials/article-card.tpl" article=$article}
                    {/foreach}
                </div>
            </section>
        {/if}
    </div>
{/block}
