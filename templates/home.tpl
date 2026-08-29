{extends file="layouts/main.tpl"}

{block name="content"}
    <div class="home">
        <div class="home__intro">
            <h1 class="home__title">Просто о технологиях</h1>
            <p class="home__subtitle">Практические статьи о PHP, базах данных, Docker и создании современных сайтов.</p>
        </div>

        {if $categories|@count === 0}
            <p class="home__empty">Статьи появятся здесь после размещения.</p>
        {/if}

        <div class="home__categories">
            {foreach $categories as $item}
                <section class="category-preview">
                    <div class="category-preview__header">
                        <div>
                            <h2 class="category-preview__title">{$item.category.name|escape}</h2>
                            <p class="category-preview__description">{$item.category.description|escape}</p>
                        </div>
                        <a href="/category/{$item.category.id}" class="category-preview__link">Все статьи</a>
                    </div>

                    <div class="article-list">
                        {foreach $item.articles as $article}
                            {include file="partials/article-card.tpl" article=$article}
                        {/foreach}
                    </div>
                </section>
            {/foreach}
        </div>
    </div>
{/block}
