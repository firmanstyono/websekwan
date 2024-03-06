<?php

namespace App\Controllers;

class Produkhukum extends BaseController
{
    //list frontend
    public function index()
    {

        $konfigurasi        = $this->konfigurasi->vkonfig();
        $kategori           = $this->kategori->list();
        $agenda             = $this->agenda->listagendapage();
        $produkhukum        = $this->produkhukum->listprodukhukumpg();
        $pengumuman         = $this->pengumuman->listpengumumanpage();
        $template           = $this->template->tempaktif();
        $data = [
            'title'         => 'Produk Hukum | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'produkhukum'   => $produkhukum->paginate(6, 'hal'),
            'pager'         => $produkhukum->pager,
            'jum'           => $this->produkhukum->totproduk(),
            'beritapopuler' => $this->berita->populer()->paginate(8),
            'beritapopuler6' => $this->berita->populer()->paginate(6),
            'kategori'      => $kategori,
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'pengumuman'    => $pengumuman->paginate(2),
            'agenda'        => $agenda->paginate(4),
            'infografis1'   => $this->banner->listinfo1(),
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategori'      => $this->kategori->list(),
            'grafisrandom'         => $this->banner->grafisrandom(),
            'terkini3'       => $this->berita->terkini3(),
            'folder'        => $template['folder']
        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/produk_hukum', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/produk_hukum', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/produk_hukum', $data);
        }
    }

    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'       => 'Produk',
            'subtitle'    => 'Hukum',
            'folder'    =>  $tadmin['folder'],

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $id_grup        = session()->get('id_grup');
            $url            = 'produkhukum/all';
            $listgrupf      = $this->grupakses->viewgrupakses($id_grup, $url);

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
                        'title'     => 'Produk Hukum',
                        'list'      => $this->produkhukum->listprodukhukum(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/list', $data)

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

    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title' => 'Tambah Produk Hukum',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/tambah', $data)

            ];
            echo json_encode($msg);
        }
    }

    public function simpanprodukhukum()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_produk' => [
                    'label' => 'Nama produk hukum',
                    'rules' => 'required|is_unique[produk_hukum.nama_produk]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'

                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_produk'           => $validation->getError('nama_produk'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'nama_produk'  => $this->request->getVar('nama_produk'),
                    'id'           => session()->get('id')

                ];
                $this->produkhukum->insert($insertdata);
                $msg = [
                    'sukses'                => 'Data berhasil disimpan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            }
        }
    }

    public function hapus()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('produk_id');

            $this->produkhukum->delete($id);
            $msg = [
                'sukses'                 => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $produk_id = $this->request->getVar('produk_id');
            $list =  $this->produkhukum->find($produk_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Edit Produk',
                'produk_id'     => $list['produk_id'],
                'nama_produk'   => $list['nama_produk'],

            ];
            $msg = [
                'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }


    public function updateproduk()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $produk_id = $this->request->getVar('produk_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_produk' => [
                    'label' => 'Nama Produk Hukum',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_produk'           => $validation->getError('nama_produk'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'nama_produk'  => $this->request->getVar('nama_produk'),

                ];
                $this->produkhukum->update($produk_id, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }


    // Detail Produk Hukum
    public function subproduk($produk_id = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($produk_id == '') {

            return redirect()->to(base_url('produkhukum/all'));
        }
        $tadmin = $this->template->tempadminaktif();
        $list =  $this->produkkathukum->listprodukkathukum($produk_id);
        $data = [
            'title'     => 'Produk Hukum',
            'subtitle'  => 'Detail',
            'produk_id' => $produk_id,
            'list'      => $list,
            'folder'    =>  $tadmin['folder'],

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkathukum/index', $data);
    }

    // get data
    public function subprodukajx()
    {
        if ($this->request->isAJAX()) {

            $id_grup        = session()->get('id_grup');
            $url            = 'produkhukum/all';
            $listgrupf      = $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            // jika temukan maka eksekusi
            $tadmin = $this->template->tempadminaktif();
            if ($listgrupf) {
                $produk_id = $this->request->getVar('produk');
                $list =  $this->produkkathukum->listprodukkathukum($produk_id);

                if ($produk_id == '') {
                    return redirect()->to(base_url('produkhukum/all'));
                }
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Produk Hukum',
                        'list'      => $list,
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkathukum/list', $data)

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


    public function formtambahsubproduk()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title' => 'Tambah Sub Produk Hukum',
                'id_produk' => $this->request->getVar('produk'),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            $tadmin = $this->template->tempadminaktif();
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkathukum/tambah', $data)

            ];
            echo json_encode($msg);
        }
    }

    public function simpanSubproduk()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_kathukum' => [
                    'label' => 'Judul produk',
                    'rules' => 'required|is_unique[produk_kathukum.nama_kathukum]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'file_kathukum' => [
                    'label' => 'file',
                    'rules' => [
                        'mime_in[file_kathukum,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[file_kathukum,6096]',
                    ],
                    'errors' => [
                        'max_size' => 'Ukuran {field} Maksimal 6096 KB..!!',
                        'mime_in' => 'Format {field} tidak valid..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kathukum'  => $validation->getError('nama_kathukum'),
                        'file_kathukum'     => $validation->getError('file_kathukum'),

                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $fileproduk = $this->request->getFile('file_kathukum');
                $nama_file = $fileproduk->getRandomName();

                //jika file tidak ada / lanjut 
                if ($fileproduk->GetError() == 4) {

                    $insertdata = [

                        'produk_id'         => $this->request->getVar('id_produk'),
                        'nama_kathukum'     => $this->request->getVar('nama_kathukum'),
                        'skathukum'         => $this->request->getVar('skathukum'),
                        'status_kathukum'   => '1',
                        'tanggal_kathukum'  => date('Y-m-d'),

                    ];

                    $this->produkkathukum->insert($insertdata);

                    $msg = [
                        'sukses' => 'Data berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {

                    if ($fileproduk->isValid() && !$fileproduk->hasMoved()) {
                        $fileproduk->move(ROOTPATH . 'public/unduh/produkhukum/', $nama_file);
                        $insertdata = [
                            'produk_id'        => $this->request->getVar('id_produk'),
                            'nama_kathukum'    => $this->request->getVar('nama_kathukum'),
                            'skathukum'        => $this->request->getVar('skathukum'),
                            'file_kathukum'    => $nama_file,
                            'status_kathukum'  => '1',
                            'tanggal_kathukum' => date('Y-m-d'),
                        ];
                        $this->produkkathukum->insert($insertdata);
                    }

                    $msg = [
                        'sukses'                => 'Data berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function formeditsub()
    {
        if ($this->request->isAJAX()) {

            $kathukum_id = $this->request->getVar('kathukum_id');

            $list =  $this->produkkathukum->find($kathukum_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Edit Detail Produk',
                'kathukum_id'   => $kathukum_id,
                'produk_id'     => $list['kathukum_id'],
                'nama_kathukum' => $list['nama_kathukum'],
                'skathukum'     => $list['skathukum'],
                'file_kathukum' => $list['file_kathukum'],


            ];
            $msg = [
                'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkathukum/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatesubproduk()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $kathukum_id = $this->request->getVar('kathukum_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_kathukum' => [
                    'label' => 'Nama Produk Hukum',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_kathukum' => $validation->getError('nama_kathukum'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check
                $cekdata = $this->produkkathukum->find($kathukum_id);
                $filelama = $cekdata['file_kathukum'];

                $sts = $this->request->getVar('skathukum');

                if ($sts == 1) {


                    if ($filelama != '-' && ($filelama != null) && file_exists('public/unduh/produkhukum/' . $filelama)) {
                        unlink('public/unduh/produkhukum/' . $filelama);
                    }

                    $updatedata = [
                        'nama_kathukum'  => $this->request->getVar('nama_kathukum'),
                        'skathukum'      => $this->request->getVar('skathukum'),
                        'file_kathukum'  => '-',

                    ];
                } else {
                    $updatedata = [
                        'nama_kathukum'  => $this->request->getVar('nama_kathukum'),
                        'skathukum'      => $this->request->getVar('skathukum'),

                    ];
                }

                $this->produkkathukum->update($kathukum_id, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    //ganti upload file sub

    public function formuploadfile()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $kathukum_id = $this->request->getVar('kathukum_id');

            $list =  $this->produkkathukum->find($kathukum_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'          => 'Upload File',
                'kathukum_id'    => $kathukum_id,
                'file_kathukum'   => $list['file_kathukum']
            ];
            $msg = [
                'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkathukum/gantifile', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function douploadsubproduk()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('kathukum_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'file_kathukum' => [
                    'label' => 'File produk hukum',
                    'rules' => [
                        'uploaded[file_kathukum]',
                        'mime_in[file_kathukum,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[file_kathukum,6096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Masukkan File',
                        'max_size' => 'Ukuran {field} Maksimal 6096 KB..!!',
                        'mime_in'  => 'Format {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'file_kathukum' => $validation->getError('file_kathukum')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check
                $cekdata = $this->produkkathukum->find($id);
                $filelama = $cekdata['file_kathukum'];

                if ($filelama != '-' && ($filelama != null) && file_exists('public/unduh/produkhukum/' . $filelama)) {
                    unlink('public/unduh/produkhukum/' . $filelama);
                }
                $filebaru = $this->request->getFile('file_kathukum');
                $nama_file = $filebaru->getRandomName();

                if ($filebaru->isValid() && !$filebaru->hasMoved()) {

                    $filebaru->move(ROOTPATH . 'public/unduh/produkhukum/', $nama_file);
                    $updatedata = [
                        'file_kathukum' => $nama_file
                    ];
                    $this->produkkathukum->update($id, $updatedata);
                }

                $msg = [
                    'sukses'                => 'File berhasil diupload!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }


    function unduh($fileupload)
    {

        $list =  $this->bankdata->downloadfile($fileupload);
        if ($list) {
            $datahits = [
                'hits'        => $list['hits'] + 1
            ];
            $this->bankdata->update($list['bankdata_id'], $datahits);
            return $this->response->download('public/unduh/bankdata/' . $list['fileupload'], null);
        } else {
            return redirect()->to('/');
        }
    }

    public function hapussub()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('kathukum_id');
            //check
            $cekdata = $this->produkkathukum->find($id);
            $filelama = $cekdata['file_kathukum'];

            if ($cekdata['skathukum'] != '1') {
                if ($filelama != '-' && ($filelama != null) && file_exists('public/unduh/produkhukum/' . $filelama)) {
                    // if ($cekdata['file_kathukum'] != 'default.png' && ($cekdata['file_kathukum'] != null)) {
                    unlink('public/unduh/produkhukum/' . $filelama);
                }
            }

            $this->produkkathukum->delete($id);
            $msg = [
                'sukses'                => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapussuball()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('kathukum_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->produkkathukum->find($id[$i]);
                $filelama = $cekdata['file_kathukum'];

                if ($cekdata['skathukum'] != '1') {
                    if ($filelama != '-' && ($filelama != null) && file_exists('public/unduh/produkhukum/' . $filelama)) {
                        // if ($cekdata['file_kathukum'] != 'default.png' && ($cekdata['file_kathukum'] != null)) {
                        unlink('public/unduh/produkhukum/' . $filelama);
                    }
                }
                $this->produkkathukum->delete($id[$i]);
            }

            $msg = [
                'sukses'                => "$jmldata Data berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    // end sub & Start SUB-SUB=====================================================

    // Detail SubProduk Hukum
    public function detailsubproduk($kathukum_id = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($kathukum_id == '') {

            return redirect()->to(base_url('produkhukum/all'));
        }
        $tadmin = $this->template->tempadminaktif();
        $list =  $this->produkkatsubhukum->listprodukkatsubhukum($kathukum_id);
        $data = [
            'title'         => 'Produk Hukum',
            'subtitle'      => 'Sub Detail',
            'kathukum_id'   => $kathukum_id,
            'list'          => $list,
            'folder'    =>  $tadmin['folder'],

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkatsubhukum/index', $data);
    }

    // get datasubdetail
    public function subsubprodukajx()
    {
        if ($this->request->isAJAX()) {

            $id_grup    = session()->get('id_grup');
            $url        = 'produkhukum/all';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;

            $tadmin = $this->template->tempadminaktif();
            // jika temukan maka eksekusi
            if ($listgrupf) {
                $kathukum_id = $this->request->getVar('subproduk');
                $list =  $this->produkkatsubhukum->listprodukkatsubhukum($kathukum_id);

                if ($kathukum_id == '') {

                    return redirect()->to(base_url('produkhukum/all'));
                }
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Produk Hukum',
                        'list'      => $list,
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkatsubhukum/list', $data)

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


    public function formtambahsubsubproduk()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title'                 => 'Tambah Detail Sub Produk Hukum',
                'kathukum_id'           => $this->request->getVar('subproduk'),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            $tadmin = $this->template->tempadminaktif();
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkatsubhukum/tambah', $data)

            ];
            echo json_encode($msg);
        }
    }


    public function simpanSubsubproduk()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('kathukum_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_subkathukum' => [
                    'label' => 'Judul produk',
                    'rules' => 'required|is_unique[produk_subkathukum.nama_subkathukum]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'file_subkathukum' => [
                    'label' => 'File produk hukum',
                    'rules' => [
                        'uploaded[file_subkathukum]',
                        'mime_in[file_subkathukum,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[file_subkathukum,6096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Masukkan File',
                        'max_size' => 'Ukuran {field} Maksimal 6096 KB..!!',
                        'mime_in'  => 'Format {field} tidak diijinkan..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_subkathukum'  => $validation->getError('nama_subkathukum'),
                        'file_subkathukum'     => $validation->getError('file_subkathukum'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $filebaru = $this->request->getFile('file_subkathukum');
                $nama_file = $filebaru->getRandomName();

                if ($filebaru->isValid() && !$filebaru->hasMoved()) {

                    $filebaru->move(ROOTPATH . 'public/unduh/produkhukum/', $nama_file);
                    $insertdata = [
                        'kathukum_id'         => $this->request->getVar('kathukum_id'),
                        'nama_subkathukum'    => $this->request->getVar('nama_subkathukum'),
                        'file_subkathukum'    => $nama_file,
                        'status_subkathukum'  => '1',
                        'tanggal_subkathukum' => date('Y-m-d'),
                    ];
                    $this->produkkatsubhukum->insert($insertdata);
                }

                $msg = [
                    'sukses'                => 'Data berhasil disimpan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditsubsub()
    {
        if ($this->request->isAJAX()) {

            $subkathukum_id = $this->request->getVar('subkathukum_id');

            $list =  $this->produkkatsubhukum->find($subkathukum_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Edit Data',
                'subkathukum_id'  => $subkathukum_id,
                'kathukum_id'   => $list['kathukum_id'],
                'nama_subkathukum' => $list['nama_subkathukum'],

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkatsubhukum/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }


    public function updatesubsubproduk()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $subkathukum_id = $this->request->getVar('subkathukum_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_subkathukum' => [
                    'label' => 'Nama Produk Hukum',
                    'rules' => 'required|is_unique[produk_subkathukum.nama_subkathukum]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong.',
                        'is_unique' => '{field} sudah ada.',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_subkathukum' => $validation->getError('nama_subkathukum'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'nama_subkathukum'  => $this->request->getVar('nama_subkathukum'),

                ];

                $this->produkkatsubhukum->update($subkathukum_id, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    //ganti upload file sub

    public function formuploadsubfile()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $subkathukum_id = $this->request->getVar('subkathukum_id');
            $tadmin = $this->template->tempadminaktif();
            $list =  $this->produkkatsubhukum->find($subkathukum_id);
            $data = [
                'title'             => 'Upload File',
                'subkathukum_id'    => $subkathukum_id,
                'file_subkathukum'  => $list['file_subkathukum']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'informasi/produkhukum/produkkatsubhukum/gantifile', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),

            ];
            echo json_encode($msg);
        }
    }

    public function douploadsubsubproduk()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }

        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('subkathukum_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'file_subkathukum' => [
                    'label' => 'File produk hukum',
                    'rules' => [
                        'uploaded[file_subkathukum]',
                        'mime_in[file_subkathukum,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[file_subkathukum,6096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Masukkan File',
                        'max_size' => 'Ukuran {field} Maksimal 6096 KB..!!',
                        'mime_in'  => 'Format {field} tidak diijinkan..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'file_subkathukum' => $validation->getError('file_subkathukum')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check
                $cekdata = $this->produkkatsubhukum->find($id);
                $filelama = $cekdata['file_subkathukum'];
                if ($filelama != '' && file_exists('public/unduh/produkhukum/' . $filelama)) {
                    // if ($filelama != 'default.png') {
                    unlink('public/unduh/produkhukum/' . $filelama);
                }

                $filebaru = $this->request->getFile('file_subkathukum');
                $nama_file = $filebaru->getRandomName();

                if ($filebaru->isValid() && !$filebaru->hasMoved()) {

                    $filebaru->move(ROOTPATH . 'public/unduh/produkhukum/', $nama_file);
                    $updatedata = [
                        'file_subkathukum' => $nama_file
                    ];
                    $this->produkkatsubhukum->update($id, $updatedata);
                }

                $msg = [
                    'sukses' => 'File berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapussubsub()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('subkathukum_id');
            //check
            $cekdata = $this->produkkatsubhukum->find($id);
            $filelama = $cekdata['file_subkathukum'];

            if ($filelama != '' && ($filelama != null) && file_exists('public/unduh/produkhukum/' . $filelama)) {
                unlink('public/unduh/produkhukum/' . $filelama);
            }

            $this->produkkatsubhukum->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapussubsuball()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('subkathukum_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->produkkatsubhukum->find($id[$i]);
                $filelama = $cekdata['file_subkathukum'];

                if ($filelama != '' && ($filelama != null) && file_exists('public/unduh/produkhukum/' . $filelama)) {
                    unlink('public/unduh/produkhukum/' . $filelama);
                }

                $this->produkkatsubhukum->delete($id[$i]);
            }

            $msg = [
                'sukses'                => "$jmldata Data berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }
}
