<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideContent extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide_content';
    protected $primaryKey       = 'id_ct';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_ct', 'ct_title', 'ct_description',
        'ct_section','ct_seq'
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

    function show($id)
        {
            $sx = '';
            $dt = $this->where('ct_section',$id)->findAll();
            for ($r=0;$r < count($dt);$r++)
                {
                    $sx .= '<div class="col-11">';
                    $sx .= '<h3>'.$dt[$r]['ct_title'].'</h3>';
                    $sx .= '<p>'.$dt[$r]['ct_description'].'</p>';
                    $sx .= '</div>';

                    $url = PATH . '/index/guide/content_edit/?id='.$dt[$r]['id_ct'];
                    $sx .= '<div class="col-1">';
                    $sx .= '<span class="btn btn-outline-secondary" onclick="newwin(\'' . $url . '\');">';
                    $sx .= '[ED]';
                    $sx .= '</span>';
                    $sx .= '</div>';
                }
            return($sx);
        }

    function btn_new($id)
    {
        $url = PATH.'/index/guide/content_edit/'.$id.'?id=0';
        $sx = '';

        $sx .= '<div class="col-12">';
        $sx .= '<span class="btn btn-outline-secondary" onclick="newwin(\''.$url.'\');">';
        $sx .= '[novo texto]';
        $sx .= '</span>';
        $sx .= '</div>';

        return $sx;
    }

    function store()
    {
        $request = \Config\Services::request();
        $validation =  \Config\Services::validation();
        $data = array();

        if ($request->getMethod() == "post") {
            $data = $request->getPost();

            /********************************* RULES */
            $rules = [
                'ct_title' => ['label' => 'Title', 'rules' => 'required|min_length[3]'],
                'ct_description' => ['label' => 'Content', 'rules' => 'required|min_length[3]'],
                'ct_section' => ['label' => 'Section', 'rules' => 'required|numeric|max_length[5]'],
                'ct_seq' => ['label' => 'Section', 'rules' => 'required|numeric|max_length[5]']
            ];
            //$validation->setRule('sc_name', 'Username', 'required|min_length[3]');
            $validation->setRules($rules);

            if ($validation->withRequest($request)->run()) {
                $data = [
                    'ct_title' => $request->getVar('ct_title'),
                    'ct_description'  => $request->getVar('ct_description'),
                    'ct_section'  => $request->getVar('ct_section'),
                    'ct_seq'  => $request->getVar('ct_seq')
                ];

                $id_ct = $request->getVar('id_ct');
                if ($id_ct == 0) {
                    $this->save($data);
                } else {
                    $this->set($data)->where('id_ct', $id_ct)->update();
                }

                echo '<script>wclose9);</script>';
                exit;
            } else {
                $data['id_ct'] = $request->getVar('id_ct');
                $data['ERROS'] = $validation->getErrors();
                $data['validation'] = $this->validator;
                print_r($data);
                return view('Guide/content_textarea_edit', $data);
            }
        }
    }

    function edit($d1 = 0)
    {
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();

        $id = $request->getVar('id');

        $data = array();
        $data['validation'] = array();
        $data['id_ct'] = $id;
        $data['ct_title'] = '';
        $data['ct_description'] = '';
        $data['ct_section'] = $d1;
        $data['ct_seq'] = 0;

        if ($id > 0) {
            $data = $this->find($d1);
        }

        $this->store();

        return view('Guide/content_textarea_edit', $data);

        $dt['data'] = $this->find(round('0' . $d1));
        $sx = view('Guide/content_edit', $dt);
        return $sx;
    }
}
