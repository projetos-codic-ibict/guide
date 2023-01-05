<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideVariables extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide_variables';
    protected $primaryKey       = 'id_v';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_v', 'v_name', 'v_pj', 'updated_at'
    ];

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

    function index($d1,$d2,$d3)
        {
            $sx = '';
            switch($d1)
                {
                    default:
                        $sx = $this->list();
                }
            return $sx;
        }

    function list()
        {
            $sx = '';
            $GuideProject = new \App\Models\Guide\GuideProject();
            $prj = $GuideProject->getProject();

            if ($prj != '')
                {
                    $dt = $GuideProject->le($prj);
                    $sx .= $GuideProject->header($dt);

                    $dtl = $this->where('v_pj',$prj)->findAll();
                    for ($r=0;$r < count($dtl);$r++)
                        {
                            $line = $dtl[$r];
                            $sx .= bsc(h($line['v_name'],4),4);
                            $sx .= bsc('descrição',8);
                        }
                    if (count($dtl) == 0)
                        {
                            $sx .= lang('guide.nothing_variables');
                        }
                }
            $sx = bs($sx);
            return $sx;
        }

    function detect($txt)
        {
            $var = array();
            $txt = troca($txt,array(',','.','!',':','?'), ' ');
            while($pos = strpos($txt,'$'))
                {
                    $v = substr($txt,$pos,100);
                    $v = substr($v,0,strpos($v,' '));
                    echo $v.'<br>';
                }
        }
}