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

    function edit_block($id)
        {
            $dt = $this->find($id);
            pre($dt);
        }

    function show($id)
        {
            $sx = '';
            $dt = $this->where('ct_section',$id)->findAll();
            for ($r=0;$r < count($dt);$r++)
                {
                    $ed = '<span onclick="edit();">';
                    $ed .= bsicone('edit');
                    $ed .= '</span>';

                    $sx .= '<h5>'.$dt[$r]['ct_title'].' '.$ed.'</h5>';
                    $sx .= '<p>'.$dt[$r]['ct_description'].'</p>';
                }
            return($sx);
        }
}
