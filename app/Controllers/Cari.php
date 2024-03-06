<?php

namespace App\Controllers;

class Cari extends BaseController
{

    // cari Artikel 2 kondisi
    public function index()
    {

        $konfigurasi    = $this->konfigurasi->vkonfig();
        $berita         = $this->berita->published();
        $keywordcari    = $this->request->getVar('keyword');
        $kategori       = $this->request->getVar('kategori');
        $template       = $this->template->tempaktif();

        if ($keywordcari || $kategori) {

            if ($kategori == '') {
                $list =  $this->berita->cari($keywordcari, $kategori);
            } else if ($kategori && $keywordcari != '') {
                $list =  $this->berita->carikatkey($keywordcari, $kategori);
            } else {
                $list =  $this->berita->carikat($keywordcari, $kategori);
            }

            $data = [
                'title'          => 'Hasil Pencarian keyword - ' . $keywordcari,
                'deskripsi'         => $konfigurasi->deskripsi,
                'url'               => $konfigurasi->website,
                'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'linkterkaitall' => $this->linkterkait->publishlinkall(),
                'konfigurasi'    => $konfigurasi,

                'mainmenu'       => $this->menu->mainmenu(),
                'footer'         => $this->menu->footermenu(),
                'topmenu'        => $this->menu->topmenu(),
                // 'berita'         => $list,
                'berita'            => $list->paginate(6, 'hal'),
                'pager'             => $list->pager,
                'keyword'        => $keywordcari,
                'keykategori'    => $kategori,
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'infografis1'    => $this->banner->listinfo1(),
                'agenda'         => $this->agenda->listagendapage()->paginate(4),
                'pengumuman'           => $this->pengumuman->listpengumumanpage()->paginate(10),
                'section'        => $this->section->list(),
                'kategori'       =>  $this->kategori->list(),
                'infografis10'    => $this->banner->listinfopage()->paginate(10),
                'grafisrandom'    => $this->banner->grafisrandom(),

                'folder'         => $template['folder'],
                'csrf_tokencmsdatagoe' => csrf_hash(),
            ];
            // Menuju ke web front end;
            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/v_hasilcari', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/v_hasilcari', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/v_hasilcari', $data);
            }
        } else {
            $template = $this->template->tempaktif();
            $berita = $this->berita->listberitapage();
            $data = [
                'title'         => 'Berita | ' . $konfigurasi->nama,
                'deskripsi'         => $konfigurasi->deskripsi,
                'url'               => $konfigurasi->website,
                'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
                'konfigurasi'   => $konfigurasi,
                'mainmenu'      => $this->menu->mainmenu(),
                'footer'        => $this->menu->footermenu(),
                'topmenu'       => $this->menu->topmenu(),
                'berita'        => $berita->paginate(9, 'hal'),
                'pager'         => $berita->pager,
                'kategori'       => $this->kategori->list(),
                'banner'        => $this->banner->list(),
                'infografis'    => $this->banner->listinfo(),
                'infografis1'   => $this->banner->listinfo1(),
                'agenda'        => $this->agenda->listagendapage()->paginate(4),
                'section'       => $this->section->list(),
                'linkterkaitall'    => $this->linkterkait->publishlinkall(),
                'folder'        => $template['folder']
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
    }

    // cari video
    public function video()
    {
        $konfigurasi            = $this->konfigurasi->vkonfig();

        $keywordcari    = $this->request->getVar('keyword');
        $kategori       = $this->request->getVar('kategori');
        $template       = $this->template->tempaktif();

        if ($keywordcari || $kategori) {

            if ($kategori == '') {
                $list =  $this->video->cari($keywordcari, $kategori);
            } else if ($kategori && $keywordcari != '') {
                $list =  $this->video->carikatkey($keywordcari, $kategori);
            } else {
                $list =  $this->video->carikat($keywordcari, $kategori);
            }
            $data = [
                'title'          => 'Hasil Pencarian keyword - ' . $keywordcari,
                'deskripsi'         => $konfigurasi->deskripsi,
                'url'               => $konfigurasi->website,
                'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'linkterkaitall' => $this->linkterkait->publishlinkall(),
                'konfigurasi'    => $konfigurasi,
                'mainmenu'       => $this->menu->mainmenu(),
                'footer'         => $this->menu->footermenu(),
                'topmenu'        => $this->menu->topmenu(),
                'video'         => $list,
                'keyword'        => $keywordcari,
                'keykategori'    => $kategori,
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'infografis1'    => $this->banner->listinfo1(),
                'agenda'         => $this->agenda->listagendapage()->paginate(4),
                'pengumuman'           => $this->pengumuman->listpengumumanpage()->paginate(10),
                'section'        => $this->section->list(),
                'kategori'       => $this->kategorivideo->orderBy('kategorivideo_id', 'ASC')->findAll(),
                'folder'         => $template['folder']
            ];
            // Menuju ke web front end;
            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/v_hasilcarivideo', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/v_hasilcarivideo', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/v_hasilcarivideo', $data);
            }
        } else {

            $video = $this->video->listvideopage();
            $template = $this->template->tempaktif();
            $data = [
                'title'         => 'Galeri Video | ' . $konfigurasi->nama,
                'deskripsi'         => $konfigurasi->deskripsi,
                'url'               => $konfigurasi->website,
                'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
                'konfigurasi'   => $konfigurasi,
                'mainmenu'      => $this->menu->mainmenu(),
                'footer'        => $this->menu->footermenu(),
                'topmenu'       => $this->menu->topmenu(),
                'video'         => $video->paginate(6, 'hal'),
                'pager'         => $video->pager,
                'kategori'      => $this->kategorivideo->orderBy('kategorivideo_id', 'ASC')->findAll(),
                'jum'           => $this->video->totvideo(),
                'banner'        => $this->banner->list(),
                'infografis'    => $this->banner->listinfo(),
                'infografis1'   => $this->banner->listinfo1(),
                'agenda'        => $this->agenda->listagendapage()->paginate(4),
                'foto'          => $this->foto->listfotopage()->paginate(6),
                'section'       => $this->section->list(),
                'linkterkaitall'    => $this->linkterkait->publishlinkall(),
                'folder'        => $template['folder']

            ];
            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/semua_video', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_video', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_video', $data);
            }
        }
    }
    // cari buku
    public function buku()
    {
        $konfigurasi            = $this->konfigurasi->vkonfig();

        $keywordcari    = $this->request->getVar('keyword');
        $kategori       = $this->request->getVar('kategori');
        $template       = $this->template->tempaktif();

        if ($keywordcari || $kategori) {

            if ($kategori == '') {
                $list =  $this->ebook->cari($keywordcari, $kategori);
            } else if ($kategori && $keywordcari != '') {
                $list =  $this->ebook->carikatkey($keywordcari, $kategori);
            } else {
                $list =  $this->ebook->carikat($keywordcari, $kategori);
            }

            $data = [
                'title'          => 'Hasil Pencarian keyword - ' . $keywordcari,
                'deskripsi'         => $konfigurasi->deskripsi,
                'url'               => $konfigurasi->website,
                'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'linkterkaitall' => $this->linkterkait->publishlinkall(),
                'konfigurasi'    => $konfigurasi,
                'mainmenu'       => $this->menu->mainmenu(),
                'footer'         => $this->menu->footermenu(),
                'topmenu'        => $this->menu->topmenu(),
                // 'ebook'         => $list,
                'ebook'         => $list->paginate(6, 'hal'),
                'pager'         => $list->pager,
                'keyword'        => $keywordcari,
                'keykategori'    => $kategori,
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'infografis1'    => $this->banner->listinfo1(),
                'agenda'         => $this->agenda->listagendapage()->paginate(4),
                'section'        => $this->section->list(),
                'kategori'       => $this->kategoriebook->orderBy('kategoriebook_id', 'ASC')->findAll(),
                'beritaterkini' => $this->berita->terkini(),
                'folder'         => $template['folder']
            ];
            // Menuju ke web front end;
            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/v_hasilcaribuku', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/v_hasilcaribuku', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/v_hasilcaribuku', $data);
            }
        } else {

            $ebook = $this->ebook->listebookpage();
            $template = $this->template->tempaktif();
            $data = [
                'title'         => 'E-Book | ' . $konfigurasi->nama,
                'deskripsi'         => $konfigurasi->deskripsi,
                'url'               => $konfigurasi->website,
                'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
                'konfigurasi'   => $konfigurasi,
                'mainmenu'      => $this->menu->mainmenu(),
                'footer'        => $this->menu->footermenu(),
                'topmenu'       => $this->menu->topmenu(),
                'ebook'         => $ebook->paginate(6, 'hal'),
                'pager'         => $ebook->pager,
                'jum'           => $this->ebook->totebook(),
                'banner'        => $this->banner->list(),
                'infografis'    => $this->banner->listinfo(),
                'infografis1'   => $this->banner->listinfo1(),
                'agenda'        => $this->agenda->listagendapage()->paginate(4),
                'section'       => $this->section->list(),
                'linkterkaitall'    => $this->linkterkait->publishlinkall(),
                'beritaterkini' => $this->berita->terkini(),
                'kategori' => $this->kategoriebook->orderBy('kategoriebook_id', 'ASC')->findAll(),
                'folder'        => $template['folder']
            ];
            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/semua_ebook', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_ebook', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_ebook', $data);
            }
        }
    }

    // cari berita 1 kondisi
    public function berita()
    {
        $konfigurasi            = $this->konfigurasi->vkonfig();
        $template               = $this->template->tempaktif();
        $keywordcari            = $this->request->getVar('keyword');
        if ($keywordcari) {

            $list =  $this->berita->cari1($keywordcari);

            $data = [
                'title'             => 'Hasil Pencarian keyword - ' . $keywordcari,
                'deskripsi'         => $konfigurasi->deskripsi,
                'url'               => $konfigurasi->website,
                'img'               => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
                'banner'            => $this->banner->list(),
                'infografis'        => $this->banner->listinfo(),
                'linkterkaitall'    => $this->linkterkait->publishlinkall(),
                'konfigurasi'       => $konfigurasi,
                'kategori'          => $this->kategori->list(),
                'mainmenu'          => $this->menu->mainmenu(),
                'footer'            => $this->menu->footermenu(),
                'topmenu'           => $this->menu->topmenu(),
                // 'berita' => $list,
                'berita'            => $list->paginate(6, 'hal'),
                'pager'             => $list->pager,
                'keyword'           => $keywordcari,
                'banner'            => $this->banner->list(),
                'infografis'        => $this->banner->listinfo(),
                'infografis1'       => $this->banner->listinfo1(),
                'agenda'            => $this->agenda->listagendapage()->paginate(4),
                'pengumuman'        => $this->pengumuman->listpengumumanpage()->paginate(10),
                'section'           => $this->section->list(),
                'folder'            => $template['folder']
            ];
            // Menuju ke web front end;
            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/v_hasilcari', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/v_hasilcari', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/v_hasilcari', $data);
            }
        }
    }
}
