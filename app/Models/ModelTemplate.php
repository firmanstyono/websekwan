<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTemplate extends Model
{
    protected $table      = 'template';
    protected $primaryKey = 'template_id';
    protected $allowedFields = [
        'nama', 'pembuat', 'folder', 'status', 'id', 'ket', 'img', 'jtema', 'hplogo', 'wllogo',
        'hpbanner', 'wlbanner', 'verbost', 'duatema', 'warna_topbar', 'sidebar_mode'
    ];

    //backend
    public function list()
    {
        return $this->table('template')
            ->orderBy('template_id', 'ASC')
            ->where('jtema', 1)
            ->get()->getResultArray();
    }

    public function listtadmin()
    {
        return $this->table('template')
            ->where('jtema', 0)
            ->orderBy('template_id', 'ASC')
            ->get()->getResultArray();
    }

    public function tempaktif()
    {
        return $this->table('template')
            ->where('jtema', 1)
            ->orderBy('template_id', 'ASC')
            ->where('status', 1)
            ->get()->getRowArray();
    }

    public function tempadminaktif()
    {
        return $this->table('template')
            ->where('jtema', 0)
            ->orderBy('template_id', 'ASC')
            ->where('status', 1)
            ->get()->getRowArray();
    }


    public function getaktif()
    {
        return $this->table('template')
            ->where('jtema', 1)
            ->where('status', '1')
            ->orderBy('template_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getaktifback()
    {
        return $this->table('template')
            ->where('jtema', 0)
            ->where('status', '1')
            ->orderBy('template_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktif()
    {
        return $this->table('template')
            ->where('jtema', 1)
            ->where('status', 0)
            ->orderBy('template_id', 'ASC')
            ->get()->getResultArray();
    }

    public function getnonaktifback()
    {
        return $this->table('template')
            ->where('jtema', 0)
            ->where('status', 0)
            ->orderBy('template_id', 'ASC')
            ->get()->getResultArray();
    }
    public function resetstatus()
    {
        $this->db->table('template')
            ->where('jtema', 1)
            ->update(['status' => 0]);
    }

    public function resetstatusback()
    {
        $this->db->table('template')
            ->where('jtema', 0)
            ->update(['status' => 0]);
    }
}
