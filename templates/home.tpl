{extends file="layouts/main.tpl"}

{block name="content"}

    {if $categories|@count === 0}
        <p>Статьи появятся здесь после размещения.</p>
    {/if}

    {foreach $categories as $item}
        <section class="category-block">
            <h2>{$item.category.name|escape}</h2>
            <p>{$item.category.description|escape}</p>

            <div class="articles">
                {foreach $item.articles as $article}
                    {include file="partials/article-card.tpl" article=$article}
                {/foreach}
            </div>

            <a href="/category/{$item.category.id}" class="button">Все статьи</a>
        </section>
    {/foreach}
{/block}
