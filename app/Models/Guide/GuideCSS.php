<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideCSS extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide_style';
    protected $primaryKey       = 'id_css';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_css', 'css_project', 'css_class',
        'css_code', 'updated_at'
    ];

    protected $typeFields    = [
        'hidden', 'hidden', 'string',
        'text', 'now'
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
    var $path = PATH . '/admin/style/';
    var $path_back = PATH . '/admin/style/';

    function index($d1, $d2, $d3)
    {
        $sx = '';
        $GuideProject = new \App\Models\Guide\GuideProject();
        $prj = $GuideProject->getId();

        switch ($d1) {
            case 'edit':
                $this->id = $d2;
                $this->path = PATH . '/admin/style/';
                $this->path_back = PATH . '/admin/style/';
                $sx = form($this);
                break;
            case 'check':
                $sx .= $this->check($prj);
                break;
            default:
                $sx .= bsc(h('Style'), 11);
                $sx .= bsc('<a href="' . PATH . '/admin/style/check' . '">' . bsicone('checkit') . '</a>', 1);

                $sx .= bsc($this->list($prj), 12);
        }
        $sx = bs($sx);
        return $sx;
    }

    function style($prj)
    {
        $dt = $this
            ->where('css_project', $prj)
            ->orderBy('css_class')
            ->findAll();

        $sx = '<style>';
        for ($r = 0; $r < count($dt); $r++) {
            $line = $dt[$r];
            $sx .= cr();
            $sx .= $line['css_class'].cr();
            $sx .= '{ '. $line['css_code'].' } '.cr();
        }
        $sx .= '</style>';
        return $sx;
    }

    function list($prj)
    {
        $sx = '';

        $dt = $this
            ->where('css_project', $prj)
            ->orderBy('css_class')
            ->findAll();

        $sx .= '<table class="table" width="100%">';
        for ($r = 0; $r < count($dt); $r++) {
            $line = $dt[$r];
            $link = '<a href="' . PATH . '/admin/style/edit/' . $line['id_css'] . '">' . bsicone('edit') . '</a>';
            $sx .= '<tr>';
            $sx .= '<td width="25%">' . $line['css_class'] . $link . '</td>';
            $sx .= '<td width="55%"><pre>' . $line['css_code'] . '</pre></td>';
            $sx .= '<td><div style="' . $line['css_code'] . '">Sample</div></td>';
            $sx .= '</tr>';
        }
        $sx .= '</table>';
        return $sx;
    }

    function register($prj, $class, $content)
    {
        $sx = '';
        $dt = $this
            ->where('css_project', $prj)
            ->where('css_class', $class)
            ->findAll();
        if (count($dt) == 0) {
            $dt['css_project'] = $prj;
            $dt['css_class'] = $class;
            $dt['css_code'] = $content;
            $this->set($dt)->insert();
            $sx .= ' inserted';
        } else {
            if ($content != '') {
                $dt['css_project'] = $prj;
                $dt['css_class'] = $class;
                $dt['css_code'] = $content;

                $this
                    ->set($dt)
                    ->where('css_project', $prj)
                    ->where('css_class', $class)
                    ->update();
                $sx .= ' updade';
            } else {
                $sx .= ' bypass';
            }
        }
        return $sx;
    }

    function check($prj = '')
    {
        $sx = '';
        $st = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p','code');
        $sx .= 'Check:<ul>';
        for ($r = 0; $r < count($st); $r++) {
            $rst = '<b>' . $this->register($prj, $st[$r], '') . '</b>';
            $sx .= '<li>' . $st[$r] . ' ' . $rst . '</li>';
        }
        $sx .= '</ul>';
        $sx .= '<br>End Check';
        return $sx;
    }
}
