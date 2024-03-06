<?php

namespace App\Controllers;

class Modul extends BaseController
{

    //list frontend
    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $konfigurasi = $this->konfigurasi->vkonfig();

        $data = [
            'title'       => 'Setting Modul ',
            'subtitle'    => $konfigurasi->nama,
            'folder'       => $tadmin['folder']
        ];

        return view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/grupmenu/index', $data);
    }

    public function det($gm = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($gm == '') {
            return redirect()->to(base_url('modul'));
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'            => 'Pengaturan',
            'subtitle'         => 'Modul',
            'gm'               => $gm,
            'folder'           => $tadmin['folder']

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/index', $data);
    }

    public function getdata()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'modul';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
            $gm = $this->request->getVar('gm');
            $list      = $this->modulecms->listbygrupall($gm);
            $modulmenu = $this->modulecms->listmenuutama();
            $tadmin = $this->template->tempadminaktif();

            if ($modulmenu) {
                $pilmodul = $modulmenu;
            } else {
                $pilmodul = '-';
            }

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {

                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'         => 'Modul CMS',
                        'list'          => $list,
                        'akses'         => $akses,
                        'modulmenu'     => $pilmodul
                    ];
                    $msg = [
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                        'data'                  => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/list', $data),
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
        } else {
            return redirect()->to(base_url('admin'));
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
                'title'         => 'Tambah Modul',
                'gm'            => $this->request->getVar('gm'),
                // 'modulmenu'     => $this->modulecms->listmenuutama()
            ];
            $msg = [
                'data'          => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/tambah', $data),

            ];
            echo json_encode($msg);
        }
    }

    public function simpanmodul()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'modul' => [
                    'label' => 'Nama Modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'urlmenu' => [
                    'label' => 'Link URL',
                    'rules' => 'required|is_unique[cms__modul.urlmenu]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'

                    ]
                ],
                'urut' => [
                    'label' => 'Urutan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modul'          => $validation->getError('modul'),
                        'urlmenu'        => $validation->getError('urlmenu'),
                        'urut'         => $validation->getError('urut'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'modul'          => $this->request->getVar('modul'),
                    'urlmenu'        => $this->request->getVar('urlmenu'),
                    'gm'             => $this->request->getVar('gm'),
                    'urut'           => $this->request->getVar('urut'),
                    'ikonmn'         => $this->request->getVar('ikonmn'),
                    'tipemn'         => 'sm',
                    'level'          => '3',

                ];
                $this->modulecms->insert($insertdata);
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

            $id = $this->request->getVar('id_modul');
            $cekmodulakses =  $this->grupakses->listaksesmodul($id);
            // GRUPAKSES 
            if ($cekmodulakses) {
                foreach ($cekmodulakses as $data) :
                    $this->grupakses->delete($data['id_grupakses']);
                endforeach;
                # code...
            }
            $this->modulecms->delete($id);
            $msg = [
                'sukses'                => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id_modul = $this->request->getVar('id_modul');
            $list =  $this->modulecms->find($id_modul);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'      => 'Edit Modul',
                'id_modul'   => $list['id_modul'],
                'modul'      => $list['modul'],
                'gm'         => $list['gm'],
                'urlmenu'    => $list['urlmenu'],
                'urut'       => $list['urut'],
                'ikonmn'     => $list['ikonmn'],
                'modulmenu'  => $this->modulecms->listmenuutama()

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }


    public function updatemodul()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id_modul = $this->request->getVar('id_modul');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'modul' => [
                    'label' => 'Nama Modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'urlmenu' => [
                    'label' => 'Link URL',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urut' => [
                    'label' => 'Urutan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modul'        => $validation->getError('modul'),
                        'urlmenu'      => $validation->getError('urlmenu'),
                        'urut'         => $validation->getError('urut'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'modul'          => $this->request->getVar('modul'),
                    'urlmenu'        => $this->request->getVar('urlmenu'),
                    'gm'             => $this->request->getVar('gm'),
                    'urut'           => $this->request->getVar('urut'),
                    'ikonmn'         => $this->request->getVar('ikonmn'),


                ];
                $this->modulecms->update($id_modul, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    // Set akses modul ke Role

    public function formsetakses()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id_modul   = $this->request->getVar('id_modul');
            $urlget     = $this->request->getVar('urlmenu');
            $list       = $this->modulecms->find($id_modul);
            $jrole      = $this->grupuser->selectCount('id_grup')->first();
            $tadmin     = $this->template->tempadminaktif();
            $id_grup    = session()->get('id_grup');
            $listgrupf  = $this->grupakses->viewgrupakses($id_grup, $urlget);
            // $carigrupakses =  $this->grupakses->find($id_modul); 
            $totalmodul     = $this->grupakses->totmodul($id_modul);
            if ($listgrupf) {
                $tambah = $listgrupf->tambah;
                $ubah   = $listgrupf->ubah;
                $hapus  = $listgrupf->hapus;
                $akses  = $listgrupf->akses;
            } else {
                $tambah = '1';
                $ubah   = '1';
                $hapus  = '1';
                $akses  = '1';
            }
            if ($totalmodul == $jrole['id_grup']) {
                $statusnya = 'OK';
            } else {
                $statusnya = 'No Akses';
            }
            $data = [
                'title'         => 'Set Akses Modul',
                'id_modul'      => $list['id_modul'],
                'modul'         => $list['modul'],
                'statusnya'     => $statusnya,
                'tambah'        => $tambah,
                'hapus'         => $hapus,
                'ubah'          => $ubah,
                'akses'         => $akses,

                'modulmenu'     => $this->modulecms->listmenuutama(),
                'listgrup'      => $this->grupuser->list(),

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/setakses', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    // simpan ke grup akses module baru

    public function simpansetakses()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([

                'id_grup' => [
                    'label' => 'Grup Akses',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'id_grup'           => $validation->getError('id_grup'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $id_modul = $this->request->getVar('id_modul');
                $id_grup  = $this->request->getVar('id_grup');
                $akses    = $this->request->getVar('akses');
                $tambah   = $this->request->getVar('tambah');
                $ubah     = $this->request->getVar('ubah');
                $hapus    = $this->request->getVar('hapus');

                $listganda =  $this->grupakses->listgrupaksesganda($id_grup, $id_modul);
                $dataakses = [
                    'id_grup'    => $id_grup,
                    'id_modul'   => $id_modul,
                    'akses'      => $akses,
                    'tambah'     => $tambah,
                    'ubah'       => $ubah,
                    'hapus'      => $hapus,
                ];

                if ($listganda) {
                    // dapatkan id_grupakses
                    foreach ($listganda as $datamod) :
                        $id_grupakses = $datamod['id_grupakses'];
                    endforeach;
                    $this->grupakses->update($id_grupakses, $dataakses);
                    // $msg = [
                    //     'aksesganda'            => 'Grup Akses sudah ditentukan.',
                    //     'csrf_tokencmsdatagoe'  => csrf_hash(),
                    // ];
                    $msg = [
                        'sukses'                => 'Role grup berhasil diubah!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {


                    $this->grupakses->insert($dataakses);

                    $msg = [
                        'sukses'                => 'Modul berhasil ditambahkan ke Role Grup!',
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
            $id_modul = $this->request->getVar('id_modul');
            $cari =  $this->modulecms->find($id_modul);

            if ($cari['aktif'] == '1') {
                $list =  $this->modulecms->getaktif($id_modul);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'aktif'        => $toggle,
                ];

                $this->modulecms->update($id_modul, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan modul!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->modulecms->getnonaktif($id_modul);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'aktif'        => $toggle,
                ];

                $this->modulecms->update($id_modul, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil mengaktifkan Modul!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }

    // GRUP MENU (UTAMA)------------------------------------------------------------

    public function grupmenu()
    {
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'        => 'Pengaturan',
            'subtitle'     => 'Modul',
            'folder'        => $tadmin['folder']
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/grupmenu/index', $data);
    }

    public function getgrupmenu()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'modul';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
            $tadmin = $this->template->tempadminaktif();
            // cek set akses sesuai role
            $list = $this->modulecms->listmenuutamaall();
            // foreach ($list as $datamod) :
            //     $id_modul = $datamod['id_modul'];
            // endforeach;
            // $jrole = $this->grupuser->selectCount('id_grup')->first();
            // $totalmodul     = $this->grupakses->totmodul($id_modul);
            // if ($totalmodul >= $jrole['id_grup']) {
            //     $statusnya = 'Y';
            // } else {
            //     $statusnya = 'N';
            // }

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Menu Grup',
                        'list'      =>  $list,
                        'akses'     => $akses,
                        // 'statusnya'     => $statusnya
                        // 'modul'          => $this->modulecms->listmenuutama()
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/grupmenu/list', $data)
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

    public function formtambahmenu()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Tambah Modul',
                'modulmenu'     => $this->modulecms->listmenuutama()
            ];
            $msg = [
                'data'          => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/grupmenu/tambah', $data),

            ];
            echo json_encode($msg);
        }
    }

    public function simpangrupmenu()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'modul' => [
                    'label' => 'Nama Menu',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

                'urut' => [
                    'label' => 'Urutan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'gm' => [
                    'label' => 'Grup',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modul'        => $validation->getError('modul'),
                        'urut'         => $validation->getError('urut'),
                        'gm'         => $validation->getError('gm'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'modul'      => $this->request->getVar('modul'),
                    'urlmenu'    => '-',
                    'gm'         => $this->request->getVar('gm'),
                    'urut'      => $this->request->getVar('urut'),
                    'ikonmn'    => $this->request->getVar('ikonmn'),
                    'tipemn'    => 'utm',
                    'level'     => '3',


                ];
                $this->modulecms->insert($insertdata);
                $msg = [
                    'sukses'                => 'Data berhasil disimpan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            }
        }
    }

    // Set akses modul ke Role

    public function formsetaksesmenu()
    {
        if ($this->request->isAJAX()) {

            $id_modul = $this->request->getVar('id_modul');
            $list =  $this->modulecms->find($id_modul);
            $tadmin = $this->template->tempadminaktif();
            // $carigrupakses =  $this->grupakses->find($id_modul);
            $jrole = $this->grupuser->selectCount('id_grup')->first();
            $totalmodul     = $this->grupakses->totmodul($id_modul);
            if ($totalmodul >= $jrole['id_grup']) {
                $statusnya = 'OK';
            } else {
                $statusnya = 'Belum';
            }
            $data = [
                'title'         => 'Set Akses Menu',
                'id_modul'     => $list['id_modul'],
                'modul'          => $list['modul'],
                'statusnya'       => $statusnya,
                'modulmenu'     => $this->modulecms->listmenuutama(),
                'listgrup'   => $this->grupuser->list(),

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/grupmenu/setakses', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    // simpan set akses ke grup akses module baru (dalam)

    public function simpansetaksesmenu()
    {
        if ($this->request->isAJAX()) {
            $id_modul = $this->request->getVar('id_modul');
            $id_grup = $this->request->getVar('id_grup');
            $aksesmenu = $this->request->getVar('aksesmenu');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'id_grup' => [
                    'label' => 'Grup Akses',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'id_grup'    => $validation->getError('id_grup'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                // listgrupaksesganda
                $listganda =  $this->grupakses->listgrupaksesganda($id_grup, $id_modul);
                if ($listganda) {
                    $msg = [
                        'aksesganda'            => 'Grup Akses sudah ditentukan.',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {

                    $insertakses = [
                        'id_grup'    => $id_grup,
                        'id_modul'   => $id_modul,
                        'aksesmenu'  => $aksesmenu,
                    ];

                    $this->grupakses->insert($insertakses);

                    $msg = [
                        'sukses'                => 'Menu berhasil ditambahkan ke Role Grup!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                }
            }
            echo json_encode($msg);
        }
    }

    // edit grup menu
    public function formeditmenu()
    {
        if ($this->request->isAJAX()) {

            $id_modul = $this->request->getVar('id_modul');
            $list =  $this->modulecms->find($id_modul);
            $tadmin = $this->template->tempadminaktif();

            $data = [
                'title'      => 'Edit Menu',
                'id_modul'   => $list['id_modul'],
                'modul'      => $list['modul'],
                'gm'         => $list['gm'],
                // 'urlmenu'    => $list['urlmenu'],
                'urut'       => $list['urut'],
                'ikonmn'     => $list['ikonmn'],
                'modulmenu'  => $this->modulecms->listmenuutama()

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/grupmenu/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }


    public function updatemodulmenu()
    {
        if ($this->request->isAJAX()) {
            $id_modul = $this->request->getVar('id_modul');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'modul' => [
                    'label' => 'Nama Modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        // 'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'gm' => [
                    'label' => 'Grup',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'urut' => [
                    'label' => 'Urutan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modul'          => $validation->getError('modul'),
                        'gm'        => $validation->getError('gm'),
                        'urut'         => $validation->getError('urut'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'modul'      => $this->request->getVar('modul'),
                    'gm'         => $this->request->getVar('gm'),
                    'urut'      => $this->request->getVar('urut'),
                    'ikonmn'    => $this->request->getVar('ikonmn'),

                ];
                $this->modulecms->update($id_modul, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    // MODUL UNTUK PUBLIK

    public function publik()
    {
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'       => 'Modul',
            'subtitle'    => 'Publik',
            'folder'        => $tadmin['folder']
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/publik/index', $data);
    }

    public function getpublik()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');
            $url = 'modul';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
            $tadmin = $this->template->tempadminaktif();
            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;

            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {

                    $data = [
                        'title'     => 'Modul Publik',
                        'list'      => $this->modulpublic->list(),
                        'akses'     => $akses
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/publik/list', $data)
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

    public function formpublik()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title' => 'Tambah Modul'
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/publik/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanpublik()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'modpublic' => [
                    'label' => 'Modul',
                    'rules' => 'required|is_unique[cms__modpublic.modpublic]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],
                'link' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modpublic' => $validation->getError('modpublic'),
                        'link' => $validation->getError('link'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $simpandata = [
                    'modpublic' => $this->request->getVar('modpublic'),
                    'link'      => $this->request->getVar('link'),
                ];

                $this->modulpublic->insert($simpandata);
                $msg = [
                    'sukses'                => 'Data berhasil disimpan',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditpublik()
    {
        if ($this->request->isAJAX()) {
            $id_modpublic = $this->request->getVar('id_modpublic');
            $list =  $this->modulpublic->find($id_modpublic);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'          => 'Edit Modul',
                'id_modpublic'   => $list['id_modpublic'],
                'modpublic'      => $list['modpublic'],
                'link'           => $list['link'],
            ];
            $msg = [
                'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/modul/publik/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatepublik()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'modpublic' => [
                    'label' => 'Modul',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'link' => [
                    'label' => 'Link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'modpublic' => $validation->getError('modpublic'),
                        'link'      => $validation->getError('link'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $updatedata = [
                    'modpublic' => $this->request->getVar('modpublic'),
                    'link'      => $this->request->getVar('link'),
                ];

                $id_modpublic = $this->request->getVar('id_modpublic');
                $this->modulpublic->update($id_modpublic, $updatedata);

                $msg = [
                    'sukses'                => 'Data berhasil diupdate',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapuspublik()
    {
        if ($this->request->isAJAX()) {
            $id_modpublic = $this->request->getVar('id_modpublic');
            $this->modulpublic->delete($id_modpublic);
            $msg = [
                'sukses'                => 'Modul Publik Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    //publish dan unpublish modul publik
    public function togglepublik()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_modpublic');
            $cari =  $this->modulpublic->find($id);

            if ($cari['stsmod'] == '1') {
                $list =  $this->modulpublic->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'stsmod'        => $toggle,
                ];
                $this->modulpublic->update($id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil Non Aktifkan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->modulpublic->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'stsmod'        => $toggle,
                ];
                $this->modulpublic->update($id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil Mengaktifkan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }
    // End MODul Publik
}
