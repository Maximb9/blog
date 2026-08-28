<article class="article-card">
    {if $article.image}
        <img src="{$article.image|escape}" alt="{$article.title|escape}" class="article-card__image">
    {/if}

    <h3>
        <a href="/article/{$article.id}">{$article.title|escape}</a>
    </h3>

    <p>{$article.description|escape}</p>
    <p class="article-card__meta">Просмотры: {$article.views|escape}</p>
</article>
