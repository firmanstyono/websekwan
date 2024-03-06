<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTag extends Model
{
    protected $table      = 'tag';
    protected $primaryKey = 'tag_id';
    protected $allowedFields = ['nama_tag', 'slug_tag'];

    //backend
    public function list()
    {
        return $this->table('tag')
            ->orderBy('tag_id', 'ASC')
            ->get()->getResultArray();
    }

    public function listtag()
    {
        return $this->table('tag')
            ->orderBy('tag_id', 'ASC')
            ->get(7, 0)->getResultArray();
    }

    // tagar berita back
    public function tagberita($tag_id)
    {
        return $this->table('tag')
            ->whereIn('tag_id', $tag_id)
            ->get()->getResultArray();
    }

    // public function totbytag($tag_id)
    // {
    //     return $this->table('tag')
    //         ->whereIn('tag_id', $tag_id)
    //         ->get()->getNumRows();
    // }

    public function tottag()
    {
        return $this->table('tag')

            ->get()->getNumRows();
    }
}
