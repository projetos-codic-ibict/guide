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
        'id_sc', 'sc_name', 'sc_seq', 'sc_path', 'sc_father', 'sc_project', 'updated_at'
    ];
    protected $typeFields    = [
        'hidden', 'string', '[1-99]]', 'string', 'hidden', 'hidden', 'now'
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
    var $id = 0;
    var $path = PATH. '/admin/section/';
    var $path_back = PATH . '/admin/section/';


    function index($d1 = '', $d2 = '', $d3 = '', $d4 = '')
    {
        $GuideProject = new \App\Models\Guide\GuideProject();
        $prj = $GuideProject->getProject();
        $sx = '';
        switch ($d1) {
            case 'viewid':
                $sx .= $this->viewid($d2);
                break;
            case 'edit':
                $this->id = $d2;
                $dt = $GuideProject->find($prj);
                $sx .= $GuideProject->header($dt);
                $sx .= bsc(form($this),12);
                return bs($sx);
            default:
                if ($prj != '') {
                    $dt = $GuideProject->le($prj);
                    $sx .= $GuideProject->header($dt);
                    $sx .= h(lang('guide.section'),4);
                    $sx .= $this->list($d1);
                    $sx .= bsc($this->btn_new_section($prj),12);
                }
                break;
        }
        return bs($sx);
    }

    function list($d1, $d2 = '', $d3 = '', $d4 = '')
    {
        $dt['data'] = $this
            ->select('guide_section.id_sc as id_sc, guide_section.sc_name as sc_name,
                        guide_section.sc_seq as sc_seq, guide_section.sc_path as sc_path,
                        guide_section.sc_father as sc_father,
                        gs.sc_path as sc_father_name')
            ->join('guide_section as gs', 'guide_section.sc_father = gs.id_sc', 'left')
            ->findAll();
        $sx = bs(view('Guide/sections_list', $dt));
        return $sx;
    }

    function viewid($id)
        {
            $GuideProject = new \App\Models\Guide\GuideProject();
            $sx = '';
            $prj = $GuideProject->getProject();
            $dt = $GuideProject->le($prj);
            $sx .= $GuideProject->header($dt);

            $sx .= $this->summary($id);

            $sx .= $this->sections($id);

            return $sx;
        }

    function sections($id)
        {
            $GuideBlock = new \App\Models\Guide\GuideBlock();
            $sx = '';
            $sx .= bsc($GuideBlock->btn_block_new($id),12);
            $sx = bs($sx);
            return $sx;
        }

    function ajax($d1, $d2, $d3, $d4)
    {
        $sx = '';
        echo "$d1 - $d2 - $d3 - $d4";
        switch ($d1) {
            case 'ajax_block_edit_type':
                echo $this->ajax_block_new_type($d2, $d3, $d4);
                exit;
                break;
            case 'ajax_block_edit':
                echo $this->ajax_block_new($d2, $d3, $d4);
                exit;
                break;
            case 'ajax_viewid':
                $sx .= $this->ajax_viewid($d2);
                break;
            case 'save':
                $data = array();
                $id = get("id");
                $data['sc_project'] = get("prj");
                $data['sc_name'] = get("title");
                $data['sc_path'] = get("path");
                $data['sc_seq'] = get("ord");
                $data['sc_father'] = get("father");
                if ($id == 0) {
                    $this->set($data)->insert();
                }
                break;
            default:
                $sx = 'Ajax SECTION not found';
                pre($_POST, false);
                $sx .= "<pre>
                        d1 = $d1
                        d2 = $d2
                        d3 = $d3
                        d4 = $d4
                        </pre>";
                break;
        }
        echo $sx;
        exit;;
    }



    function block_new($sec, $ord = 0)
    {
        $sx = '';
        $sx .= '<button
                        id="btn_new_block"
                        class="btn btn-outline-primary supersmall"
                        onclick="new_section(' . $sec . ',' . $ord . ')">';
        $sx .= msg('guide.new_block');
        $sx .= '</button>';
        $sx .= '<div id="block_edit"></div>';
        return $sx;
    }

    function ajax_viewid($d2)
    {
        $GuideContent = new \App\Models\Guide\GuideContent();

        $sx = '';
        $dt = $this->find($d2);

        $sx .= h($dt['sc_name'], 2);
        $sx .= h($dt['sc_path'], 4);

        $sx .= $GuideContent->show($dt['id_sc']);

        $sx .= $this->block_new($dt['id_sc'], $dt['sc_seq']);

        return $sx;
    }

    function btn_new_section($id)
    {
        $sx = '';
        $sx .= '<a href="'.PATH.'/admin/section/edit/0" class="btn btn-outline-primary">'.
            lang('guide.section_new').
            '</a>';
        return $sx;
    }

    function form_section($id)
    {
        $sx = '';
        $sx .= form_input(array('name' => 'sc_name', 'id' => 'sc_name', 'class' => 'form-control'), set_value('sc_name'));
        $sx .= '<button type="submit" class="btn btn-primary">' . msg('save') . '</button>';
        return $sx;
    }

    function summary($id)
    {
        $sx = '<div id="summary">';
        $dt = $this->where('sc_project', $id)->orderBy('sc_seq', 'ASC')->findAll();
        if (count($dt) == 0) {
            $sx .= bsmessage(msg('guide.no_sections'), 3) . cr();
        } else {
            $sx .= '<ul>' . cr();
            for ($r = 0; $r < count($dt); $r++) {
                $line = $dt[$r];
                $link = '<a href="' . PATH . '/admin/section/' . $line['id_sc'] . '">';
                $linka = '</a>' . cr();
                $sx .= '<li>' . $link . $line['sc_name'] . '</li>' . cr();
            }
            $sx .= '</ul>' . cr();
        }
        $sx .= '</div>' . cr();
        return $sx;
    }

    function edit($d1 = 0, $father = 0)
    {
        $GuideProject = new \App\Models\Guide\GuideProject();

        $prj = $GuideProject->getId();

        $data = array();
        $data['sc_project'] = $prj;
        $data['sc_name'] = '';
        $data['sc_order'] = 1;
        $data['sc_path'] = '/';
        $data['id_sc'] = 0;

        return view('Guide/sections_edit', $data);

        $dt['data'] = $this->find(round('0' . $d1));
        $sx = view('Guide/sections_edit', $dt);
        return $sx;
    }
}
