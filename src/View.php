<?php

declare(strict_types=1);

namespace App;

use Smarty\Smarty;

final class View
{
    private Smarty $smarty;

    public function __construct()
    {
        $config = require dirname(__DIR__) . '/config/app.php';

        if (!is_dir($config['compile_dir'])) {
            mkdir($config['compile_dir'], 0777, true);
        }

        $this->smarty = new Smarty();
        $this->smarty->setTemplateDir($config['template_dir']);
        $this->smarty->setCompileDir($config['compile_dir']);
    }

    public function render(string $template, array $data = []): void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display($template);
    }
}
