<article class="article-card">
    <a href="/article/{$article.id}" class="article-card__image-link">
        {if $article.image}
            <img src="{$article.image|escape}" alt="{$article.title|escape}" class="article-card__image">
        {/if}
    </a>

    <div class="article-card__body">
        <p class="article-card__meta">
            {$article.published_at|date_format:'%d.%m.%Y'} · {$article.views|escape} просмотров
        </p>
        <h3 class="article-card__title">
            <a href="/article/{$article.id}" class="article-card__title-link">{$article.title|escape}</a>
        </h3>
        <p class="article-card__description">{$article.description|escape}</p>
    </div>
</article>
