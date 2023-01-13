<?php

namespace App\Controllers;

$this->session = \Config\Services::session();
$language = \Config\Services::language();

helper(['boostrap', 'url', 'sisdoc_forms', 'form', 'nbr', 'sessions', 'cookie']);
define("PATH", base_url());
define("URL", base_url());
define("MODULE", '/admin');
define("COLLECTION", '/guide');

class Guide extends BaseController
{
    public function socials($d1='',$d2='',$d3='',$d4='',$d5='')
        {
            $cmd = get("cmd");
            if ($cmd != '') { $d1 = $cmd; }
            $Socials = new \App\Models\Socials();
            $sx = $Socials->index($d1,$d2,$d3,$d4,$d5);
            return $sx;
        }


    public function index($d1='', $d2 ='', $d3 ='', $d4 = '')
    {
        $project = new \App\Models\Guide\GuideProject();
        $GuideSection = new \App\Models\Guide\GuideSection();
        $GuideHeaderFooter = new \App\Models\Guide\GuideHeaderFooter();

        $dt = $project->where('pj_path',$d1)->first();
        if ($dt == '')
            {
                $dt = $project->first();
                if ($dt == '') {
                    echo "ERRO DE ACESSO AO GUIA";
                    exit;
                }
            }

        $prj = $dt['id_pj'];

        $sx = view('Headers/header');

        if ($d1=='')
            {
                $sx .= bs($project->indice($prj, $d2, $d3));
            } else {
                $dts = $GuideSection->where('sc_path',$d2)->first();
                $sec = $dts['id_sc'];
                $sx .= $GuideHeaderFooter->content('H', $prj);
                $sx .= bs($project->view_guide($sec, $d2, $d3));
                $sx .= $GuideHeaderFooter->content('F', $prj);

            }

        $sx .= view('Headers/footer');
        return $sx;
    }
}
