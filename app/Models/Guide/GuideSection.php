<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideSection extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide_section';
    protected $primaryKey       = 'id_sc';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_sc', 'sc_name', 'sc_seq', 'sc_path', 'sc_father'
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

    function index($d1)
    {
        $this->store();

        $dt['data'] = $this
            ->select('guide_section.id_sc as id_sc, guide_section.sc_name as sc_name,
                        guide_section.sc_seq as sc_seq, guide_section.sc_path as sc_path,
                        guide_section.sc_father as sc_father,
                        gs.sc_path as sc_father_name')
            ->join('guide_section as gs', 'guide_section.sc_father = gs.id_sc', 'left')
            ->findAll();
        $sx = view('Guide/sections_list', $dt);
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
                'sc_name' => ['label' => 'Section name', 'rules' => 'required|min_length[3]'],
                'sc_seq' => ['label' => 'Seq', 'rules' => 'required|numeric|max_length[5]'],
                'sc_path' => ['label' => 'Path Guide', 'rules' => 'required|min_length[3]']
            ];
            //$validation->setRule('sc_name', 'Username', 'required|min_length[3]');
            $validation->setRules($rules);

            if ($validation->withRequest($request)->run()) {
                $data = [
                    'sc_name' => $request->getVar('sc_name'),
                    'sc_seq'  => $request->getVar('sc_seq'),
                    'sc_path'  => $request->getVar('sc_path'),
                    'sc_father'  => $request->getVar('sc_father')
                ];
                $id_sc = $request->getVar('id_sc');
                if ($id_sc == 0) {
                    $this->save($data);
                } else {
                    $this->set($data)->where('id_sc', $id_sc)->update();
                }

                header("location: sections");
                exit;
            } else {
                $data['ERROS'] = $validation->getErrors();
                $data['validation'] = $this->validator;
                return view('Guide/sections_edit', $data);
            }
        }
    }

    function view($id)
    {
        $sx = '';
        $request = \Config\Services::request();
        $id = $request->getVar('id');
        if ($id > 0) {
            $dt = $this
            ->join('guide_section as gs', 'gs.id_sc = guide_section.sc_father', 'left')
            ->find($id);
            $sx .= view('Guide/section', $dt);

            /**************************** Content */
            $Content = new \App\Models\Guide\GuideContent();

            $sx .= '<div class="container"><div class="row">';
            $sx .= $Content->show($id);
            $sx .= $Content->btn_new($id);
            $sx .= '</div></div>';
        } else {
            $sx .= 'Error';
        }
        return $sx;
    }

    function confirm_delete()
    {
        $sx = '';
        $request = \Config\Services::request();
        $id = $request->getVar('id');
        $confirm = $request->getVar('confirm');

        if ($id > 0) {
            $dt = $this->find($id);
            $sx .= view('Guide/section', $dt);

            if ($confirm == 'YES') {
                $this->delete($id);
                header("location: sections");
                exit;
            }

            $sx .= '<div class="container">';
            $sx .= '<div class="row">';
            $sx .= '<div class="col-md-12">';
            $sx .= '<a href="sections_delete?id=' . $id . '&confirm=YES" class="btn btn-danger">Confirm delete</a>';
            $sx .= '</div>';
            $sx .= '</div>';
            $sx .= '</div>';
        }
        return $sx;
    }

    function edit($d1 = 0)
    {
        $validation = \Config\Services::validation();
        $data = array();
        $data['validation'] = array();
        $data['sc_seq'] = '';
        $data['sc_name'] = '';
        $data['sc_path'] = '';
        $data['id_sc'] = 0;
        $data['sc_father'] = '';

        if ($d1 > 0) {
            $data = $this->find($d1);
        }

        $this->store();

        return view('Guide/sections_edit', $data);

        $dt['data'] = $this->find(round('0' . $d1));
        $sx = view('Guide/sections_edit', $dt);
        return $sx;
    }
}
