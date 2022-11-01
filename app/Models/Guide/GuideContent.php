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
        'id_ct', 'ct_title', 'ct_type', 'ct_description',
        'ct_section', 'ct_seq'
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

    function ajax($d1 = '', $d2 = '', $d3 = '')
    {
        switch ($d1) {
            case 'save':
                $this->ajax_save($d1,$d2,$d3);
                exit;
            case 'ajax_block_delete':
                $this->ajax_delete($d1, $d2, $d3);
                echo "";
                exit;

            case 'ajax_block_view':
                $sx = $this->ajax_block_view($d2, $d3);
                echo $sx;
                exit;
                break;
            case 'view':
                $sx = $this->ajax_view($d2);
                break;
                exit;
            case 'edit':
                echo $this->ajax_edit_block_type($d2, $d3);
                exit;
                break;
            default:
                echo "ERRO AJAX GuideContent: $d1, $d2, $d3";
                exit;
        }
    }

    function ajax_delete($d1, $d2, $d3)
    {
        $this->where('id_ct', $d2);
        $this->delete();
        echo "";
        exit;
    }

    function ajax_save($d1,$d2,$d3)
        {
            $data = array();
            $dt = $this->find($d2);
            switch($dt['ct_type'])
            {
                case 'title':
                    $data['ct_title'] = get('vlr');
                    $data['ct_description'] = '';
                    break;

                case 'text':
                    $data['ct_description'] = get("vlr");
                break;

                case 'image':
                    $data['ct_description'] = get('vlr');
                    break;

                case 'link':
                    $data['ct_title'] = get('vlr');
                    $data['ct_description'] = get('vlr');
                    break;

                case 'video':
                    $data['ct_title'] = get('vlr');
                    $data['ct_description'] = get('vlr2');
                    break;
            }
            $this->set($data)->where('id_ct', $d2)->update();
            echo $this->ajax_block_view($d2);
        }

    function edit_block($id, $type = '')
        {
            $sx = 'X';
            echo "id = $id, type = $type<br/>";
            pre($_POST);

            return $sx;
        }

    function ajax_edit_block_type($d2, $d3)
    {
        $sx = '';
        $dt = $this->find($d2);
        $type = $dt['ct_type'];
        switch ($type) {
            case 'text':
                $sx = $this->ajax_edit_block_type_text($dt, $d3);
                break;
            case 'title':
                $sx = $this->ajax_edit_block_type_title($dt, $d3);
                break;
            case 'link':
                $sx = $this->ajax_edit_block_type_title($dt, $d3);
                break;
            case 'video':
                $sx = $this->ajax_edit_block_type_video($dt, $d3);
                break;
            default:
                $sx .= bsmessage('Tipo de bloco não definido para edição, ver ajax_edit_block_type: '.$type, 3);
        }
        echo $sx;
    }

    function ajax_edit_block_type_title($dt, $d3)
    {
        $sx = '';
        $sx .= '<input type="text" id="ct_title_' . $dt['id_ct'] . '" value="' . $dt['ct_title'] . '" style="width: 100%;">';
        $sx .= '<br>';
        $sx .= '<button type="submit" class="btn btn-outline-primary small"
                    onclick="block_save(' . $dt['id_ct'] . ',\'' . $d3 . '\');">' .
            msg('guide.save') . '</button>';
        $sx .= '<button type="button" class="ms-2 btn btn-outline-danger small" onclick="close_field('.$dt['id_ct'] . ',\'' . $d3 . '\');">' . msg('guide.close') . '</button>';
        $sx .= '<button type="button" class="ms-2 btn btn-danger small" onclick="delete_field(' . $dt['id_ct'] . ',\'' . $d3 . '\');">' . msg('guide.delete') . '</button>';

        return $sx;
    }

    function ajax_edit_block_type_video($dt, $d3)
    {
        $sx = '';
        $sx .= '<span class="small">' . msg('guide.video_link') . '</span>';
        $sx .= '<input type="text" id="ct_title_' . $dt['id_ct'] . '" value="' . $dt['ct_title'] . '" style="width: 100%;">';
        $sx .= '<span class="small">' . msg('guide.video_link_start') . '</span></br>';
        $vlr = round($dt['ct_description']);
        $sx .= '<input type="text" id="ct_description_' . $dt['id_ct'] . '" value="' . $vlr . '" style="width: 20%;"> EX: 66 -> para 1m6s';
        $sx .= '<br>';
        $sx .= '<button type="submit" class="btn btn-outline-primary small"
                    onclick="block_save(' . $dt['id_ct'] . ',\'' . $d3 . '\');">' .
        msg('save') . '</button>';
        $sx .= '<button type="button" class="ms-2 btn btn-outline-danger small" onclick="close_field(' . $dt['id_ct'] . ',\'' . $d3 . '\');">' . msg('guide.close') . '</button>';
        $sx .= '<button type="button" class="ms-2 btn btn-danger small" onclick="delete_field(' . $dt['id_ct'] . ',\'' . $d3 . '\');">' . msg('guide.delete') . '</button>';
        return $sx;
    }

    function ajax_edit_block_type_text($dt, $d3)
    {
        $sx = '';
        $sx .=
        '<textarea rows="10"  id="ct_title_' . $dt['id_ct'] . '" style="width: 100%;">';
        $sx .= $dt['ct_description'];
        $sx .= '</textarea>';
        $sx .= '<button type="submit" class="btn btn-outline-primary small"
                    onclick="block_save(' . $dt['id_ct'] . ',\'' . $d3 . '\');">' .
        msg('save') . '</button>';
        $sx .= '<button type="button" class="ms-2 btn btn-outline-danger small" onclick="close_field(' . $dt['id_ct'] . ',\'' . $d3 . '\');">' . msg('close') . '</button>';
        $sx .= '<button type="button" class="ms-2 btn btn-danger small" onclick="delete_field(' . $dt['id_ct'] . ',\'' . $d3 . '\');">' . msg('guide.delete') . '</button>';
        return $sx;
    }

    function ajax_block_view($id)
        {
            $sx = '';
            $dt = $this->find($id);
            $type = $dt['ct_type'];
            switch($type)
                {
                    case 'title':
                        $sx = $this->show_title($dt);
                        break;
                    case 'link':
                        $sx = $this->show_link($dt);
                        break;
                    case 'text':
                        $sx = $this->show_txt($dt);
                        break;
                    case 'video':
                        $sx = $this->show_video($dt);
                        break;
                    default:
                        $sx = bsmessage('Tipo de bloco não definido para visualização, ver ajax_block_view: '.$type,3);
                }
            return $sx;
        }

    function show_title($dt)
    {
        $sx = '';
        $ed = '<span style="cursor: pointer;" onclick="block_edit(' . $dt['id_ct'] . ',\'block_' . $dt['id_ct'] . '\');">';
        $ed .= bsicone('edit');
        $ed .= ' </span>';
        $sx .= '<h4>' .$ed . $dt['ct_title'] . '</h4>';
        return $sx;
    }

    function show_txt($dt)
    {
        $sx = '';
        $ed = '<span style="cursor: pointer;" onclick="block_edit(' . $dt['id_ct'] . ',\'block_' . $dt['id_ct'] . '\');">';
        $ed .= bsicone('edit');
        $ed .= ' </span>';
        $sx .= $ed. troca($dt['ct_description'],chr(10),'<br>');
        return $sx;
    }

    function show_link($dt)
    {
        $sx = '';
        $ed = '<span style="cursor: pointer;" onclick="block_edit(' . $dt['id_ct'] . ',\'block_' . $dt['id_ct'] . '\');">';
        $ed .= bsicone('edit');
        $ed .= ' </span>';
        $sx .= $ed . '<a href="'. $dt['ct_title'].'" target="_blank">' .  $dt['ct_title'] . '</a>';
        return $sx;
    }

    function show_video($dt)
    {
        $url = 'https://www.youtube.com/embed/7LNBd_7KmD4';
        $url = $dt['ct_title'];
        if (substr($url, 0, 4) != 'http') {
            $url = 'https://www.youtube.com/embed/7LNBd_7KmD4';
        }
        $url = troca($url, '/watch?v=', '/embed/');
        if (strpos($url, '&t=') > 0) {
            $url = substr($url, 0, strpos($url, '&t='));
        }
        $start = round($dt['ct_description']);
        //$sizeX = 560;
        $sizeX = 280;
        $sizeY = round($sizeX*0.5925);
        $sx = '';
        $ed = '<span style="cursor: pointer;" onclick="block_edit(' . $dt['id_ct'] . ',\'block_' . $dt['id_ct'] . '\');">';
        $ed .= bsicone('edit');
        $ed .= ' </span>';
        $sx .= $ed . '<br><iframe width="'.$sizeX.'" height="'.$sizeY.'" src="'.$url.'?start='.$start.'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
        return $sx;
    }

    function show($id,$block_view = true)
    {
        $sx = '';
        $dt = $this->where('ct_section', $id)->findAll();
        for ($r = 0; $r < count($dt); $r++) {
            $line = $dt[$r];
            $sx .= '<div id="block_' . $dt[$r]['id_ct'] . '" class="mt-2 mb-2 pb-2" style="border-bottom: 1px solid #888">';
            switch ($line['ct_type']) {
                case 'link':
                    $sx .= $this->show_link($line);
                    break;
                case 'text':
                    $sx .= $this->show_txt($line);
                    break;
                case 'title':
                    $sx .= $this->show_title($line);
                    break;
                case 'video':
                    $sx .= $this->show_video($line);
                    break;
                default:
                    $sx .= $line['ct_type'];
                    break;
            }
            $sx .= '</div>';
        }
        return ($sx);
    }
}
