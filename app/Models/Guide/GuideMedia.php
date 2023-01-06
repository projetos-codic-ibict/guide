<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideMedia extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide_midias';
    protected $primaryKey       = 'id_i';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_i', 'i_name', 'i_value',
        'i_contentype', 'i_size', 'i_pj',
        'updated_at'
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
            $GuideProject = new \App\Models\Guide\GuideProject();
            $prj = $GuideProject->getID();
            switch($d1)
                {
                    case 'upload':
                        print_r($_FILES,false);
                        $sx .= '==========================================';
                        $sx .= $this->upload($prj);
                        break;
                    case 'all':
                        $sx .= $this->list($prj);
                }
            return $sx;
        }

    function valid_file($P)
        {
            $type = $P['type'];
            $valid = array('image/jpeg', 'image/png', 'image/gif');
            for($r=0;$r < count($valid);$r++)
                {
                    if ($type == $valid[$r]) return 1;
                }
            return "Erro: $type not valid";
        }

    function directory($prj)
        {
            $dir = 'img/guide/'.strzero($prj,4).'/media/';
            dircheck($dir);
            return $dir;
        }

    function upload($dt)
        {
            $GuideProject = new \App\Models\Guide\GuideProject();
            $prj = $GuideProject->getProject();

            pre($_FILES,false);

            $valid = '';
            if (isset($_FILES['media']['type']))
                {
                    $valid = $this->valid_file($_FILES['media']);
                    if ($valid == 1)
                        {
                            $dir = $this->directory($prj);
                            $filename = $dir.strtolower($_FILES['media']['name']);
                            $filename = troca($filename,' ','_');

                            $dt['i_name'] = $_FILES['media']['name'];
                            $dt['i_size'] = $_FILES['media']['size'];
                            $dt['i_contentype'] = $_FILES['media']['type'];
                            $dt['i_value'] = $filename;
                            $dt['i_pj'] = $prj;
                            $tmp = $_FILES['media']['tmp_name'];

                            move_uploaded_file($tmp, $filename);

                            $id = $this->set($dt)->insert();
                            return $id;
                        }
                }
            if (isset($dt['id_ct']))
                {
                    $sx = form_open_multipart(PATH . '/admin/block/edit/' . $dt['id_ct']);
                } else {
                    $sx = form_open_multipart(PATH . '/admin/media/upload/');
                }

            $sx .= form_upload('media');
            $sx .= form_submit(array(
                        'name'=>'action',
                        'value'=>lang('guide.send_file'),
                        'class'=>'btn btn-outline-primary'
                        ));
            $sx .= form_close();

            if (($valid != '') and ($valid != '1'))
                {
                    $sx .= bsmessage($valid,3);
                }
            return $sx;
        }

    function show($id)
        {
            $id = round($id);
            $dt = $this->find($id);
            if ($dt != '')
            {
                $img = URL.'/'.$dt['i_value'];
            } else {
                $img = "ERRO";
            }
            return $img;
        }
    function list($prj,$ord=0)
        {
            $sx = '';
            $dt = $this->where('i_pj',$prj)->orderBy('i_name')->findAll();
            for ($r=0;$r < count($dt);$r++)
                {
                    $line = $dt[$r];
                    $sx .= bsc('<img src="'.URL.'/'.$line['i_value'].'" alt="'.$line['i_name'].'" class="img-thumbnail">'.
            '<br><span style="font-size: 0.6em;">'.$line['i_name'].'</span>',2,'text-center');
                }
            $sx = bs($sx);
            return $sx;
        }
}
