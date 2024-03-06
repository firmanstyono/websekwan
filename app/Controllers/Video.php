<?php

namespace App\Controllers;

class Video extends BaseController
{
    //list semua video
    public function index()
    {

        $konfigurasi    = $this->konfigurasi->vkonfig();
        $video = $this->video->listvideopage();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Galeri Video | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'video'         => $video->paginate(6, 'hal'),
            'pager'         => $video->pager,
            'kategori_video'      => $this->kategorivideo->orderBy('kategorivideo_id', 'ASC')->findAll(),
            'jum'           => $this->video->totvideo(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'foto'          => $this->foto->listfotopage()->paginate(6),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategori'      => $this->kategori->list(),
            'grafisrandom'         => $this->banner->grafisrandom(),
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
    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin             = $this->template->tempadminaktif();

        $data = [
            'title'       => 'Galeri',
            'subtitle'    => 'Video',
            'folder'      => $tadmin['folder'],
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/index', $data);
    }

    public function getdata($id = null)
    {
        if ($this->request->isAJAX()) {
            $id_grup    = session()->get('id_grup');
            $id         = session()->get('id');
            $url        = 'video/all';
            $tadmin     = $this->template->tempadminaktif();

            $listgrupf  = $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            if ($akses == 1) {
                $list =  $this->video->listvideo();
            } elseif ($akses == 2) {
                $list = $this->video->listvideoauthor($id);
            }
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Galeri Video',
                        'list'      => $list,
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/list', $data)
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

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();

            $data = [
                'title' => 'Tambah Video',
                'kategori' => $this->kategorivideo->orderBy('kategorivideo_id', 'ASC')->findAll()
            ];
            $msg = [
                'data'     => view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/tambah', $data),

            ];
            echo json_encode($msg);
        }
    }

    public function uploadvideo()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'judul' => [
                    'label' => 'Judul Video',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'video_link' => [
                    'label' => 'Link Video',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'kategorivideo_id' => [
                    'label' => 'Kategori Video',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul'           => $validation->getError('judul'),
                        'video_link' => $validation->getError('video_link'),
                        'kategorivideo_id' => $validation->getError('kategorivideo_id'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $userid = session()->get('id');
                // $level = session()->get('level');
                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $ceksts = $konfigurasi['sts_posting'];

                // cek role video
                $id_grup = session()->get('id_grup');
                $urlget = 'video/all';
                $listgrupf =  $this->grupakses->listgrupakses($id_grup, $urlget);

                foreach ($listgrupf as $data) :
                    $akses = $data['akses'];
                endforeach;

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
                $insertdata = [
                    'judul'             => $this->request->getVar('judul'),
                    'kategorivideo_id'  => $this->request->getVar('kategorivideo_id'),
                    'video_link'        => $this->request->getVar('video_link'),
                    'tanggal'           => date('Y-m-d'),
                    'id'                => $userid,
                    'sts_v'             => $stspos,
                    'ket_video'   => $this->request->getVar('ket_video'),
                ];

                $this->video->insert($insertdata);
                $msg = [
                    'sukses'                => 'Video berhasil diupload!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $video_id = $this->request->getVar('video_id');
            $list =  $this->video->find($video_id);
            $tadmin             = $this->template->tempadminaktif();

            $data = [
                'title'       => 'Edit Galeri Video',
                'video_id'    => $list['video_id'],
                'judul'         => $list['judul'],
                'video_link'      => $list['video_link'],
                'kategorivideo_id'    => $list['kategorivideo_id'],
                'ket_video'      => $list['ket_video'],
                'kategorivideo' => $this->kategorivideo->list(),

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatevideo()
    {
        if ($this->request->isAJAX()) {

            $video_id = $this->request->getVar('video_id');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'judul' => [
                    'label' => 'Judul Video',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'video_link' => [
                    'label' => 'Link Video',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'kategorivideo_id' => [
                    'label' => 'Kategori Video',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul' => $validation->getError('judul'),
                        'video_link' => $validation->getError('video_link'),
                        'kategorivideo_id' => $validation->getError('kategorivideo_id')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'judul'   => $this->request->getVar('judul'),
                    'kategorivideo_id'   => $this->request->getVar('kategorivideo_id'),
                    'video_link'   => $this->request->getVar('video_link'),
                    'ket_video'   => $this->request->getVar('ket_video'),
                ];
                $this->video->update($video_id, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    //tambah multi
    public function uploadvideomulti()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();

            $data = [
                'title' => 'Tambah Video',
                'kategori' => $this->kategorivideo->orderBy('kategorivideo_id', 'ASC')->findAll()
            ];
            $msg = [
                'data'                  => view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/formmultiadd', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function simpanmulti()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'judul' => [
                    'label' => 'Keterangan Foto',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'video_link' => [
                    'label' => 'Link video',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'kategorivideo_id' => [
                    'label' => 'Kategori video',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul'       => $validation->getError('judul'),
                        'video_link'  => $validation->getError('video_link'),
                        'kategorivideo_id'  => $validation->getError('kategorivideo_id')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $judul  = $this->request->getVar('judul');
                $video_link  = $this->request->getVar('video_link');
                $ket_video  = $this->request->getVar('ket_video');
                $kategorivideo_id  = $this->request->getVar('kategorivideo_id');
                $userid = session()->get('id');
                $video_id = $this->request->getVar('video_id');

                // $level = session()->get('level');
                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $ceksts = $konfigurasi['sts_posting'];

                // cek role video
                $id_grup = session()->get('id_grup');
                $urlget = 'video/all';
                $listgrupf =  $this->grupakses->listgrupakses($id_grup, $urlget);

                foreach ($listgrupf as $data) :
                    $akses = $data['akses'];
                endforeach;

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
                $jdata = count($video_id);
                for ($i = 0; $i < $jdata; $i++) {

                    $insertdata = [
                        'judul'             => $judul[$i],
                        'video_link'        => $video_link[$i],
                        'kategorivideo_id'  => $kategorivideo_id[$i],
                        'tanggal'           => date('Y-m-d'),
                        'id'                => $userid,
                        'sts_v'             => $stspos,
                        'ket_video'        => $ket_video,
                    ];

                    $this->video->insert($insertdata);

                    $msg = [
                        'sukses'                => "$jdata Video berhasil ditambahkan !",
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                }

                $msg = [
                    'sukses'                => 'Data berhasil disimpan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $video_id = $this->request->getVar('video_id');

            $this->video->delete($video_id);
            $msg = [
                'sukses' => 'Data berhasil dihapus!',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $video_id = $this->request->getVar('video_id');
            $jmldata = count($video_id);
            for ($i = 0; $i < $jmldata; $i++) {
                $this->video->delete($video_id[$i]);
            }
            $msg = [
                'sukses'                => "$jmldata video berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    // aktif non aktifkan

    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $video_id = $this->request->getVar('video_id');
            $cari =  $this->video->find($video_id);

            if ($cari['sts_v'] == '1') {
                $list =  $this->video->getaktif($video_id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'sts_v'        => $toggle,
                ];

                $this->video->update($video_id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil nonaktifkan video!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->video->getnonaktif($video_id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'sts_v'        => $toggle,
                ];

                $this->video->update($video_id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil mengaktifkan video!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }

    //Start kategori (backend)
    public function kategori()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'       => 'Galeri - Video',
            'subtitle'    => 'Kategori',
            'folder'      => $tadmin['folder'],
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/kategorivideo/index', $data);
    }

    public function getkategori()
    {
        if ($this->request->isAJAX()) {
            $id_grup    = session()->get('id_grup');
            $url        = 'video/all';

            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            $tadmin = $this->template->tempadminaktif();
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Galeri Video',
                        'list'      => $this->kategorivideo->orderBy('kategorivideo_id', 'ASC')->findAll(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data'                  => view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/kategorivideo/list', $data),

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
            $data = [
                'title' => 'Tambah Kategori',
                // 'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            $tadmin = $this->template->tempadminaktif();

            $msg = [
                'data'                  => view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/kategorivideo/tambah', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),

            ];
            echo json_encode($msg);
        }
    }

    public function simpankategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kategori_video' => [
                    'label' => 'Kategori',
                    'rules' => 'required|is_unique[kategori_video.nama_kategori_video]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kategori_video' => $validation->getError('nama_kategori_video'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $simpandata = [
                    'nama_kategori_video' => $this->request->getVar('nama_kategori_video'),
                    'slug_kategori_video' => $this->request->getVar('slug_kategori_video'),

                ];

                $this->kategorivideo->insert($simpandata);
                $msg = [
                    'sukses'                => 'Data berhasil disimpan',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditkategori()
    {
        if ($this->request->isAJAX()) {
            $kategorivideo_id = $this->request->getVar('kategorivideo_id');
            $list =  $this->kategorivideo->find($kategorivideo_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'           => 'Edit Kategori',
                'kategorivideo_id'     => $list['kategorivideo_id'],
                'nama_kategori_video'   => $list['nama_kategori_video'],

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'galeri/video/kategorivideo/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatekategori()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_kategori_video' => [
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
                        'nama_kategori_video' => $validation->getError('nama_kategori_video'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $updatedata = [
                    'nama_kategori_video' => $this->request->getVar('nama_kategori_video'),
                    'slug_kategori_video' => $this->request->getVar('slug_kategori_video'),
                ];

                $kategorivideo_id = $this->request->getVar('kategorivideo_id');
                $this->kategorivideo->update($kategorivideo_id, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diupdate',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapuskategori()
    {
        if ($this->request->isAJAX()) {

            $kategorivideo_id = $this->request->getVar('kategorivideo_id');

            $this->kategorivideo->delete($kategorivideo_id);
            $msg = [
                'sukses'                => 'Kategori Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }
    //end kategori

    //Detail berita front end
    public function detail($video_id = null)
    {
        if (!isset($video_id)) return redirect()->to('/home#video');

        $konfigurasi    = $this->konfigurasi->vkonfig();
        $template = $this->template->tempaktif();

        $video = $this->video->detail_video($video_id);
        $videolain = $this->video->videolainnya($video_id);
        $kategori = $this->kategori->list();

        if ($video) {

            // Update hits
            $data = [
                'hits'        => $video->hits + 1
            ];
            $this->video->update($video->video_id, $data);

            $data = [
                'title'          => $video->judul,
                'deskripsi'      => $video->ket_video,
                'url'           => base_url('video/detail/' . $video->video_id),
                'img'           => 'https://img.youtube.com/vi/' . $video->video_link . '/mqdefault.jpg',
                'konfigurasi'    => $konfigurasi,
                'video'         => $video,
                'beritapopuler' => $this->berita->populer()->paginate(8),
                'videolain'     => $videolain,
                'kategori'       => $this->kategorivideo->orderBy('kategorivideo_id', 'ASC')->findAll(),
                'mainmenu'       => $this->menu->mainmenu(),
                'footer'         => $this->menu->footermenu(),
                'topmenu'        => $this->menu->topmenu(),
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'infografis1'    => $this->banner->listinfo1(),
                'agenda'         => $this->agenda->listagendapage()->paginate(4),
                'linkterkaitall'    => $this->linkterkait->publishlinkall(),
                'grafisrandom'         => $this->banner->grafisrandom(),
                'folder'        => $template['folder'],

            ];
            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/detailvideo', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/detailvideo', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/detailvideo', $data);
            }
            // return view('' . $template['folder'] . '/' . 'content/detailvideo', $data);
        } else {
            return redirect()->to('/home#video');
        }
    }

    // simpan Like posting Video

    public function likevideo($video_id = null)
    {
        if ($this->request->isAJAX()) {
            $video_id = $this->request->getVar('video_id');
            $cari =  $this->video->find($video_id);
            $postlike = $cari['likevideo'];
            $data = [
                'likevideo'        => $postlike + 1,
            ];
            $this->video->update($video_id, $data);

            $msg = [
                'sukses'                => 'Anda menyukai video ini',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }
}
