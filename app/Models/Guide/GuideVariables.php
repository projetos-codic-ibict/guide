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
                            $sx .= bsc($line['v_value'],8);
                        }
                    if (count($dtl) == 0)
                        {
                            $sx .= lang('guide.nothing_variables');
                        }
                }
            $sx = bs($sx);
            return $sx;
        }

    function recover_variable($t)
        {
            $v = '';
            for ($r=0;$r < strlen($t);$r++)
                {
                    $s = substr($t,$r,1);
                    $c = ord($s);
                    if ((($c >= 65) and ($c <= 90)) or ($c == 36) or ($c == 95) or (($c >= 48) and ($c < 57)))
                        {
                            $v .= $s;
                        } else {
                            break;
                        }

                }
            if ($v == '')
                {
                    $v = 'XXX';
                }
            return $v;
            exit;
        }

    function detect($prj,$txt)
        {
            $var = array();
            $txt = troca($txt,array(',','.','!',':','?','/','\\'), ' ');
            while($pos = strpos($txt,'$'))
                {
                    $v = $this->recover_variable(substr($txt,$pos,100));

                    $txt = troca($txt,$v,'[xxx]');
                    if ($v != '')
                        {
                            $this->register($prj,$v);
                        }
                }
        }
        function register($prj,$v)
            {
                $dt = $this
                    ->where('v_name',$v)
                    ->where('v_pj',$prj)
                    ->findAll();
                if (count($dt) == 0)
                    {
                        $dt['v_name'] = $v;
                        $dt['v_pj'] = $prj;
                        $dt['v_value'] = $v;
                        $this->set($dt)->insert();
                    } else {
                        $dt['v_name'] = $v;
                        $dt['v_pj'] = $prj;
                        $dt['v_value'] = $v;
                        $this->set($dt)->where('id_v',$dt[0]['id_v'])->insert();
                    }

            }
}
