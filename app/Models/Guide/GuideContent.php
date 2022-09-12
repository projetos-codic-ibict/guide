<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideContent extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide_content';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_ct', 'ct_title', 'ct_description',
        'ct_section'
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
            $dt = $this->where('ct_section',$id)->findAll();
            print_r($dt);
        }

    function btn_new($id)
    {
        $sx = '';
        $sx .= '<script type="text/javascript" src="//js.nicedit.com/nicEdit-latest.js"></script>';
        $sx .= '<script type="text/javascript">';
        $sx .= 'bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });';
        $sx .= '</script>';
        $sx .= '<div class="col-11">';
        $sx .= '</div>';

        $sx .= '<div class="col-1">';
        $sx .= '<span class="btn btn-outline-secondary">';
        $sx .= '[+]';
        $sx .= '</span>';
        $sx .= '</div>';

        $sx .= form_open();
        $sx .= '<div class="col-12">';
        $sx .= '<small>Sub-titulo (opcional)</small>';
        $sx .= '<input type="text" name="ct_title" class="form-control">';
        $sx .= '<small>Concetúdo</small>';
        $sx .= '<textarea class="form-control" id="editor1" name="editor1" rows="10" cols="80" style=""></textarea>';

        $sx .= '<br/>';
        $sx .= '<input type="submit" class="btn btn-outline-secondary" value="Gravar"/>';
        $sx .= '</div>';
        $sx .= form_close();

        $sx .= $this->tabs();

        $sx .= '<script>';
        $sx .= 'function save_html() {';
        $sx .= ' alert("HELLO - HTML");';
        $sx .= '}';
        $sx .= '</script>';
        return $sx;
    }

    function tabs()
        {
            $sx = '
                <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">HTML</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">CODE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">IMAGE</a>
                </li>
                </ul>';
            return $sx;
        }
}
