<?php

namespace App\Models\Guide;

use CodeIgniter\Model;

class GuideBlock extends Model
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
        'id_ct', 'ct_type', 'ct_title',
        'ct_description', 'ct_section', 'ct_seq','ct_project',
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
            $sx = ''.$d1;
            switch($d1)
                {
                    case 'edit':
                        $sx = $this->edit($d1,$d2,$d3);
                        break;
                    case 'new':
                        $sx .= h(lang('guide.block_select_type'),4);
                        $sx .= $this->block_new($d2,0);
                    break;
                    default:
                        echo "Block";
                        break;
                }
            return $sx;
        }

    function edit($d1,$d2,$d3)
        {
            $sx = '';
            $dt = $this->find($d2);
            $type = $dt['ct_type'];

            switch($type)
                {
                    case 'image':
                        $sx = $this->edit_type_image($dt);
                        break;
                    case 'text':
                        $sx = $this->edit_type_text($dt);
                        break;
                    case 'title':
                        $sx = $this->edit_type_title($dt);
                        break;
                    case 'link':
                        $sx = $this->edit_type_link($dt);
                        break;
                    default:
                        $sx .= "OPS $type";
                }
            return $sx;
        }

    function edit_type_image($dt)
        {
            $GuideMedia = new \App\Models\Guide\GuideMedia();
            $sx = 'IMAGE';
            $rsp = $GuideMedia->upload($dt);
            if ($rsp == sonumero($rsp))
                {
                    $dr['ct_description'] = $rsp;
                     $this->set($dr)->where('id_ct', $dt['id_ct'])->update();
                     $sx .= wclose();
                } else {
                    $sx .= $rsp;
                }
            return $sx;
        }

    function edit_type_link($dt)
    {
        if (get('action') != '') {
            $dr = $_POST;
            $this->set($dr)->where('id_ct', $dt['id_ct'])->update();
            return wclose();
        }
        $sx = form_open();
        $sx .= form_hidden(array('id_ct' => $dt['id_ct']));
        $sx .= '<label>'.lang('guide.link_name').'</label>';
        $sx .= form_input(array('name' => 'ct_title', 'value' => $dt['ct_title'], 'style' => 'width: 100%;'));
        $sx .= '<label>' . lang('guide.link_url') . '</label>';
        $sx .= form_input(array('name' => 'ct_description', 'value' => $dt['ct_description'], 'style' => 'width: 100%;'));
        $sx .= form_submit(array('name' => 'action', 'value' => lang('guide.save'), 'class' => 'btn btn-outline-primary'));
        $sx .= form_close();

        return $sx;
    }

    function edit_type_title($dt)
    {
        if (get('action') != '') {
            $dr = $_POST;
            $this->set($dr)->where('id_ct', $dt['id_ct'])->update();
            return wclose();
        }
        $options = [
            'H1'  => 'h1',
            'H2'    => 'h2',
            'H3'  => 'h3',
            'H4' => 'h4',
        ];
        $order = $this->order();
        $sx = form_open();
        $sx .= form_hidden(array('id_ct' => $dt['id_ct'], 'ct_description'=>''));
        $sx .= '<label>' . lang('guide.title') . '</label>';
        $sx .= form_input(array('name' => 'ct_title', 'value' => $dt['ct_title'], 'style' => 'width: 100%;'));
        $sx .= '<label>' . lang('guide.title_header') . '</label>';
        $sx .= form_dropdown('ct_description', $options, 'large');
        $sx .= form_dropdown('ct_seq', $order, 'large');
        $sx .= form_submit(array('name' => 'action', 'value' => lang('guide.save'), 'class' => 'btn btn-outline-primary'));
        $sx .= form_close();

        return $sx;
    }

    function order()
        {
            $o = array();
            for ($r=1;$r < 200;$r++)
                {
                    $o[$r] = $r;
                }
            return $o;
        }

    function edit_type_text($dt)
        {
            if (get('action') != '')
                {
                    $dr = $_POST;
                    $this->set($dr)->where('id_ct',$dt['id_ct'])->update();
                    $GuideVariables = new \App\Models\Guide\GuideVariables();
                    $GuideVariables->detect($dt['ct_project'],$dt['ct_description']);
                    return wclose();
                }
            $sx = form_open();
            $sx .= form_hidden(array('id_ct'=>$dt['id_ct']));
            $sx .= form_textarea(array('name'=>'ct_description','value'=>$dt['ct_description'],'rows'=>10,'style'=>'width: 100%;'));
            $sx .= form_submit(array('name'=>'action','value'=>lang('guide.save'),'class'=>'btn btn-outline-primary'));
            $sx .= form_close();
            return $sx;
        }

    function viewid($id,$edit=1)
        {
            $GuideProject = new \App\Models\Guide\GuideProject();
            $prj = $GuideProject->getId();

            $sx = '';
            $GuideStyle = new \App\Models\Guide\GuideCSS();
            $sx .= $GuideStyle->style($prj);
            $dt = $this
                ->where('ct_section',$id)
                ->orderBY('ct_seq')
                ->FindAll();
            for ($r=0;$r < count($dt);$r++)
                {
                    $sx .= $this->view_type($dt[$r],$edit);
                }
            $sx = bs($sx);
            return $sx;
        }

    function view_type($dt,$edit=1)
        {
            $sx = '';
            $se = '';
            $bs = 12;
            $type = $dt['ct_type'];
            if ($edit == 1)
                {
                    $link = '<a href="#" onclick="newwin(\''.PATH.'/admin/block/edit/'.$dt['id_ct'].'\',800,500);">'.bsicone('edit').'</a> ';
                    $se = bsc($link. $type, 1);
                    $bs = 11;
                }
            $sx .= $se;
            switch($type)
                {
                    case 'image':
                        $idm = $dt['ct_description'];
                        $GuideMedia = new \App\Models\Guide\GuideMedia();
                        $img = $GuideMedia->show($idm);
                        $sv = '<img src="'.$img.'" class="img-fluid">';
                        $sx .= bsc(
                            $sv,
                            $bs
                        );
                        break;
                    case 'video':
                        $sv = '<iframe width="560" height="315" src="https://www.youtube.com/embed/7LNBd_7KmD4?start='.$dt['ct_start'].'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                    $sx .= bsc(
                        $sv,
                        $bs
                    );
                break;

                    case 'title':
                        $h = sonumero($dt['ct_description']);
                        if ($h == '') { $h = '1'; }
                        $sx .= bsc(
                        h($dt['ct_title'], $h),
                        $bs
                        );
                        break;
                    case 'link':
                        $sx .= bsc(
                            '<a href="'. $dt['ct_description'].'" target="_blank">'.$dt['ct_title'].'</a>',
                            $bs
                        );
                        break;
                    case 'text':
                        $sx .= bsc(
                            '<p>'.troca($dt['ct_description'],chr(13),'<br>'). '</p>',
                            $bs
                        );
                        break;
                    default:
                        $sx .= bsc(
                                h($dt['ct_title'],4).
                                $dt['ct_description']
                                ,$bs);
                        break;
                }
            return $sx;

        }

    function btn_block_new($section=0)
        {
            $sx = '<a href="#" onclick="newwin(\''.PATH.'/admin/block/new/'.$section.'\',800,400);" class="btn btn-outline-primary">';
            $sx .= lang('guide.block_new');
            $sx .= '</a>';
            return $sx;
        }

    function type()
    {
        $tp = array(
            'title' => 'header',
            'text' => 'text',
            //'code'=>'code',
            'image' => 'img',
            //'table'=>'table',
            //'list'=>'list',
            'link' => 'url',
            'video' => 'video',
            //'audio'=>'audio',
            //'file'=>'file'
        );
        return $tp;
    }

    function register_block($sec,$type)
        {
            $GuideProjec = new \App\Models\Guide\GuideProject();
            $prj = $GuideProjec->getId();

            if ($prj == 0) { $GuideProjec->erro(1); }

            $dt = $this
                ->select('max(ct_seq) as seq')
                ->where('ct_section', $sec)
                ->where('ct_project', $prj)
                ->groupBy('ct_section')
                ->first();
            if ($dt == '')
                {
                    $seq = 1;
                } else {
                    $seq = $dt['seq'] + 1;
                }

            $dt['ct_type'] = $type;
            $dt['ct_title'] = $type;
            $dt['ct_project'] = $prj;
            $dt['ct_description'] = $type;
            $dt['ct_section'] = $sec;
            $dt['ct_seq'] = $seq;
            $dt['updated_at'] = date("Y-m-d H:i:s");
            $id = $this->set($dt)->insert();
            return $id;
        }


    function block_new($sec, $ord = 0)
    {
        $type = get('type');
        if ($type != '')
            {
                $idc = $this->register_block($sec,$type);
                $sx = metarefresh(PATH.'/admin/block/edit/'.$idc);
                return $sx;
            }
        $sx = '';
        $types = $this->type();
        $sx = '<table width="100%" class="table">';
        $col = 99;
        $maxcol = 5;
        foreach ($types as $type => $name) {
            $link = '<a class="p-4 rounded card"
                        href="'.PATH. '/admin/block/new/'.$sec.'?type='.$type.'">';
            $linka = '</a>';
            if ($col >= $maxcol) {
                if ($col <> 99) {
                    $sx .= '</tr>';
                }
                $sx .= '<tr>';
                $col = 0;
            }
            $sx .= '<td width="10%" align="center" title="'.$name.'">';
            $sx .= $link;
            $sx .= bsicone($name, 64);
            $sx .= '</br>';
            $sx .= '<span class="small">';
            $sx .= lang('guide.block_type_' . $type);
            $sx .= '</span>';
            $sx .= $linka;
            $sx .= '</td>';
            $col++;
        }
        if (($col > 1) and ($col <> 99)) {
            $sx .= '</tr>';
        }
        $sx .= '</table>';
        return $sx;
    }

    function ajax_block_new_type($sec, $ord, $type)
    {
        $type = get("type");
        $GuideContent = new \App\Models\Guide\GuideContent();
        $content = '';
        $data['ct_title'] = lang('guide.add_content_' . $type);
        /* Se LINK */
        if ($type == 'link') {
            $data['ct_title'] = 'https://:::';
        }
        $data['ct_type'] = $type;
        $data['ct_description'] = '';
        /* Se Texto */
        if ($type == 'text') {
            $data['ct_description'] = $data['ct_title'];
        }

        /* Se Video */
        if ($type == 'video') {
            $data['ct_title'] = 'https://www.youtube.com/embed/7LNBd_7KmD4';
            $data['ct_description'] = 0;
        }
        $data['ct_section'] = $sec;
        $data['ct_seq'] = ($sec + 1);
        $data['updated_at'] = date("Y-m-d H:i:s");
        $idb = $GuideContent->set($data)->insert();

        return $idb;
    }
}
