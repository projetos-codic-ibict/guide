<?php

namespace App\Controllers;

helper(['boostrap', 'url', 'sisdoc_forms', 'form', 'nbr', 'sessions', 'cookie']);
$session = \Config\Services::session();
define("PATH", base_url());
class Guide extends BaseController
{
    public function index($d1='', $d2 ='', $d3 = '')
    {
        $sx = view('Headers/header');
        $sx .= view('Headers/navbar');
        switch($d1)
            {
                case 'guide':
                    switch($d2)
                        {
                            case 'export':
                                $HTML = new \App\Models\Guide\Templat\Templat01();
                                $HTML->export();
                                break;
                            case '':
                                //$sx .= view('Guide/index');
                                break;

                            case 'sections':
                                $GuideSection = new \App\Models\Guide\GuideSection();
                                $sx .= $GuideSection->index($d3);
                                break;
                            case 'createsecao':
                                $GuideSection = new \App\Models\Guide\GuideSection();
                                $sx .= $GuideSection->edit(0);
                                break;
                            case 'sections_delete':
                                $GuideSection = new \App\Models\Guide\GuideSection();
                                $sx .= $GuideSection->confirm_delete($d3);
                                break;
                            case 'sections_view':
                                $GuideSection = new \App\Models\Guide\GuideSection();
                                $sx .= $GuideSection->view($d3);
                                break;

                            case 'sections_edit':
                                if (isset($_GET['id']))
                                    {
                                        $id = round($_GET['id']);
                                        $GuideSection = new \App\Models\Guide\GuideSection();
                                        $sx .= $GuideSection->edit($id);
                                    }
                                break;
                            case 'contents':
                                //$sx .= view('Guide/contents');
                                break;
                            default:
                                $sx .= "HELLO $d1 $d2 $d3";
                                break;
                        }
                        break;
                default:
                return view('welcome_message');
            }
        return $sx;
    }
}
