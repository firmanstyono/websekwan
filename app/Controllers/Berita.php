<?php

namespace App\Controllers;

class Berita extends BaseController
{
    public $db;

    public function index()
    {
        $template = $this->template->tempaktif();

        $konfigurasi        = $this->konfigurasi->vkonfig();
        $berita             = $this->berita->listberitapage();

        $data = [
            'title'         => 'Berita | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'berita'        => $berita->paginate(8, 'hal'),
            'pager'         => $berita->pager,
            'kategori'      => $this->kategori->list(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'pengumuman'           => $this->pengumuman->listpengumumanpage()->paginate(10),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'folder'        => $template['folder'],

            'terkini'       => $this->berita->terkini(),
            'foto'              => $this->foto->listfotopage()->paginate(6),
            'tagall'                => $this->tag->listtag(),
            'headline'             => $this->berita->headline(),
            'utama'             => $this->berita->utama(),
            'headline2'         => $this->berita->headline2(),
            'beritapopuler'     => $this->berita->populer()->paginate(5),
            'iklanatas'      => $this->banner->listiklanatas(),
            'iklantengah'             => $this->banner->listiklantengah(),
            'iklankanan1'         => $this->banner->listiklankanan1(),
            'iklankanan2'         => $this->banner->listiklankanan2(),
            'iklankanan3'         => $this->banner->listiklankanan3(),
            'stikkiri'            => $this->banner->iklanstikkiri(),
            'stikkanan'            => $this->banner->iklanstikkanan(),
            'grafisrandom'         => $this->banner->grafisrandom(),
        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/semua_berita', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_berita', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_berita', $data);
        }
    }

    //Detail berita front end
    public function detail($slug_berita = null)
    {
        if (!isset($slug_berita)) return redirect()->to('/');
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $template           = $this->template->tempaktif();
        $berita             = $this->berita->detail_berita($slug_berita);
        $kategori           = $this->kategori->list();
        if ($berita) {
            $list               =  $this->user->find($berita->id);

            // Update hits
            $data = [
                'hits'        => $berita->hits + 1
            ];
            $this->berita->update($berita->berita_id, $data);

            $beritalain = $this->berita->beritalain($berita->berita_id);
            $kategorilain = $this->berita->kategorilain13($berita->berita_id, $berita->kategori_id);
            $kategorilain2 = $this->berita->kategorilain23($berita->berita_id, $berita->kategori_id);
            $poltanya = $this->poling->poltanya();
            $poljawab = $this->poling->poljawab();
            $jumpol = $this->poling->polling_sum();

            $data = [

                'title'          => esc($berita->judul_berita),
                'deskripsi'      => $berita->ringkasan,
                'url'            => base_url('detail/' . $berita->slug_berita),
                'img'            => base_url('/public/img/informasi/berita/' . $berita->gambar),
                'konfigurasi'    => $konfigurasi,
                'berita'         => $berita,
                'beritapopuler'  => $this->berita->populer()->paginate(8),
                'beritapopuler5'  => $this->berita->populer()->paginate(5),
                'terkini3'       => $this->berita->terkini(),
                'kategori'       => $kategori,
                'beritalain'      => $beritalain,
                'kategorilain'      => $kategorilain,
                'kategorilain2'      => $kategorilain2,
                'ebook'           => $this->ebook->listebookpage()->paginate(3),
                'ebook4'           => $this->ebook->listebookpage()->paginate(4),
                'mainmenu'       => $this->menu->mainmenu(),
                'footer'         => $this->menu->footermenu(),
                'topmenu'        => $this->menu->topmenu(),
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'infografis1'    => $this->banner->listinfo1(),
                'agenda'         => $this->agenda->listagendapage()->paginate(4),
                'pengumuman'      => $this->pengumuman->listpengumumanpage()->paginate(10),
                'linkterkaitall'  => $this->linkterkait->publishlinkall(),
                'folder'         => $template['folder'],
                'tag'            => $this->beritatag->listberitatag($berita->berita_id),
                // 'tag'            => $listtag,
                'komen'          => $this->beritakomen->listberitakomen($berita->berita_id),
                'jkomen'          => $this->beritakomen->totkomenbyid($berita->berita_id),

                'sitekey'        => $konfigurasi->g_sitekey,
                'role'           => $this->grupuser->listbyid($list['id_grup']),
                'deskripsiweb'   => $konfigurasi->deskripsi,

                'iklanatas'      => $this->banner->listiklanatas(),
                'iklantengah'             => $this->banner->listiklantengah(),
                'iklankanan1'         => $this->banner->listiklankanan1(),
                'iklankanan2'         => $this->banner->listiklankanan2(),
                'iklankanan3'         => $this->banner->listiklankanan3(),
                'stikkiri'            => $this->banner->iklanstikkiri(),
                'stikkanan'            => $this->banner->iklanstikkanan(),
                'tagall'                => $this->tag->listtag(),
                'foto'              => $this->foto->listfotopage()->paginate(6),
                'poltanya'             => $poltanya['pilihan'],
                'polsts'             => $poltanya['status'],
                'poljawab'             => $poljawab,
                'jumpol'             => $jumpol['jml_vote'],
                'grafisrandom'         => $this->banner->grafisrandom(),
                // mob
                'beritapopuler6'     => $this->berita->populer()->paginate(6),
            ];
            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/detailberita', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/detailberita', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/detailberita', $data);
            }
        } else {
            return redirect()->to('/berita');
        }
    }

    //list per kategori FRONTEND
    public function kategori($slug_kategori = null)
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $berita             = $this->berita->kategori($slug_kategori);
        $template           = $this->template->tempaktif();

        $data = [
            'title'         => 'Kategori ' . $slug_kategori,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'subtitle'      => $slug_kategori,
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),

            'jum'           => $this->db->query("SELECT b.kategori_id  
                               FROM berita AS b JOIN kategori AS k ON b.kategori_id = k.kategori_id 
                               WHERE k.slug_kategori='" . $slug_kategori . "'")->getNumRows(),

            'berita'        => $berita->paginate(6, 'hal'),
            'pager'         => $berita->pager,
            'kategori'      => $this->kategori->list(),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'beritautama'   => $this->berita->headlineall(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'section'       => $this->section->list(),
            'linkterkaitall' => $this->linkterkait->publishlinkall(),
            'folder'        => $template['folder'],
            'terkini'       => $this->berita->terkini(),
            'headline'      => $this->berita->utamabykategori($slug_kategori),
            'iklanatas'      => $this->banner->listiklanatas(),
            'iklantengah'         => $this->banner->listiklantengah(),
            'iklankanan1'         => $this->banner->listiklankanan1(),
            'iklankanan2'         => $this->banner->listiklankanan2(),
            'iklankanan3'         => $this->banner->listiklankanan3(),
            'stikkiri'            => $this->banner->iklanstikkiri(),
            'stikkanan'            => $this->banner->iklanstikkanan(),
            // PERIJINAN
            'grafisrandom'         => $this->banner->grafisrandom(),
        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/semua_kategori', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_kategori', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_kategori', $data);
        }
    }

    //list per tag FRONTEND
    public function tag($tag_id)
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $berita             =  $this->berita->tag($tag_id);
        $template           = $this->template->tempaktif();

        // $berita             =  $this->berita->newsbytag($idk);
        $cari =  $this->tag->find($tag_id);
        if ($cari) {
            $nm = $cari['nama_tag'];
        } else {
            $nm = '-';
        }
        $data = [
            'title'         => 'Tagar ' . $nm,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'subtitle'      => $nm,
            // 'tag_pilih'      => ($j),
            'konfigurasi'    => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            // 'berita'        => $berita,
            'berita'        => $berita->paginate(6, 'hal'),
            'pager'         => $berita->pager,
            'beritautama'   => $this->berita->headlineall(),
            'kategori'      => $this->kategori->list(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'folder'        => $template['folder'],

            'terkini'       => $this->berita->terkini(),
            'foto'              => $this->foto->listfotopage()->paginate(6),
            'tagall'                => $this->tag->listtag(),
            'headline'             => $this->berita->utamabytag($tag_id),
            'utama'             => $this->berita->utama(),
            'headline2'         => $this->berita->headline2(),
            'beritapopuler'     => $this->berita->populer()->paginate(5),
            'iklanatas'      => $this->banner->listiklanatas(),
            'iklantengah'             => $this->banner->listiklantengah(),
            'iklankanan1'         => $this->banner->listiklankanan1(),
            'iklankanan2'         => $this->banner->listiklankanan2(),
            'iklankanan3'         => $this->banner->listiklankanan3(),
            'stikkiri'            => $this->banner->iklanstikkiri(),
            'stikkanan'            => $this->banner->iklanstikkanan(),
            'grafisrandom'         => $this->banner->grafisrandom(),
        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/semua_tag', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_tag', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_tag', $data);
        }
    }

    //list per users FRONTEND
    public function author($id, $nm)
    {

        $konfigurasi        = $this->konfigurasi->vkonfig();
        $berita             = $this->berita->listberitabyuserpg($id);
        $template           = $this->template->tempaktif();
        $list               =  $this->user->find($id);

        $data = [
            'title'         => 'Berita By ' . $nm,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'subtitle'      => $nm,
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'role'          => $this->grupuser->listbyid($list['id_grup']),
            'berita'        => $berita->paginate(6, 'hal'),
            'pager'         => $berita->pager,
            'jum'           => $this->berita->totberitabyid($id),
            'kategori'      => $this->kategori->list(),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'beritautama'   => $this->berita->headlineall(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'section'       => $this->section->list(),
            'linkterkaitall' => $this->linkterkait->publishlinkall(),
            'folder'        => $template['folder'],

            'terkini'       => $this->berita->terkini(),
            'foto'              => $this->foto->listfotopage()->paginate(6),
            'tagall'                => $this->tag->listtag(),
            'headline'             => $this->berita->headline(),
            'utama'             => $this->berita->utama(),
            'headline2'         => $this->berita->headline2(),
            'beritapopuler'     => $this->berita->populer()->paginate(5),
            'iklanatas'      => $this->banner->listiklanatas(),
            'iklantengah'             => $this->banner->listiklantengah(),
            'iklankanan1'         => $this->banner->listiklankanan1(),
            'iklankanan2'         => $this->banner->listiklankanan2(),
            'iklankanan3'         => $this->banner->listiklankanan3(),
            'stikkiri'            => $this->banner->iklanstikkiri(),
            'stikkanan'            => $this->banner->iklanstikkanan(),
            'grafisrandom'         => $this->banner->grafisrandom(),
        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/berita_author', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/berita_author', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/berita_author', $data);
        }
    }

    //list per opd FRONTEND
    public function opd($opd_id, $nm)
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $berita             = $this->berita->listberitabyopdpg($opd_id);
        $template           = $this->template->tempaktif();
        // $list               =  $this->user->find($id);

        $data = [
            'title'         => 'Berita Dari ' . $nm,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'subtitle'      => $nm,
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            // 'role'          => $this->grupuser->listbyid($list['id_grup']),
            'berita'        => $berita->paginate(6, 'hal'),
            'pager'         => $berita->pager,
            'jum'           => $this->berita->totberitabyopd($opd_id),
            'kategori'      => $this->kategori->list(),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'beritautama'   => $this->berita->headlineall(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'section'       => $this->section->list(),
            'linkterkaitall' => $this->linkterkait->publishlinkall(),
            'folder'        => $template['folder'],
            'grafisrandom'         => $this->banner->grafisrandom(),
        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/berita_opd', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/berita_opd', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/berita_opd', $data);
        }
    }


    // simpan Like posting Berita
    public function likeposting($berita_id = null)
    {
        if ($this->request->isAJAX()) {
            $berita_id = $this->request->getVar('berita_id');
            $cari =  $this->berita->find($berita_id);
            $postlike = $cari['likepost'];
            $data = [
                'likepost'        => $postlike + 1,
            ];
            $this->berita->update($berita_id, $data);

            $msg = [
                'sukses' => 'Anda menyukai postingan ini'
            ];

            echo json_encode($msg);
        }
    }

    //list backend
    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }

        $tadmin     = $this->template->tempadminaktif();
        $id_grup    = session()->get('id_grup');
        $urlget     = 'berita/all';
        $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $urlget);

        $data = [
            'title'                 => 'Informasi',
            'subtitle'              => 'Berita',
            'tambah'                => $listgrupf->tambah,
            'hapus'                 => $listgrupf->hapus,

            'folder'                => $tadmin['folder'],
            'csrf_tokencmsdatagoe'  => csrf_hash()
        ];

        return view('backend/' . $tadmin['folder'] . '/' . 'berita/index', $data);
    }

    // Start Serverside

    public function listdata2()
    {
        $request    = \Config\Services::request();
        $list_data  = $this->berita;
        $id         = session()->get('id');
        $id_grup    = session()->get('id_grup');
        $urlget     = 'berita/all';
        $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $urlget);

        $akses  = $listgrupf->akses;
        $hapus  = $listgrupf->hapus;
        $ubah   = $listgrupf->ubah;


        if ($akses == '1') {

            $where = [
                'jenis_berita =' => 'Berita'
            ];
        } elseif ($akses == '2') {
            $where = [
                'berita.id =' => $id,
                'jenis_berita =' => 'Berita'
            ];
        }

        $column_order = array(null, null, 'berita.judul_berita', null, 'berita.tgl_berita', null, null);
        $column_search = array('berita.judul_berita', 'berita.tgl_berita');
        $order = array('berita.berita_id' => 'DESC');
        $lists = $list_data->get_datatables('berita', $column_order, $column_search, $order, $where);
        $data = array();
        $no = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;
            $opd_id = $list->opd_id;

            $viewopd = $this->db->table('custome__opd')->where('opd_id', $opd_id)->where('opd_id !=', 0)->get()->getRowArray();
            if ($viewopd) {
                $useropd = $list->fullname . '<br>' . $viewopd['singkatan_opd'];
            } else {
                $useropd = $list->fullname;
            }
            if ($akses == '1') {
                if ($list->headline == '1') {
                    $utama = '<a class="pointer" onclick="toggleutm(' . $list->berita_id . ')" title="Berita Utama" style="font-size:12px"><i class="far fa-star text-danger"></i> </a>' . mediumdate_indo($list->tgl_berita) . '';
                } else {
                    $utama = '<a class="pointer" onclick="toggleutm(' . $list->berita_id . ')" title="Jadikan Berita Utama" style="font-size:12px"><i class="far fa-star text-secondary"></i> </a>' . mediumdate_indo($list->tgl_berita) . '';
                }
            } else {
                if ($list->headline == '1') {
                    $utama = '<a class="" title="Berita Utama" style="font-size:12px"><i class="far fa-star text-danger"></i> </a>' . mediumdate_indo($list->tgl_berita) . '';
                } else {
                    $utama = '<a class="" title="Jadikan Berita Utama" style="font-size:12px"><i class="far fa-star text-secondary"></i> </a>' . mediumdate_indo($list->tgl_berita) . '';
                }
            }

            if ($list->status == '1') {
                if ($akses == '1') {
                    $sts = '<button type="button" class="btn btn-light btn-sm p-1" onclick="toggle(' . $list->berita_id . ')" title="Klik disini untuk Non Aktifkan"><i class="fas fa-check-circle text-success"></i></button>';
                } else {
                    $sts = '<button type="button" class="btn btn-light btn-sm p-1" title="Telah diterbitkan"><i class="fas fa-check-circle text-success"></i></button>';
                }
                $judulberita = '<a class="text-primary" href="' . base_url('detail/' . $list->slug_berita) . '" target="_blank" class="text-primary">' . esc($list->judul_berita) . '</a>
                <span class="badge badge-success" title="Telah dilihat" style="font-size:10px"> (' . $list->hits . ') </span>';
            } else {
                if ($akses == '1') {
                    $sts = '<button type="button" class="btn btn-light btn-sm p-1" onclick="toggle(' . $list->berita_id . ')" title="Klik disini untuk Terbitkan"><i class="far fa-eye-slash text-danger"></i></button>';
                } else {
                    $sts = '<button type="button" class="btn btn-light btn-sm p-1" title="Menunggu Verifikasi"><i class="far fa-eye-slash text-danger"></i></button>';
                }
                $judulberita = '<a class="text-warning">' . esc($list->judul_berita) . '</a>
                <span class="badge badge-danger" title="Dilihat" style="font-size:10px"> (' . $list->hits . ') </span>';
            }

            // $gambar = '<span class="badge badge-warning pointer" style="font-size:12px" title="Klik disini Lihat atau Ganti Cover" onclick="gantifoto(' . $list->berita_id . ')"> View Cover </span>';
            $gambar = '<img src="' . base_url() . '/public/img/informasi/berita/' . $list->gambar . '" class="img-circle elevation-2 pointer" width="60px" onclick="gantifoto(' . $list->berita_id . ')" />';
            // $tedit = '<button type="button" class="btn btn-warning btn-sm p-1" onclick="edit(' . $list->berita_id . ')"><i class="fa fa-edit text-light"></i></button></a>';
            if ($ubah == '1') {
                $tedit = '<a href="' . base_url('ubah/' . $list->berita_id) . '" target="_self" class="text-primary"><button type="button" class="btn btn-light btn-sm p-1" ><i class="fa fa-edit text-primary"></i></button></a>';
            } else {
                $tedit = '<a href="#" class="text-primary"><button type="button" class="btn btn-light btn-sm p-1" ><i class="fa fa-edit text-secondary"></i></button></a>';
            }

            if ($hapus == '1') {
                $thapus = '<button type="button" class="btn btn-light btn-sm p-1" onclick="hapus(' . $list->berita_id . ')"><i class="far fa-trash-alt text-danger"></i></button>';
            } else {
                $thapus = '<a href="#" class="text-primary"><button type="button" class="btn btn-light btn-sm p-1" ><i class="far fa-trash-alt text-secondary"></i></button></a>';
            }
            // $thapus = '<button type="button" class="btn btn-light btn-sm p-1" onclick="hapus(' . $list->berita_id . ')"><i class="far fa-trash-alt text-danger"></i></button>';

            $row = [];
            $row[] = "<input type=\"checkbox\" name=\"berita_id[]\" class=\"centangBeritaid\" value=\"$list->berita_id\">";
            // $row[] = $no;
            $row[] = $gambar;
            $row[] =  $judulberita;
            $row[] = $list->nama_kategori;
            $row[] = $utama;
            $row[] = $useropd;
            $row[] = $sts . " " . $tedit . " " . $thapus;
            $data[] = $row;
        }

        if ($akses == '1') {
            $total_count = $this->db->query("SELECT jenis_berita FROM `berita` WHERE `jenis_berita`='Berita'")->getResult();
        } elseif ($akses == '2') {
            $total_count = $this->db->query(" SELECT jenis_berita,id FROM `berita` WHERE id='" . $id . "' AND `jenis_berita`='Berita'")->getResult();
        }

        $output = [
            "draw"            => $request->getPost("draw"),
            "recordsTotal"    => count($total_count),
            "recordsFiltered" => count($total_count),
            "data"            => $data,
        ];

        return json_encode($output);
    }


    public function toggle()
    {

        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $cari =  $this->berita->find($id);

            if ($cari['status'] == '1') {
                $list =  $this->berita->getaktif($id);
                $toggle = $list ? 0 : 1;
                $data = [
                    'status'        => $toggle,
                ];
                // $this->berita->update($id, $updatedata);
                $this->berita->updatedata($data, $id);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan postingan!'
                ];
            } else {
                $list =  $this->berita->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $data = [
                    'status'        => $toggle,
                ];
                // $this->berita->update($id, $updatedata);
                $this->berita->updatedata($data, $id);
                $msg = [
                    'sukses' => 'Berhasil menerbitkan postingan!'
                ];
            }

            echo json_encode($msg);
        }
    }
    //publish dan unpublish berita

    public function toggleutm()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $cari =  $this->berita->find($id);

            if ($cari['headline'] == '1') {
                $list =  $this->berita->getutama($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'headline'        => $toggle,
                ];
                $this->berita->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Batalkan Berita Utama!'
                ];
            } else {
                $list =  $this->berita->getnonutama($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'headline'        => $toggle,
                ];
                $this->berita->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil Jadikan Berita Utama!'
                ];
            }

            echo json_encode($msg);
        }
    }


    // form tambah simpan
    public function tambahbaru()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }

        $id_grup = session()->get('id_grup');
        $urlget = 'berita/all';

        $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $urlget);

        $akses  = $listgrupf->akses;

        $id    = session()->get('id');
        $tadmin = $this->template->tempadminaktif();

        // jika temukan maka eksekusi
        if ($listgrupf) {
            # cek akses
            if ($akses == '1' || $akses == '2') {
                $data = [
                    'title'            => 'Berita',
                    'subtitle'         => 'Tambah Baru',
                    'konfigurasi'      => $this->konfigurasi->list(),
                    'kategori'          => $this->kategori->list(),
                    'tag'               => $this->tag->list(),
                    'user'              => $this->user->listaddnews($id),
                    'akses'             => $akses,
                    'id'                => $id,
                    'csrf_tokencmsdatagoe' => csrf_hash(),
                    'folder'                => $tadmin['folder'],
                ];

                return view('backend/' . $tadmin['folder'] . '/' . 'berita/formadd', $data);
                // return view('admin/berita/formadd', $data);
            } else {
                return redirect()->to(base_url('/'));
            }
        } else {
            return redirect()->to(base_url('/'));
        }
    }

    // form modal
    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $id = session()->get('id');
            $urlget = 'berita/all';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $urlget);

            $akses  = $listgrupf->akses;
            $data = [
                'title'      => 'Tambah Berita',
                'kategori'   => $this->kategori->list(),
                'tag'        => $this->tag->list(),
                'user'       => $this->user->listaddnews($id),
                'akses'      => $akses
            ];
            $msg = [
                'data' => view('admin/berita/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function simpanBerita()
    {
        if (session()->get('id') == '') {
            exit('Akses Ilegal');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'judul_berita' => [
                    'label' => 'Judul berita',
                    'rules' => 'required|is_unique[berita.judul_berita]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'kategori_id' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tag_id' => [
                    'label' => 'Tag Berita',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'ringkasan' => [
                    'label' => 'Ringkasan Berita',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'isi' => [
                    'label' => 'Isi Berita',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'gambar' => [
                    'label' => 'Gambar Berita',
                    'rules' => 'uploaded[gambar]|max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul_berita'  => $validation->getError('judul_berita'),
                        'kategori_id'   => $validation->getError('kategori_id'),
                        'tag_id'        => $validation->getError('tag_id'),
                        'isi'           => $validation->getError('isi'),
                        'ringkasan'     => $validation->getError('ringkasan'),
                        'gambar'       => $validation->getError('gambar')
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {

                // start
                $tag_id = $this->request->getVar('tag_id');
                $id     = $this->request->getVar('id');
                if ($id != '') {
                    $userid = $id;
                } else {
                    $userid = session()->get('id');
                }

                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $ceksts = $konfigurasi['sts_posting'];

                // cek role berita
                $id_grup    = session()->get('id_grup');
                $urlget     = 'berita/all';
                $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $urlget);

                $akses  = $listgrupf->akses;

                if ($listgrupf) {
                    if ($akses == '1') {
                        $stspos = 1;
                    } else {
                        if ($ceksts == 1) {
                            $stspos = 0;
                        } else {
                            $stspos = 1;
                        }
                    }
                }

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();
                // $tag = implode(',', $tag_id);
                $insertdata = [

                    'judul_berita'  => $this->request->getVar('judul_berita'),
                    'slug_berita'   => mb_url_title($this->request->getVar('judul_berita'), '-', TRUE),
                    'kategori_id'   => $this->request->getVar('kategori_id'),
                    // 'tagar'         => $tag,
                    'ringkasan'     => $this->request->getVar('ringkasan'),
                    'isi'           => $this->request->getVar('isi'),
                    'status'        => $stspos,
                    'gambar'        => $nama_file,
                    'tgl_berita'    => date('Y-m-d', strtotime($this->request->getVar('tgl_berita'))),
                    'id'            => $userid,
                    'jenis_berita'  => 'Berita',
                    'hits'          => '0',
                    'headline'      => $this->request->getVar('headline'),
                    'ket_foto'      => $this->request->getVar('ket_foto'),
                    'sts_komen'      => $this->request->getVar('sts_komen'),
                    'pilihan'      => $this->request->getVar('pilihan'),

                ];

                $this->berita->insert($insertdata);
                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $nama = strtoupper($konfigurasi['nama']);

                \Config\Services::image()
                    ->withFile($this->request->getFile('gambar'))
                    ->text(
                        $nama,
                        [
                            'color'      => '#fff',
                            'opacity'    => 0.7,
                            'withShadow' => false,
                            'hAlign'     => 'center',
                            'vAlign'     => 'middle',
                            'fontSize'   => 20
                        ]
                    )
                    ->save('public/img/informasi/berita/' . $nama_file, 65);
                $berita_id = $this->berita->getInsertID();

                $jdata = count($tag_id);
                for ($i = 0; $i < $jdata; $i++) {
                    $inserttag = [
                        'berita_id' => $berita_id,
                        'tag_id'    => $tag_id[$i],
                    ];

                    $this->beritatag->insert($inserttag);
                }

                $msg = [
                    'sukses'                => 'Berita berhasil disimpan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash()
                ];
            }
            echo json_encode($msg);
        } else {
            exit('Akses Ilegal');
        }
    }

    public function hapus()
    {

        if (session()->get('id') == '') {
            exit('Akses Ilegal');
        }

        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('berita_id');
            //check tag dan komen
            $listtag =  $this->beritatag->listtag($id);
            $listkomen = $this->beritakomen->listkomen($id);

            foreach ($listtag as $key => $value) {
                $beritatagid = $value['beritatag_id'];

                $this->beritatag->delete($beritatagid);
            }

            foreach ($listkomen as $key => $dt) {
                $beritakomen_id = $dt['beritakomen_id'];
                $this->beritakomen->delete($beritakomen_id);
            }

            $cekdata = $this->berita->find($id);
            $fotolama = $cekdata['gambar'];
            if ($fotolama != '' && file_exists('public/img/informasi/berita/' . $fotolama)) {
                unlink('public/img/informasi/berita/' . $fotolama);
            }
            $this->berita->delete($id);
            $msg = [
                'sukses'                => 'Data Berita Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if (session()->get('id') == '') {
            exit('Akses Ilegal');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('berita_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->berita->find($id[$i]);
                $listtag =  $this->beritatag->listtag($id[$i]);
                $listkomen = $this->beritakomen->listkomen($id[$i]);

                $fotolama = $cekdata['gambar'];
                if ($fotolama != '' && file_exists('public/img/informasi/berita/' . $fotolama)) {
                    unlink('public/img/informasi/berita/' . $fotolama);
                }
                $this->berita->delete($id[$i]);

                foreach ($listtag as $key => $value) {
                    $beritatagid = $value['beritatag_id'];
                    $this->beritatag->delete($beritatagid);
                }

                foreach ($listkomen as $key => $dt) {
                    $beritakomen_id = $dt['beritakomen_id'];
                    $this->beritakomen->delete($beritakomen_id);
                }
            }

            $msg = [
                'csrf_tokencmsdatagoe'  => csrf_hash(),
                'sukses'                => "$jmldata Data berita berhasil dihapus",
            ];
            echo json_encode($msg);
        }
    }

    // form tambah simpan
    public function editberita($berita_id)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }

        $id_grup = session()->get('id_grup');
        $urlget = 'berita/all';
        $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $urlget);

        $akses  = $listgrupf->akses;

        $id    = session()->get('id');
        $list =  $this->berita->find($berita_id);
        $listtag =  $this->beritatag->listtag($berita_id);
        $tadmin = $this->template->tempadminaktif();
        // $tag_pilih = $list['tagar'];
        // $idt = explode(",", $tag_pilih);
        // $listtag = $this->tag->tagberita($idt);

        // jika temukan maka eksekusi
        if ($listgrupf) {
            # cek akses
            if ($akses == '1' || $akses == '2') {
                $data = [
                    'title'          => 'Berita',
                    'subtitle'       => 'Edit ',
                    'berita_id'      => $list['berita_id'],
                    'judul_berita'   => $list['judul_berita'],
                    'ringkasan'      => $list['ringkasan'],
                    'isi'            => $list['isi'],
                    'headline'       => $list['headline'],
                    'ket_foto'       => $list['ket_foto'],
                    'sts_komen'      => $list['sts_komen'],
                    'kategori_id'    => $list['kategori_id'],
                    'pilihan'        => $list['pilihan'],
                    'kategori'       => $this->kategori->list(),
                    'tgl_berita'     => $list['tgl_berita'],
                    'id'             => $list['id'],
                    'tag'            => $this->tag->list(),
                    'tag_id'         => $listtag,
                    'akses'          => $akses,
                    'folder'          => $tadmin['folder'],
                    'user'           => $this->user->listaddnews($id),
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];

                return view('backend/' . $tadmin['folder'] . '/' . 'berita/formedit', $data);
            } else {
                return redirect()->to(base_url('/'));
            }
        } else {

            return redirect()->to(base_url('/'));
        }
    }


    public function updateberita()
    {
        if ($this->request->isAJAX()) {

            $tag_id = $this->request->getVar('tag_id');
            $id = $this->request->getVar('id');
            if ($id != '') {
                $userid = $id;
            } else {
                $userid = session()->get('id');
            }
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'judul_berita' => [
                    'label' => 'Judul berita',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kategori_id' => [
                    'label' => 'Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'isi' => [
                    'label' => 'Isi Berita',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'ringkasan' => [
                    'label' => 'Ringkasan Berita',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tgl_berita' => [
                    'label' => 'Tanggal Posting',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'tag_id' => [
                    'label' => 'Tag',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],


            ]);
            if (!$valid) {
                $msg = [
                    'error' => [

                        'judul_berita'   => $validation->getError('judul_berita'),
                        'kategori_id'   => $validation->getError('kategori_id'),
                        'tag_id'   => $validation->getError('tag_id'),
                        'ringkasan'       => $validation->getError('ringkasan'),
                        'isi'       => $validation->getError('isi'),
                        'tgl_berita'       => $validation->getError('tgl_berita')
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {
                // $tag = implode(',', $tag_id);
                $updatedata = [

                    'judul_berita'  => $this->request->getVar('judul_berita'),
                    'slug_berita'   => mb_url_title($this->request->getVar('judul_berita'), '-', TRUE),
                    'kategori_id'   => $this->request->getVar('kategori_id'),
                    'ringkasan'     => $this->request->getVar('ringkasan'),
                    'isi'           => $this->request->getVar('isi'),
                    'headline'      => $this->request->getVar('headline'),
                    // 'tagar'         => $tag,
                    'tgl_berita'    => date('Y-m-d', strtotime($this->request->getVar('tgl_berita'))),
                    'sts_komen'      => $this->request->getVar('sts_komen'),
                    'pilihan'      => $this->request->getVar('pilihan'),
                    'id'            => $userid,

                ];
                $berita_id = $this->request->getVar('berita_id');
                $this->berita->update($berita_id, $updatedata);

                $listtag =  $this->beritatag->listtag($berita_id);
                foreach ($listtag as $key => $value) {
                    $beritatagid = $value['beritatag_id'];
                    $this->beritatag->delete($beritatagid);
                }
                $jedata = count($tag_id);
                for ($i = 0; $i < $jedata; $i++) {
                    $uptag = [
                        'berita_id' => $berita_id,
                        'tag_id'    => $tag_id[$i],
                    ];
                    $this->beritatag->insert($uptag);
                }

                $msg = [
                    'sukses'                => 'Data berita berhasil diubah!',
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formgantifoto()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('berita_id');
            $list =  $this->berita->find($id);
            $data = [
                'title'       => 'Ganti Sampul Berita',
                'id'          => $list['berita_id'],
                'gambar'      => $list['gambar'],
                'ket_foto'    => $list['ket_foto']
            ];
            $tadmin = $this->template->tempadminaktif();
            $msg = [

                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'berita/gantifoto', $data),
                'csrf_tokencmsdatagoe' => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function douploadBerita()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('berita_id');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Sampul Berita',
                    'rules' => 'max_size[gambar,2024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 2024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'gambar' => $validation->getError('gambar')
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();


                if ($filegambar->GetError() == 4) {
                    $updatedata = [
                        'ket_foto'      => $this->request->getVar('ket_foto')
                    ];

                    $this->berita->update($id, $updatedata);
                    $msg = [
                        'sukses' => 'Data berhasil diubah!',
                        'csrf_tokencmsdatagoe' => csrf_hash()
                    ];
                } else {

                    //check
                    $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                    $nama        = strtoupper($konfigurasi['nama']);

                    $cekdata = $this->berita->find($id);
                    $fotolama = $cekdata['gambar'];
                    if ($fotolama != '' && file_exists('public/img/informasi/berita/' . $fotolama)) {
                        unlink('public/img/informasi/berita/' . $fotolama);
                    }

                    $updatedata = [
                        'gambar'        => $nama_file,
                        'ket_foto'      => $this->request->getVar('ket_foto')
                    ];

                    $this->berita->update($id, $updatedata);
                    \Config\Services::image()
                        ->withFile($this->request->getFile('gambar'))
                        ->text(
                            $nama,
                            [
                                'color'      => '#fff',
                                'opacity'    => 0.7,
                                'withShadow' => false,
                                'hAlign'     => 'center',
                                'vAlign'     => 'middle',
                                'fontSize'   => 20
                            ]
                        )
                        ->save('public/img/informasi/berita/' . $nama_file, 65);

                    $msg = [
                        'sukses' => 'Cover Berita berhasil diganti!',
                        'csrf_tokencmsdatagoe' => csrf_hash()
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    // Balas Komentar Berita----------------------------------------------------------

    public function simpankomen()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_komen' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'email_komen' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'valid_email' => 'Masukkan {field} dengan benar!',
                    ]
                ],
                'hp_komen' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',

                    ]
                ],
                'isi_komen' => [
                    'label' => 'Isi Komentar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_komen'   => $validation->getError('nama_komen'),
                        'email_komen' => $validation->getError('email_komen'),
                        'hp_komen' => $validation->getError('hp_komen'),
                        'isi_komen' => $validation->getError('isi_komen'),
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {

                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

                $secretkey = $konfigurasi['g_secretkey'];
                $g_sitekey = $konfigurasi['g_sitekey'];
                $nama = $this->request->getVar('nama_komen');
                $isi_komen = $this->request->getVar('isi_komen');

                $nm = htmlspecialchars($nama, ENT_QUOTES);
                $isi = htmlspecialchars($isi_komen, ENT_QUOTES);

                // gcaptcha
                $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));
                $secret = $secretkey;
                if ($secretkey != '' && $g_sitekey != '') {

                    $credential = array(
                        'secret' => $secret,
                        'response' => $recaptchaResponse
                    );

                    $verify = curl_init();
                    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                    curl_setopt($verify, CURLOPT_POST, true);
                    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
                    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($verify);

                    $status = json_decode($response, true);
                    if ($status['success']) {

                        $insertdata = [
                            'berita_id'     => $this->request->getVar('berita_id'),
                            'nama_komen'    =>  htmlspecialchars($this->request->getVar('nama_komen'), ENT_QUOTES),
                            'isi_komen'    =>  htmlspecialchars($this->request->getVar('isi_komen'), ENT_QUOTES),
                            'hp_komen'      => $this->request->getVar('hp_komen'),

                            'email_komen'   => $this->request->getVar('email_komen'),
                            'tanggal_komen' => date('Y-m-d H:i:s'),
                            'sts_komen'     => '0'

                        ];

                        $this->beritakomen->insert($insertdata);

                        $msg = [
                            'sukses' => 'Komentar anda telah berhasil dikirim dan perlu dimoderasi untuk ditampilkan.'
                        ];
                    } else {
                        $msg = [
                            'gagal' => 'Gagal kirim Komentar Silahkan periksa Kembali!'
                        ];
                    }
                } else {
                    $insertdata = [
                        'berita_id'     => $this->request->getVar('berita_id'),
                        'hp_komen'      => $this->request->getVar('hp_komen'),
                        'nama_komen'      => $nm,
                        'isi_komen'      => $isi,
                        'email_komen'   => $this->request->getVar('email_komen'),
                        'tanggal_komen' => date('Y-m-d H:i:s'),
                        'sts_komen'     => '0'

                    ];

                    $this->beritakomen->insert($insertdata);
                    $msg = [
                        'sukses' => 'Komentar anda telah berhasil dikirim dan perlu dimoderasi untuk ditampilkan.'
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    // menu Dashboard admin Komen
    public function getkomennew()
    {
        if ($this->request->isAJAX()) {

            $data = [
                'list'      => $this->beritakomen->listkomennew(),
                'totkomen'  => $this->beritakomen->totkomen(),

            ];
            $tadmin = $this->template->tempadminaktif();
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'berita/berita_komen/vmenukomen', $data)

            ];
            echo json_encode($msg);
        }
    }

    // form Baca & balas Komentar
    public function formkomenback()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $beritakomen_id = $this->request->getVar('beritakomen_id');
            $list =  $this->beritakomen->find($beritakomen_id);

            $url = 'berita/all';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);
            $akses  = $listgrupf->akses;

            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' ||  $akses == '2') {
                    $data = [
                        'title'             => 'Tanggapi Komentar',
                        'nama_komen'        => $list['nama_komen'],
                        'hp_komen'          => $list['hp_komen'],
                        'isi_komen'         => $list['isi_komen'],
                        'tanggal_komen'     => $list['tanggal_komen'],
                        'email_komen'       => $list['email_komen'],
                        'sts_komen'         => $list['sts_komen'],
                        'beritakomen_id'    => $list['beritakomen_id'],
                        'balas_komen'       => $list['balas_komen'],
                        'akses'             => $akses
                    ];
                    $tadmin = $this->template->tempadminaktif();
                    $msg = [
                        'sukses'               => view('backend/' . $tadmin['folder'] . '/' . 'berita/berita_komen/edit', $data),
                        'csrf_tokencmsdatagoe' => csrf_hash(),
                    ];
                } else {
                    $msg = [
                        'noakses' => []
                    ];
                }
            } else {

                $msg = [
                    'blmakses' => []
                ];
            }


            echo json_encode($msg);
        }
    }

    // Update Balasan Komentar berita
    public function updatekomentar()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'isi_komen' => [
                    'label' => 'Isi Komentar',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'isi_komen' => $validation->getError('isi_komen'),
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash(),
                ];
            } else {

                $beritakomen_id = $this->request->getVar('beritakomen_id');
                $balas_komen = $this->request->getVar('balas_komen'); //isi balasan
                $isi_komen = $this->request->getVar('isi_komen'); //isi balasan
                $nama_komen = $this->request->getVar('nama_komen'); //isi balasan


                $isi = htmlspecialchars($isi_komen, ENT_QUOTES);
                $bls = htmlspecialchars($balas_komen, ENT_QUOTES);
                $nm = htmlspecialchars($nama_komen, ENT_QUOTES);
                $userid = session()->get('id');
                $data = [
                    'nama_komen'          => $nm,
                    'isi_komen'           => $isi,
                    'sts_komen'            => $this->request->getVar('sts_komen'),
                    'balas_komen'         => $bls,
                    'id'                  => $userid,
                    'tgl_balas'           => date('Y-m-d H:i:s'),
                ];

                $this->beritakomen->update($beritakomen_id, $data);

                $msg = [
                    'sukses'               => 'Berhasil update Data !',
                    'csrf_tokencmsdatagoe' => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    // form list Komentar
    public function listkomen()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'        => 'Komentar',
            'subtitle'     => 'Berita',
            'folder'       => $tadmin['folder'],
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'berita/berita_komen/index', $data);
    }

    // Ambil data Komentar
    public function getdatakomen()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $tadmin = $this->template->tempadminaktif();
            $url = 'berita/all';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;

            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Komentar Berita',
                        'list'      => $this->beritakomen->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'berita/berita_komen/list', $data)
                    ];
                } else {
                    $msg = [
                        'noakses' => []
                    ];
                }
            } else {

                $msg = [
                    'blmakses' => []
                ];
            }

            echo json_encode($msg);
        }
    }

    // hapus Komentar Berita
    public function hapuskomen()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $beritakomen_id = $this->request->getVar('beritakomen_id');
            $this->beritakomen->delete($beritakomen_id);
            $msg = [
                'sukses'             => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe' => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }
    // hapus multi Komen
    public function hapuskomenall()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $beritakomen_id = $this->request->getVar('beritakomen_id');
            $jmldata = count($beritakomen_id);
            for ($i = 0; $i < $jmldata; $i++) {

                $this->beritakomen->delete($beritakomen_id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata data berhasil dihapus",
                'csrf_tokencmsdatagoe' => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    //Start TAG (backend)----------------------

    public function alltag()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [

            'title'       => 'Informasi - Berita',
            'subtitle'    => 'Tag',
            'folder'      => $tadmin['folder'],
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'berita/tag/index', $data);
    }

    public function gettag()
    {

        if ($this->request->isAJAX()) {

            $id_grup    = session()->get('id_grup');
            $url        = 'berita/alltag';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;

            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Tag - Berita',
                        'list'      => $this->tag->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $tadmin = $this->template->tempadminaktif();
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'berita/tag/list', $data)
                    ];
                } else {
                    $msg = [
                        'noakses' => []
                    ];
                }
            } else {

                $msg = [
                    'blmakses' => []
                ];
            }
        }
        echo json_encode($msg);
    }

    public function formtag()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Tag'
            ];
            $tadmin = $this->template->tempadminaktif();
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'berita/tag/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpantag()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_tag' => [
                    'label' => 'Tag',
                    'rules' => 'required|is_unique[tag.nama_tag]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_tag' => $validation->getError('nama_tag'),
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {
                $simpandata = [
                    'nama_tag' => $this->request->getVar('nama_tag'),
                    'slug_tag'   => mb_url_title($this->request->getVar('nama_tag'), '-', TRUE),
                ];

                $this->tag->insert($simpandata);
                $msg = [
                    'sukses'                => 'Data berhasil disimpan',
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedittag()
    {
        if ($this->request->isAJAX()) {
            $tag_id = $this->request->getVar('tag_id');
            $list =  $this->tag->find($tag_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'      => 'Edit Tag',
                'tag_id'     => $list['tag_id'],
                'nama_tag'   => $list['nama_tag'],
            ];
            $msg = [
                'sukses'               => view('backend/' . $tadmin['folder'] . '/' . 'berita/tag/edit', $data),
                'csrf_tokencmsdatagoe' => csrf_hash()

            ];
            echo json_encode($msg);
        }
    }

    public function updatetag()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_tag' => [
                    'label' => 'Nama Tag',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_tag' => $validation->getError('nama_tag'),
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {
                $updatedata = [
                    'nama_tag' => $this->request->getVar('nama_tag'),
                    'slug_tag'   => mb_url_title($this->request->getVar('nama_tag'), '-', TRUE),
                ];

                $tag_id = $this->request->getVar('tag_id');
                $this->tag->update($tag_id, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diupdate',
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapustag()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $tag_id = $this->request->getVar('tag_id');
            $this->tag->delete($tag_id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe' => csrf_hash()
            ];

            echo json_encode($msg);
        }
    }

    //end TAG------------------------------------

    //Start kategori (backend)----------------------
    public function allkategori()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'                 => 'Informasi - Berita',
            'subtitle'              => 'Kategori',
            'csrf_tokencmsdatagoe'  => csrf_hash(),
            'folder'                 => $tadmin['folder'],
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'berita/kategori/index', $data);
    }
    public function getkategori()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'berita/allkategori';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah  = $listgrupf->tambah;

            $tadmin = $this->template->tempadminaktif();
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {

                    $data = [
                        'title'     => 'Kategori - Berita',
                        'list'      => $this->kategori->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'berita/kategori/list', $data)
                    ];
                } else {
                    $msg = [
                        'noakses' => []
                    ];
                }
            } else {
                $msg = [
                    'blmakses' => []
                ];
            }

            echo json_encode($msg);
        }
    }

    public function formkategori()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();

            $data = [
                'title' => 'Tambah Kategori'
            ];
            $msg = [
                'data'                  => view('backend/' . $tadmin['folder'] . '/' . 'berita/kategori/tambah', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function simpankategori()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kategori' => [
                    'label' => 'Kategori',
                    'rules' => 'required|is_unique[kategori.nama_kategori]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kategori' => $validation->getError('nama_kategori'),
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()

                ];
            } else {
                $simpandata = [
                    'nama_kategori' => $this->request->getVar('nama_kategori'),
                    'slug_kategori'   => mb_url_title($this->request->getVar('nama_kategori'), '-', TRUE),
                ];

                $this->kategori->insert($simpandata);
                $msg = [
                    'sukses'               => 'Data berhasil disimpan',
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditkategori()
    {
        if ($this->request->isAJAX()) {
            $kategori_id = $this->request->getVar('kategori_id');
            $list =  $this->kategori->find($kategori_id);
            $data = [
                'title'           => 'Edit Kategori',
                'kategori_id'     => $list['kategori_id'],
                'nama_kategori'   => $list['nama_kategori'],
            ];
            $tadmin = $this->template->tempadminaktif();
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'berita/kategori/edit', $data),
                'csrf_tokencmsdatagoe' => csrf_hash()

            ];
            echo json_encode($msg);
        }
    }

    public function updatekategori()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kategori' => [
                    'label' => 'Nama Kategori',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kategori' => $validation->getError('nama_kategori'),
                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {
                $updatedata = [
                    'nama_kategori' => $this->request->getVar('nama_kategori'),
                    'slug_kategori'   => mb_url_title($this->request->getVar('nama_kategori'), '-', TRUE),

                ];

                $kategori_id = $this->request->getVar('kategori_id');
                $this->kategori->update($kategori_id, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diupdate',
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapuskategori()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $kategori_id = $this->request->getVar('kategori_id');
            $this->kategori->delete($kategori_id);
            $msg = [
                'sukses'                => 'Kategori Berhasil Dihapus',
                'csrf_tokencmsdatagoe' => csrf_hash()
            ];

            echo json_encode($msg);
        }
    }
}
