<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Index extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'indices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    function index($d1,$d2,$d3,$d4)
        {
            $sx = "XXXXXX $d1 - $d2";

            switch($d1)
                {
                    case 'headers':
                $GuideHeaderFooter = new \App\Models\Guide\GuideHeaderFooter();
                        $sx = $GuideHeaderFooter->index($d2, $d3, $d4);
                        break;
                    case 'style':
                        $GuideStyle = new \App\Models\Guide\GuideCSS();
                        $sx = $GuideStyle->index($d2, $d3, $d4);
                        break;
                    case 'block':
                        $GuideBlock = new \App\Models\Guide\GuideBlock();
                        $sx = $GuideBlock->index($d2,$d3,$d4);
                        break;
                    case 'ajax':
                        $Ajax = new \App\Models\Admin\Ajax();
                        $sx .= $Ajax->index($d2, $d3, $d4);
                        break;
                    case 'guide':
                        $GuideProject = new \App\Models\Guide\GuideProject();
                        $sx .= $GuideProject->index($d2,$d3,$d4);
                        break;
                    case 'media':
                        $GuideMedia = new \App\Models\Guide\GuideMedia();
                        $sx .= $GuideMedia->index($d2, $d3, $d4);
                        break;
                    case 'section':
                        $GuideSection = new \App\Models\Guide\GuideSection();
                        $sx .= $GuideSection->index($d2, $d3, $d4);
                        break;
                    case 'project':
                        echo "OK";
                        exit;
                        $GuideProject = new \App\Models\Guide\GuideProject();
                        $sx .= $GuideProject->index($d2, $d3, $d4);
                        break;
                    case 'vars':
                        $GuideVariables = new \App\Models\Guide\GuideVariables();
                        $sx .= $GuideVariables->index($d2, $d3, $d4);
                        break;
                    default:
                        $sx .= h('Welcome',1);
                }
            return $sx;
        }
}
