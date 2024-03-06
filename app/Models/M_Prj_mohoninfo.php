<?php

namespace App\Models;

use CodeIgniter\Model;

class M_Prj_mohoninfo extends Model
{
    protected $table      = 'custome__mohoninfo';
    protected $primaryKey = 'id_mohoninfo';
    protected $allowedFields = [
        'nama_pemohon', 'alamat_pemohon', 'pek_pemohon', 'hp_pemohon', 'email_pemohon',
        'info_ygdibutuhkan', 'tujuan_info', 'foto_ktp', 'cara_perolehinfo',
        'cara_dapatkaninfo', 'tgl_ajuan', 'tgl_respon', 'respon_balas', 'id', 'sts_info', 'sts_public'
    ];

    //backend
    public function list()
    {
        return $this->table('custome__mohoninfo')
            ->orderBy('id_mohoninfo', 'ASC')
            // ->where('id_mohoninfo !=', '0')
            ->get()->getResultArray();
    }

    public function getaktif()
    {
        return $this->table('custome__mohoninfo')
            ->where('sts_public', '1')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('custome__mohoninfo')
            ->where('sts_public', 0)
            ->get()->getResultArray();
    }
}
