<?php

namespace App\Controllers;

helper(['boostrap', 'url', 'sisdoc_forms', 'form', 'nbr', 'sessions', 'cookie']);


use App\Controllers\BaseController;

define("PATH", base_url());
define("URL", base_url());
define("MODULE", '');
define("COLLECTION", '');

class Index extends BaseController
{
    public function index($d1 = '', $d2 = '', $d3 = '', $d4 = '', $d5 = '')
    {
        $thema = 'Laion';
        $sx = view('Headers/header');
        $sx .= metarefresh('/manual');

        return $sx;
    }
}
