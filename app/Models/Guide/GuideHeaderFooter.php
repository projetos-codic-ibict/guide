<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideHeaderFooter extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide_header_foot';
    protected $primaryKey       = 'id_hd';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_hd','hd_project','hd_type','hd_code', 'updated_at'
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
            $GuideProjec = new \App\Models\Guide\GuideProject();
            $prj = $GuideProjec->getId();

            $sx = '';
            switch($d1)
                {
                    default:
                        $sx .= $this->edit($d2,'H',$prj);
                }
            return $sx;
        }

    function edit($id=0,$type='H',$prj=0)
        {
            $dt = $this->where('hd_project',$prj)->where('hd_type',$type)->first();
            if ($dt == '')
                {
                    $dt['hd_project'] = $prj;
                    if ($type == 'H')
                        {
                            $dt['hd_code'] = '<header>'.cr();
                            $dt['hd_code'] .= '<title>Title</title>'.cr();
                            $dt['hd_code'].= '</header>';
                        } else {
                            $dt['hd_code'] = '<footer>' . cr() . '</footer>';
                        }

                    $dt['hd_type'] = $type;
                    $dt['id_hd'] = $this->set($dt)->insert();
                }
            $sx = '';
            $sx .= form_open();
            $sx .= form_hidden('id_hd',$dt['id_hd']);
            $sx .= '<label>'.lang('guide.config_'.$type).'</label>';
            $sx .= form_textarea(array('name' => 'hd_code', 'value' => $dt['hd_code'], 'class' => 'form-control', 'style'=>'width:100%;"'));
            $sx .= form_submit(array('name'=>'action','value'=>lang('guide.save'),'class'=>'btn btn-outline-primary'));

            $sx = bs(bsc($sx,12));
            return $sx;
        }
}
