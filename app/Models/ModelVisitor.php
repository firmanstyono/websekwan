<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelVisitor extends Model
{
    protected $table      = 'visitor';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'ip', 'tgl', 'hits', 'online', 'time'
    ];


    public function pengunjungblnini()
    {
        $dt = date('m');
        return $this->table('visitor')
            ->where('month(tgl)', $dt)
            ->groupBy('ip')
            ->get()->getNumRows();
    }
}
