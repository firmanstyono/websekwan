<?php

namespace App\Controllers;

class Template extends BaseController
{

    public function index()
    {

        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $tadmin = $this->template->tempadminaktif();
        $jtemaback = $this->template->where('jtema =', 0)->get()->getNumRows();
        $jtemafront = $this->template->where('jtema =', 1)->get()->getNumRows();
        $data = [
            'title'       => 'Setting Template ',
            'subtitle'    => $konfigurasi['nama'],
            'folder'      => $tadmin['folder'],
            'jtemaback'    => $jtemaback,
            'jtemafront'   => $jtemafront,

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/template/index', $data);
    }


    public function front()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'       => 'Tema Website ',
            'subtitle'    => $konfigurasi['nama'],
            'folder'        => $tadmin['folder']

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/template/front/index', $data);
    }

    public function getdata()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id_grup    = session()->get('id_grup');
            $url        = 'template';
            $tadmin     = $this->template->tempadminaktif();
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
                        'title'     => 'Template Website',
                        'list'      => $this->template->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data'                  => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/template/front/list', $data),
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
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
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title' => 'Tambah Template',
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/template/front/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpantemplate()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Template',
                    'rules' => 'required|is_unique[template.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'folder' => [
                    'label' => 'Nama Folder',
                    'rules' => 'required|is_unique[template.folder]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'pembuat' => [
                    'label' => 'Sumber',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'wllogo' => [
                    'label' => 'Lebar Logo',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hplogo' => [
                    'label' => 'Tinggi Logo',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'wlbanner' => [
                    'label' => 'Lebar Banner',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hpbanner' => [
                    'label' => 'Panjang Banner',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'img' => [
                    'label' => 'Cover',
                    'rules' => 'max_size[img,3024]|mime_in[img,image/png,image/jpg,image/jpeg,image/gif]|is_image[img]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan Cover',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'    => $validation->getError('nama'),
                        'pembuat'        => $validation->getError('pembuat'),
                        'folder'         => $validation->getError('folder'),
                        'img'         => $validation->getError('img'),
                        'wllogo'        => $validation->getError('wllogo'),
                        'hplogo'        => $validation->getError('hplogo'),
                        'wlbanner'      => $validation->getError('wlbanner'),
                        'hpbanner'       => $validation->getError('hpbanner'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {
                $filegambar = $this->request->getFile('img');
                $nama_file = $filegambar->getRandomName();
                if ($filegambar->GetError() == 4) {
                    $insertdata = [
                        'nama'          => $this->request->getVar('nama'),
                        'pembuat'       => $this->request->getVar('pembuat'),
                        'folder'        => $this->request->getVar('folder'),
                        'ket'           => $this->request->getVar('ket'),
                        'status'        => '0',
                        'id'            => session()->get('id'),
                        'img'           => 'default.png',
                        'wllogo'        => $this->request->getVar('wllogo'),
                        'hplogo'        => $this->request->getVar('hplogo'),
                        'wlbanner'      => $this->request->getVar('wlbanner'),
                        'hpbanner'      => $this->request->getVar('hpbanner'),
                        'verbost'       => $this->request->getVar('verbost'),
                        'duatema'       => $this->request->getVar('duatema'),
                        'warna_topbar'  => '-'
                    ];
                    $this->template->insert($insertdata);

                    $msg = [
                        'sukses'                => 'Data berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {
                    $insertdata = [
                        'nama'          => $this->request->getVar('nama'),
                        'pembuat'       => $this->request->getVar('pembuat'),
                        'folder'        => $this->request->getVar('folder'),
                        'ket'           => $this->request->getVar('ket'),
                        'status'        => '0',
                        'id'            => session()->get('id'),
                        'img'           => $nama_file,
                        'wllogo'        => $this->request->getVar('wllogo'),
                        'hplogo'        => $this->request->getVar('hplogo'),
                        'wlbanner'      => $this->request->getVar('wlbanner'),
                        'hpbanner'      => $this->request->getVar('hpbanner'),
                        'verbost'       => $this->request->getVar('verbost'),
                        'duatema'       => $this->request->getVar('duatema'),
                        'warna_topbar'  => '-'
                    ];
                    $this->template->insert($insertdata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/template/' . $nama_file, 70);
                    $msg = [
                        'sukses'                => 'Data berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                }
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

            $id = $this->request->getVar('template_id');

            $cekdata = $this->template->find($id);
            $fotolama = $cekdata['img'];

            if ($fotolama != 'default.png'  && file_exists('public/img/template/' . $fotolama)) {
                unlink('public/img/template/' . $fotolama);
            }

            $this->template->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $template_id = $this->request->getVar('template_id');
            $list =  $this->template->find($template_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'             => 'Edit Template',
                'template_id'       => $list['template_id'],
                'nama'              => $list['nama'],
                'pembuat'           => $list['pembuat'],
                'folder'            => $list['folder'],
                'ket'               => $list['ket'],
                'img'               => $list['img'],
                'wllogo'            => $list['wllogo'],
                'hplogo'            => $list['hplogo'],
                'wlbanner'          => $list['wlbanner'],
                'hpbanner'          => $list['hpbanner'],
                'verbost'           => $list['verbost'],
                'duatema'           => $list['duatema'],

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/template/front/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }


    public function updatetemplate()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $template_id = $this->request->getVar('template_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama' => [
                    'label' => 'Nama Template',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'pembuat' => [
                    'label' => 'Sumber',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'folder' => [
                    'label' => 'Folder',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'wllogo' => [
                    'label' => 'Lebar Logo',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hplogo' => [
                    'label' => 'Tinggi Logo',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'wlbanner' => [
                    'label' => 'Lebar Banner',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'hpbanner' => [
                    'label' => 'Panjang Banner',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'img' => [
                    'label' => 'Gambar',
                    'rules' => 'max_size[img,3024]|mime_in[img,image/png,image/jpg,image/jpeg,image/gif]|is_image[img]',
                    'errors' => [
                        // 'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'          => $validation->getError('nama'),
                        'pembuat'       => $validation->getError('pembuat'),
                        'folder'        => $validation->getError('folder'),
                        'wllogo'        => $validation->getError('wllogo'),
                        'hplogo'        => $validation->getError('hplogo'),
                        'wlbanner'      => $validation->getError('wlbanner'),
                        'hpbanner'      => $validation->getError('hpbanner'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $filegambar = $this->request->getFile('img');
                $nama_file = $filegambar->getRandomName();

                if ($filegambar->GetError() == 4) {
                    $updatedata = [
                        'nama'      => $this->request->getVar('nama'),
                        'pembuat'   => $this->request->getVar('pembuat'),
                        'folder'    => $this->request->getVar('folder'),
                        'ket'       => $this->request->getVar('ket'),
                        'wllogo'    => $this->request->getVar('wllogo'),
                        'hplogo'    => $this->request->getVar('hplogo'),
                        'wlbanner'  => $this->request->getVar('wlbanner'),
                        'hpbanner'  => $this->request->getVar('hpbanner'),
                        'verbost'   => $this->request->getVar('verbost'),
                        'duatema'   => $this->request->getVar('duatema'),
                    ];
                    $this->template->update($template_id, $updatedata);
                    $msg = [
                        'sukses'                => 'Data berhasil diubah!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {
                    //check
                    $cekdata = $this->template->find($template_id);
                    $fotolama = $cekdata['img'];
                    if ($fotolama != '' && file_exists('public/img/template/' . $fotolama)) {
                        unlink('public/img/template/' . $fotolama);
                    }

                    $updatedata = [
                        'nama'      => $this->request->getVar('nama'),
                        'pembuat'   => $this->request->getVar('pembuat'),
                        'folder'    => $this->request->getVar('folder'),
                        'ket'       => $this->request->getVar('ket'),
                        'img'       => $nama_file,
                        'wllogo'    => $this->request->getVar('wllogo'),
                        'hplogo'    => $this->request->getVar('hplogo'),
                        'wlbanner'  => $this->request->getVar('wlbanner'),
                        'hpbanner'  => $this->request->getVar('hpbanner'),
                        'verbost'   => $this->request->getVar('verbost'),
                        'duatema'   => $this->request->getVar('duatema'),
                    ];

                    $this->template->update($template_id, $updatedata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/template/' . $nama_file, 65);

                    $msg = [
                        'sukses' => 'Data berhasil diubah!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function toggle()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $template_id    = $this->request->getVar('template_id');
            $folder         = $this->request->getVar('folder');
            $cari           = $this->template->find($template_id);

            if ($cari['status'] == '1') {
                $list =  $this->template->getaktif($template_id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                    'warna_topbar'  => '-'
                ];

                $this->template->update($template_id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil nonaktifkan template!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->template->getnonaktif($template_id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                    'warna_topbar'  => '-'
                ];

                if ($folder == 'plus1' || $folder == 'yayasan') {
                    $uptema = [
                        'logo'          => 'p1.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }

                if ($folder == 'plus2' || $folder == 'plus3') {
                    $uptema = [
                        'logo'          => 'p3.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }

                if ($folder == 'basic' || $folder == 'herobiz') {
                    $uptema = [
                        'logo'          => 'bs.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }

                if ($folder == 'desaku' || $folder == 'company') {
                    $uptema = [
                        'logo'          => 'p2.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }
                if ($folder == 'perijinan') {
                    $uptema = [
                        'logo'          => 'pnpt.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }

                if ($folder == 'plus4') {
                    $uptema = [
                        'logo'          => 'p4.png',
                    ];
                    $this->konfigurasi->update(1, $uptema);
                }

                $this->template->resetstatus();
                $this->template->update($template_id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil menerapkan template!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }

    public function back()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $tadmin = $this->template->tempadminaktif();
        if ($tadmin) {
            $folder = $tadmin['folder'];
        } else {
            $folder = 'standar';
        }
        $data = [
            'title'       => 'Tema Dashboard Admin',
            'subtitle'    => $konfigurasi['nama'],
            'folder'      => $folder
        ];
        return view('backend/' . $folder . '/' . 'pengaturan/template/back/index', $data);
    }

    public function getdataback()
    {
        if ($this->request->isAJAX()) {

            $id_grup    = session()->get('id_grup');
            $url        = 'template';
            $tadmin     = $this->template->tempadminaktif();
            $listgrupf  = $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Template Website',
                        'list'      => $this->template->listtadmin(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/template/back/list', $data)
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

    public function formtambahback()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title' => 'Tambah Template Admin',
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/template/back/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpantemplateback()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama Template',
                    'rules' => 'required|is_unique[template.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'folder' => [
                    'label' => 'Nama Folder',
                    'rules' => 'required|is_unique[template.folder]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'pembuat' => [
                    'label' => 'Sumber',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'img' => [
                    'label' => 'Cover',
                    'rules' => 'max_size[img,3024]|mime_in[img,image/png,image/jpg,image/jpeg,image/gif]|is_image[img]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan Cover',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'    => $validation->getError('nama'),
                        'pembuat'        => $validation->getError('pembuat'),
                        'folder'         => $validation->getError('folder'),
                        'img'         => $validation->getError('img'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {
                $filegambar = $this->request->getFile('img');
                $nama_file = $filegambar->getRandomName();
                if ($filegambar->GetError() == 4) {
                    $insertdata = [
                        'nama'          => $this->request->getVar('nama'),
                        'pembuat'       => $this->request->getVar('pembuat'),
                        'folder'        => $this->request->getVar('folder'),
                        'ket'           => $this->request->getVar('ket'),
                        'status'        => '0',
                        'jtema'         => '0',
                        'id'            => session()->get('id'),
                        'img'           => 'default.png',
                        'sidebar_mode'  => $this->request->getVar('sidebar_mode'),
                        'warna_topbar'  => $this->request->getVar('warna_topbar'),

                    ];
                    $this->template->insert($insertdata);

                    $msg = [
                        'sukses'                => 'Data berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {
                    $insertdata = [
                        'nama'          => $this->request->getVar('nama'),
                        'pembuat'       => $this->request->getVar('pembuat'),
                        'folder'        => $this->request->getVar('folder'),
                        'ket'           => $this->request->getVar('ket'),
                        'status'        => '0',
                        'jtema'         => '0',
                        'id'            => session()->get('id'),
                        'img'           => $nama_file,
                        'sidebar_mode'  => $this->request->getVar('sidebar_mode'),
                        'warna_topbar'  => $this->request->getVar('warna_topbar'),

                    ];
                    $this->template->insert($insertdata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/template/' . $nama_file, 70);
                    $msg = [
                        'sukses'                => 'Data berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                }
                echo json_encode($msg);
            }
        }
    }

    public function formeditback()
    {

        if ($this->request->isAJAX()) {

            $template_id = $this->request->getVar('template_id');
            $list =  $this->template->find($template_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'             => 'Edit Template Admin',
                'template_id'       => $list['template_id'],
                'nama'               => $list['nama'],
                'pembuat'           => $list['pembuat'],
                'folder'             => $list['folder'],
                'ket'               => $list['ket'],
                'img'               => $list['img'],
                'sidebar_mode'     => $list['sidebar_mode'],
                'warna_topbar'     => $list['warna_topbar'],

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/template/back/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatetemplateback()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $template_id = $this->request->getVar('template_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama' => [
                    'label' => 'Nama Template',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'pembuat' => [
                    'label' => 'Sumber',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'folder' => [
                    'label' => 'Folder',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'img' => [
                    'label' => 'Gambar',
                    'rules' => 'max_size[img,3024]|mime_in[img,image/png,image/jpg,image/jpeg,image/gif]|is_image[img]',
                    'errors' => [
                        // 'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 3024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'           => $validation->getError('nama'),
                        'pembuat'        => $validation->getError('pembuat'),
                        'folder'         => $validation->getError('folder'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $filegambar = $this->request->getFile('img');
                $nama_file = $filegambar->getRandomName();

                if ($filegambar->GetError() == 4) {
                    $updatedata = [
                        'nama'     => $this->request->getVar('nama'),
                        'pembuat'  => $this->request->getVar('pembuat'),
                        'folder'  => $this->request->getVar('folder'),
                        'ket'  => $this->request->getVar('ket'),
                        'sidebar_mode'  => $this->request->getVar('sidebar_mode'),
                        'warna_topbar'  => $this->request->getVar('warna_topbar'),

                    ];
                    $this->template->update($template_id, $updatedata);
                    $msg = [
                        'sukses' => 'Data berhasil diubah!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {
                    //check
                    $cekdata = $this->template->find($template_id);
                    $fotolama = $cekdata['img'];
                    if ($fotolama != '' && file_exists('public/img/template/' . $fotolama)) {
                        unlink('public/img/template/' . $fotolama);
                    }

                    $updatedata = [
                        'nama'          => $this->request->getVar('nama'),
                        'pembuat'       => $this->request->getVar('pembuat'),
                        'folder'        => $this->request->getVar('folder'),
                        'ket'           => $this->request->getVar('ket'),
                        'img'           => $nama_file,
                        'sidebar_mode'  => $this->request->getVar('sidebar_mode'),
                        'warna_topbar'  => $this->request->getVar('warna_topbar'),
                    ];

                    $this->template->update($template_id, $updatedata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/template/' . $nama_file, 65);

                    $msg = [
                        'sukses'                => 'Data berhasil diubah!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    public function toggleback()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $template_id = $this->request->getVar('template_id');
            $folder = $this->request->getVar('folder');
            $cari =  $this->template->find($template_id);

            if ($cari['status'] == '1') {
                $list =  $this->template->getaktifback($template_id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];

                $this->template->update($template_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan template!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->template->getnonaktifback($template_id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];

                $this->template->resetstatusback();
                $this->template->update($template_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil menerapkan template!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }
}
