<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Prj_master extends Model
{
    protected $table      = 'custome__masterdata';
    protected $primaryKey = 'id_masterdata';
    protected $allowedFields = [
        'nama_master', 'jns_master', 'sts_master', 'slug_master', 'image_master'
    ];

    //jns_master: 1=cara_peroleh_informasi 2=pekerjaan, 3=cara_mendapatkan_info

    //backend
    public function list1()
    {
        return $this->table('custome__masterdata')
            // ->orderBy('id_masterdata', 'DESC')
            ->where('jns_master', '1')
            ->get()->getResultArray();
    }

    public function list2()
    {
        return $this->table('custome__masterdata')
            // ->orderBy('id_masterdata', 'DESC')
            ->where('jns_master', '2')
            ->get()->getResultArray();
    }

    public function list3()
    {
        return $this->table('custome__masterdata')
            // ->orderBy('id_masterdata', 'DESC')
            ->where('jns_master', '3')
            ->get()->getResultArray();
    }


    public function getaktif()
    {
        return $this->table('custome__masterdata')
            ->like('status', '1')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('custome__masterdata')
            ->where('status', 0)
            ->get()->getResultArray();
    }
}
