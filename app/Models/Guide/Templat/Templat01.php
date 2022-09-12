<?php

namespace App\Models\Guide\Templat;

use CodeIgniter\Model;

class Templat01 extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'defaults';
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

    var $path = '/dvn/guide/';

    function export()
        {
            #XML
            $sx = '<?xml version="1.0" encoding="UTF-8"?>';
            $sx .= '<body>';
            $sx .= '<h1>User Guide</h1>';
            $sx .= '</body>';

            /***** MENU */
            $GuideSection = new \App\Models\Guide\GuideSection();
            $dt = $GuideSection->where('sc_father is null')->orderBy('sc_seq')->findAll();

            $sx .= '<div class="col-3 fixed menu_guide">';
            $sx .= '<ul class="menu_guide_ul">';
            for($r=0;$r < count($dt);$r++)
                {
                    $line = $dt[$r];
                    $linka = '</a>';
                    $link = '<a href="'.$this->path.$line['sc_path'].'">';
                    $sx .= '<li class="menu_guide_item">' . $link.$line['sc_name'].$linka . '</li>';
                }
            $sx .= '</ul>';

            echo $sx;
            echo '<pre>';
            print_r($dt);
        }
}
