<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideProject extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'guide_project';
    protected $primaryKey       = 'id_pj';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_pj', 'pj_name', 'pj_path',
        'pj_desc', 'updated_at'
    ];
    protected $typeFields    = [
        'hidden', 'string', 'string',
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

    function index($d1,$d2,$d3)
        {
            $this->path = PATH . MODULE . '/index/guide/project/';
            $this->path_back = PATH . MODULE . '/index/guide/project/';
            $sx = '';
            switch($d2)
                {
                    case 'selected':
                        $sx .= $this->selected($d3);
                        $sx .= $this->viewid($d3);
                        break;
                    case 'viewid':
                        $sx .= $this->viewid($d3);
                        break;
                    case 'edit':
                        $this->id = $d3;
                        $sx .= form($this);
                        break;
                    default:
                        $sx .= bsc(h(lang('guide.GuideProjects'),3),12);
                        $sx .= $this->projects();
                        $sx .= bsc($this->btn_project_new(),12,'mt-5');
                        break;
                }
                $sx = bs($sx);
            return $sx;
        }

    function le($d3)
        {
            $dt = $this->where('id_pj',$d3)->findAll();
            return $dt[0];
        }

    function header($line)
        {
            $sx = '';
            $sx .= bsc(h($line['pj_name'],4),12);
            $sx .= bsc('<hr style="border: 2px solid #000080;">',12);
            return $sx;
        }

    function getID()
        {
            if (!isset($_SESSION['guide_pj']))
                {
                    echo "Project not found";
                    exit;
                }
            $id = $_SESSION['guide_pj'];
            return $id;
        }

    function viewid($d3)
        {
            $GuideSection = new \App\Models\Guide\GuideSection();

            $dt = $this->le($d3);
            $sa = '';
            $sa .= $GuideSection->summary($d3);
            $sa .= $GuideSection->btn_new_section($d3);

            $sb = '<div id="guide_content">Welcome GuideMaker</div>';

            $sa = bsc($sa,4).cr();
            $sb = bsc($sb,6).cr();
            $sx = $this->header($dt);
            $sx .= bs($sa.$sb);
            return $sx;
        }

    function selected($id)
        {
            $data['guide_project'] = $id;
            $_SESSION['guide_pj'] = $id;
            return "";
        }

    function btn_project_new()
        {
            $sx = '<a href="'. $this->path.'edit/0'.'" class="btn btn-outline-primary">';
            $sx .= lang('guide.new_project');
            $sx .= '</a>';
            return $sx;
        }

    function projects()
        {
            $sx = '';
            $dt = $this->findAll();
            for ($r=0;$r < count($dt);$r++)
            {
                $line = $dt[$r];
                $card = '
                <div class="card" style="width: 18rem; mt-5 me-5">
                <img src="'.URL. '/img/logo/logo_big.png'.'" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">'. $line['pj_name'].'</h5>
                    <p class="card-text">'.$line['pj_desc'].'</p>
                    <a href="'.PATH.'/index/guide/project/selected/'.$line['id_pj'].'" class="btn btn-primary">'.lang('guide.go_project').'</a>
                </div>
                </div>
                ';
                $sx .= bsc($card,4);
            }
            return $sx;
        }

}
