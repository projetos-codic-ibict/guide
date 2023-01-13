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

    function content($type,$prj)
        {
            $sx = '';
            $dt = $this->where('hd_type',$type)->where('hd_project',$prj)->first();
            if ($dt != '')
                {
                    $sx .= $dt['hd_code'];
                }
            return $sx;
        }

    function index($d1,$d2,$d3)
        {
            $sx = '';
            $GuideProjec = new \App\Models\Guide\GuideProject();
            $prj = $GuideProjec->getId();

            switch($d1)
                {
                    case 'edit_F':
                        $sx .= $this->edit('F', $prj);
                        break;
                    case 'edit_H':
                        $sx .= $this->edit('H',$prj);
                        break;
                    default:
                        $sx .= $this->menu();
                        break;
                }
            return $sx;
        }

    function menu()
        {
            $menu = array();
            $menu['#ADMIN'] = lang('guide.headers');
            $menu[PATH.'/admin/headers/edit_H/'] = lang('guide.edit').' '.lang('guide.edit_H');
            $menu[PATH . '/admin/headers/edit_F/'] = lang('guide.edit') . ' ' . lang('guide.edit_F');
            return menu($menu);
        }

    function edit($type,$prj)
        {
            $sx = '';
            $dt = $this->where('hd_project',$prj)->where('hd_type', $type)->first();

            $act = get("action");
            if ($act != '')
                {
                    $dta = $_POST;
                    $this->set($dta)->where('id_hd',$dt['id_hd'])->update();
                    $sx = metarefresh(PATH.'/admin/headers/');
                    return $sx;
                }

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

            $sx .= form_open();
            $sx .= form_hidden('id_hd',$dt['id_hd']);
            $sx .= '<label>'.h(lang('guide.config_'.$type),3).'</label>';
            $sx .= form_textarea(array('name' => 'hd_code', 'value' => $dt['hd_code'], 'class' => 'form-control', 'style'=>'width:100%;"'));
            $sx .= form_submit(array('name'=>'action','value'=>lang('guide.save'),'class'=>'btn btn-outline-primary'));
            $sx .= form_close();

            $sx = bs(bsc($sx,12));
            return $sx;
        }
}
