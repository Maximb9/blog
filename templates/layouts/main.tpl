<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$title|escape}</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
<div class="page">
    <header class="header">
        <a href="/" class="logo">Blog</a>
    </header>

    <main>
        {block name="content"}{/block}
    </main>
</div>
</body>
</html>
