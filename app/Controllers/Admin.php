<?php

namespace App\Controllers;

helper(['boostrap', 'url', 'sisdoc_forms', 'form', 'nbr','sessions',  'cookie']);
define("PATH", base_url());
define("URL", base_url());
define("MODULE", '/admin');
define("COLLECTION", '/admin');

use App\Controllers\BaseController;

class Admin extends BaseController
{
    function cab()
        {
            $data = array();
            $sx = '';
            $sx .= view('Headers/header', $data);
            $sx .= view('Headers/navbar_admin',$data);
            return $sx;
        }
    function footer()
        {
            return view('Headers/footer');
        }
    public function index($d1='',$d2='',$d3='',$d4='',$d5='')
    {
        $sx = '';
        $Socials = new \App\Models\Socials();
        $user = $Socials->getUser();

        if (($user == 0) and ($d1 != 'social'))
            {
                return $Socials->login();
            }

        switch($d1)
            {
                case 'social':
                    return $Socials->index($d2,$d3,$d4,$d5);
                    break;

                default:
                    $Admin = new \App\Models\Admin\Index();
                    $sx .= $this->cab();
                    $sx .= $Admin->index($d1,$d2,$d3,$d4,$d5);
                    $sx .= $this->footer();
                break;
            }
        return $sx;
    }
}
