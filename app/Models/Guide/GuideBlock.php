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
        'ct_description', 'ct_section', 'ct_seq',
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
            switch($d1)
                {
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

            $dt = $this
                ->select('max(ct_seq) as seq')
                ->where('ct_section', $sec)
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
            $dt['ct_description'] = $type;
            $dt['ct_section'] = $sec;
            $dt['ct_seq'] = $seq;
            $dt['updated_at'] = date("Y-m-d H:i:s");
            $this->set($dt)->insert();
            echo '<script>wclose();</script>';
            exit;
        }


    function block_new($sec, $ord = 0)
    {
        $type = get('type');
        if ($type != '')
            {
                return $this->register_block($sec,$type);
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
            $sx .= '<td width="10%" align="center">';
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

        echo $GuideContent->edit_block($idb);
        exit;
    }
}
