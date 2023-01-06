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
    var $path = PATH .  '/admin/guide/';
    var $path_back = PATH . '/admin/guide/';

    var $id = 0;

    function index($d1,$d2,$d3)
        {
            $sx = '';
            switch($d1)
                {
                    case 'selected':
                        $sx .= $this->selected($d2);
                        break;
                    case 'viewid':
                        $sx .= $this->viewid($d2);
                        break;
                    case 'edit':
                        $this->id = $d2;
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

    function view_guide($id)
        {
            echo "==>".$id;
        }

    function le($d3)
        {
            $dt = $this->where('id_pj',$d3)->findAll();
            if (count($dt) == 0)
                {
                    return array();
                }
            return $dt[0];
        }

    function header($line)
        {
            if (count($line) == 0)
                {
                    session()->remove('guide_pj');
                    return bsmessage("Erro no ID do projeto",3);

                }
            $sx = '';
            $sx .= bsc(h($line['pj_name'],4),8);
            $sx .= bsc('/'.$line['pj_path'], 4, 'text-end');
            $sx .= bsc('<hr style="height: 3px;">',12);
            return $sx;
        }

    function getProject()
        {
            return $this->getID();
        }

    function getID()
        {
            if (!isset($_SESSION['guide_pj']))
                {
                    return 0;
                }
            $id = $_SESSION['guide_pj'];
            return $id;
        }

    function viewid($prj)
        {
            $GuideSection = new \App\Models\Guide\GuideSection();

            $dt = $this->le($prj);
            $sx = $this->header($dt);

            if ($dt == '')
                {
                    return $sx;
                }

            $sa = '';
            $sa .= $GuideSection->summary($prj);
            $sa .= $GuideSection->btn_new_section($prj);

            $sb = '';
            $sa = bsc($sa,4).cr();
            $sb = bsc($sb,6).cr();

            return $sx;
        }

    function selected($id)
        {
            $data['guide_project'] = $id;
            $_SESSION['guide_pj'] = $id;
            $sx = metarefresh(PATH . '/admin/section/');
            $sx .= 'Redirecionando...';
            return $sx;
            //redirect()->to('/admin/project/'.$id);
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
                    <a href="'.PATH.MODULE.'/guide/selected/'.$line['id_pj'].'" class="btn btn-primary">'.lang('guide.go_project').'</a>
                </div>
                </div>
                ';
                $sx .= bsc($card,4);
            }
            return $sx;
        }

}
