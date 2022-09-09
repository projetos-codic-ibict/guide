<?php

namespace App\Controllers;

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
                            case '':
                                //$sx .= view('Guide/index');
                                break;
                            case 'sections':
                                $GuideSection = new \App\Models\Guide\GuideSection();
                                $sx .= $GuideSection->index($d3);
                                break;
                            case 'contents':
                                //$sx .= view('Guide/contents');
                                break;
                        }
                    $sx .= "HELLO $d1 $d2 $d3";
                    break;
                default:
                return view('welcome_message');
            }
        return $sx;
    }
}
