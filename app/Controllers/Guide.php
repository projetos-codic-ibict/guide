<?php

namespace App\Controllers;

$this->session = \Config\Services::session();
$language = \Config\Services::language();

helper(['boostrap', 'url', 'sisdoc_forms', 'form', 'nbr', 'sessions', 'cookie']);
define("PATH", base_url());
define("URL", base_url());
define("MODULE",'');
define("COLLECTION", '');

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

    public function ajax($d1='',$d2='',$d3='',$d4='',$d5='')
        {
            switch($d1)
                {
                    case 'block':
                        $GuideContent = new \App\Models\Guide\GuideContent();
                        $GuideContent->ajax($d2,$d3,$d4,$d5);
                        break;
                    case 'section':
                        $GuideSection = new \App\Models\Guide\GuideSection();
                        $GuideSection->ajax($d2,$d3,$d4,$d5);
                        break;
                    default:
                        pre($_POST, false);
                        pre($_GET, false);
                        echo h('GUIDE AJAX');
                        echo "<pre>
                        d1 = $d1
                        d2 = $d2
                        d3 = $d3
                        d4 = $d4
                        d5 = $d5
                        </pre>";
                        break;
                }
        }
    public function index($d1='',$d2='',$d3='',$d4='',$d5='')
        {
            $thema = 'Laion';
            $sx = view('Headers/header');
            $data['menu'] = 'MENU';
            $data['content'] = 'CONTEÚDO';
            $sx .= view('Theme/'.$thema.'/index',$data);
            return $sx;
        }
    public function admin($d1='', $d2 ='', $d3 ='', $d4 = '')
    {
        $Socials = new \App\Models\Socials();

        $sx = view('Headers/header');
        $sx .= view('Headers/navbar');
        $user = $Socials->getuser();

        if ($user == 0)
            {
                $d1 = 'login';
            }

        switch($d1)
            {
                case 'social':
                    echo "OK";
                    exit;
                case 'login':
                    $data['login'] = $Socials->login();
                    $sx = view('Headers/header');
                    $sx .= view('Guide/login',$data);
                    return $sx;
                    break;
                case 'guide':
                    switch($d2)
                        {
                            case 'project':
                                $project = new \App\Models\Guide\GuideProject();
                                $sx .= $project->index($d2,$d3,$d4);
                                break;
                            /************************************************ Content */
                            case 'content_edit':
                                $GuideContent = new \App\Models\Guide\GuideContent();
                                $sx = view('Headers/header');
                                $sx .= $GuideContent->edit($d3,$d4);
                                break;

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
                                $sx .= "HELLO $d1 $d2 $d3 $d4";
                                break;
                        }
                        break;
                default:
                $GuideProject = new \App\Models\Guide\GuideProject();
                $data = array();
                $data['projects'] = $GuideProject->projects();
                $sx .= view('drashboard',$data);
                return $sx;
            }
        $sx .= view('Headers/footer');
        return $sx;
    }
}
