<?php

namespace App\Models\Admin;

use CodeIgniter\Model;

class Ajax extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'ajaxes';
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

    public function index($d1 = '', $d2 = '', $d3 = '', $d4 = '', $d5 = '')
    {
        switch ($d1) {
            case 'block':
                $GuideContent = new \App\Models\Guide\GuideContent();
                $GuideContent->ajax($d2, $d3, $d4, $d5);
                break;
            case 'section':
                $GuideSection = new \App\Models\Guide\GuideSection();
                $GuideSection->ajax($d2, $d3, $d4, $d5);
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
}
