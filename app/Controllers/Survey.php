<?php

namespace App\Controllers;

class Survey extends BaseController
{

    public function index()
    {

        $konfigurasi    = $this->konfigurasi->vkonfig();
        $kategori = $this->kategori->list();
        $agenda = $this->agenda->listagendapage();
        $surveytopik = $this->surveytopik->listsurveytopikpg();
        $pengumuman = $this->pengumuman->listpengumumanpage();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Survei | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'surveytopik'   => $surveytopik->paginate(1, 'hal'),
            'pager'         => $surveytopik->pager,
            'jum'           => $this->surveytopik->totsurvey(),
            'beritapopuler' => $this->berita->populer()->paginate(4),
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
            'sitekey'        => $konfigurasi->g_sitekey,
            'grafisrandom'         => $this->banner->grafisrandom(),
            'terkini3'       => $this->berita->terkini3(),
            'folder'        => $template['folder']

        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/survei', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/survei', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/survei', $data);
        }
    }


    public function cetak($survey_id = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($survey_id == '') {

            return redirect()->to(base_url('surveytopik/all'));
        }

        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $surveytopik = $this->surveytopik->listcetak($survey_id);
        $tadmin             = $this->template->tempadminaktif();
        $data = [
            'title'         => 'Masukan dan Saran',
            'subtitle'      => 'Detail',
            'konfigurasi'   => $konfigurasi,
            'survey_id'     => $survey_id,
            'surveytopik'   => $surveytopik,
            'nama_survey'   => $surveytopik['nama_survey'],
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/cetaksurvey', $data);
    }


    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin             = $this->template->tempadminaktif();
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

        $data = [
            'title'       => 'Survei ',
            'subtitle'    => $konfigurasi['nama'],
            'folder'      => $tadmin['folder'],

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $id = session()->get('id');
            $url = 'survey/all';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            // jika temukan maka eksekusi
            if ($akses == 1) {
                $list =   $this->surveytopik->listsurveytopik();
            } elseif ($akses == 2) {
                $list = $this->surveytopik->listsurveytopikauthor($id);
            }
            $tadmin = $this->template->tempadminaktif();

            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Survei',
                        'list'      => $list,
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data'      => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/list', $data),
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
                'title'                 => 'Tambah Topik',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/tambah', $data)

            ];
            echo json_encode($msg);
        }
    }

    public function simpansurveytopik()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_survey' => [
                    'label' => 'Topik Survei',
                    'rules' => 'required|is_unique[survey_topik.nama_survey]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],
                'ket_stb' => [
                    'label' => 'Keterangan stb',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_kb' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_b' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_sb' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_survey'    => $validation->getError('nama_survey'),
                        'ket_stb'        => $validation->getError('ket_stb'),
                        'ket_kb'         => $validation->getError('ket_kb'),
                        'ket_b'          => $validation->getError('ket_b'),
                        'ket_sb'         => $validation->getError('ket_sb'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'nama_survey'  => $this->request->getVar('nama_survey'),
                    'ket_stb'  => $this->request->getVar('ket_stb'),
                    'ket_kb'  => $this->request->getVar('ket_kb'),
                    'ket_b'  => $this->request->getVar('ket_b'),
                    'ket_sb'  => $this->request->getVar('ket_sb'),
                    // 'r1_stb'  => $this->request->getVar('r1_stb'),
                    // 'r2_stb'  => $this->request->getVar('r2_stb'),
                    // 'r1_kb'  => $this->request->getVar('r1_kb'),
                    // 'r2_kb'  => $this->request->getVar('r2_kb'),
                    // 'r1_b'  => $this->request->getVar('r1_b'),
                    // 'r2_b'  => $this->request->getVar('r2_b'),
                    // 'r1_sb'  => $this->request->getVar('r1_sb'),
                    // 'r2_sb'  => $this->request->getVar('r2_sb'),
                    'status'       => '0',
                    'id'           => session()->get('id')

                ];
                $this->surveytopik->insert($insertdata);
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

            $id = $this->request->getVar('survey_id');

            $this->surveytopik->delete($id);
            $msg = [
                'sukses'                => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function resetnilai()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('survey_id');

            // cek responden
            $cekreponden =  $this->responden->cekhapusresponden($id);

            if ($cekreponden) {
                foreach ($cekreponden as $data) :
                    $idreponden = $data['responden_id'];
                    $this->responden->delete($idreponden);
                endforeach;
            }

            $updatedata = [
                'skor'  => 0,
                'hits'  => 0,
            ];
            $this->surveytopik->update($id, $updatedata);

            $msg = [
                'sukses'                => 'Data Berhasil direset',
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

            $survey_id = $this->request->getVar('survey_id');
            $list =  $this->surveytopik->find($survey_id);

            $jpertanyaan = $this->pertanyaan->where('survey_id', $survey_id)->get()->getNumRows();
            $r_awstb1   = $jpertanyaan * 1; // sangt tdk baik
            $r_awkb1    = $jpertanyaan * 2; //kurang baik
            $r_awb1     = $jpertanyaan * 3; //baik
            $r_awsb1    = $jpertanyaan * 4; //sangt baik

            if ($jpertanyaan != 0) {
                $r_akstb2   = $r_awkb1 - 1; //ra akhir sangat tdk baik
                $r_akb2     = $r_awb1 - 1; //ra akhir kurang baik
                $r_ab2      = $r_awsb1 - 1; //ra akhir baik
            } else {
                $r_akstb2   = 0;
                $r_akb2     = 0;
                $r_ab2      = 0;
            }

            $data = [
                'title'         => 'Edit Topik',
                'survey_id'     => $list['survey_id'],
                'nama_survey'   => $list['nama_survey'],

                'ket_stb'       => $list['ket_stb'],
                'ket_kb'        => $list['ket_kb'],
                'ket_b'         => $list['ket_b'],
                'ket_sb'        => $list['ket_sb'],

                'r1_stb'        => $r_awstb1,
                'r2_stb'        => $r_akstb2,
                'r1_kb'         => $r_awkb1,
                'r2_kb'         => $r_akb2,
                'r1_b'          => $r_awb1,
                'r2_b'          => $r_ab2,
                'r1_sb'         => $r_awsb1,
                // 'r2_sb'   => $list['r2_sb'],
                // 'r1_stb'   => $list['r1_stb'],
                // 'r2_stb'   => $list['r2_stb'],
                // 'r1_kb'   => $list['r1_kb'],
                // 'r2_kb'   => $list['r2_kb'],
                // 'r1_b'   => $list['r1_b'],
                // 'r2_b'   => $list['r2_b'],
                // 'r2_kb'   => $list['r2_kb'],
                // 'r1_sb'   => $list['r1_sb'],
                // 'r2_sb'   => $list['r2_sb'],

                'jumtanya'       => $jpertanyaan,


            ];
            $tadmin = $this->template->tempadminaktif();
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),

            ];
            echo json_encode($msg);
        }
    }


    public function updatetopik()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $survey_id = $this->request->getVar('survey_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_survey' => [
                    'label' => 'Topik Survei',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_stb' => [
                    'label' => 'Keterangan stb',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_kb' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_b' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ket_sb' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_survey'    => $validation->getError('nama_survey'),
                        'ket_stb'        => $validation->getError('ket_stb'),
                        'ket_kb'         => $validation->getError('ket_kb'),
                        'ket_b'          => $validation->getError('ket_b'),
                        'ket_sb'         => $validation->getError('ket_sb'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'nama_survey'     => $this->request->getVar('nama_survey'),
                    'ket_stb'  => $this->request->getVar('ket_stb'),
                    'ket_kb'  => $this->request->getVar('ket_kb'),
                    'ket_b'  => $this->request->getVar('ket_b'),
                    'ket_sb'  => $this->request->getVar('ket_sb'),

                    // 'r1_stb'  => $this->request->getVar('r1_stb'),
                    // 'r2_stb'  => $this->request->getVar('r2_stb'),
                    // 'r1_kb'  => $this->request->getVar('r1_kb'),
                    // 'r2_kb'  => $this->request->getVar('r2_kb'),
                    // 'r1_b'  => $this->request->getVar('r1_b'),
                    // 'r2_b'  => $this->request->getVar('r2_b'),
                    // 'r1_sb'  => $this->request->getVar('r1_sb'),
                    // 'r2_sb'  => $this->request->getVar('r2_sb'),


                ];
                $this->surveytopik->update($survey_id, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
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
            $survey_id = $this->request->getVar('survey_id');
            $cari =  $this->surveytopik->find($survey_id);

            if ($cari['status'] == '1') {
                $list =  $this->surveytopik->getaktif($survey_id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];

                $this->surveytopik->update($survey_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan survei!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->surveytopik->getnonaktif($survey_id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->surveytopik->resetdata();
                $this->surveytopik->update($survey_id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil mengaktifkan survei!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }

    // start RESPONDEn
    public function pesan($survey_id = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($survey_id == '') {
            return redirect()->to(base_url('surveytopik/all'));
        }
        $list =  $this->pertanyaan->listpertanyaan($survey_id);
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'     => 'Responden',
            'subtitle'  => 'Detail',
            'survey_id' => $survey_id,
            'list'      => $list,
            'folder'    => $tadmin['folder'],

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveypesan/index', $data);
    }

    // get data pesan-------
    public function getpesan()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $id_grup    = session()->get('id_grup');
        $url        = 'survey/all';
        $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);
        $akses      = $listgrupf->akses;
        $hapus      = $listgrupf->hapus;

        if ($this->request->isAJAX()) {
            $survey_id  = $this->request->getVar('survey_id');
            $list       =  $this->responden->listresponden($survey_id);

            if ($survey_id == '') {
                return redirect()->to(base_url('survey/all'));
            }

            $data = [
                'title'     => 'Pesan',
                'list'      => $list,
                'akses'     => $akses,
                'hapus'     => $hapus,

            ];
            $tadmin = $this->template->tempadminaktif();
            $msg = [
                'data'      => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveypesan/list', $data),
            ];

            echo json_encode($msg);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }


    public function hapusrespon()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('responden_id');
            $survey_id = $this->request->getVar('survey_id');
            $jpoin = $this->request->getVar('jpoin');
            $listtopik =  $this->surveytopik->find($survey_id);

            $updatedata = [
                'skor'  => $listtopik['skor'] - $jpoin,
            ];

            $this->surveytopik->update($survey_id, $updatedata);

            $this->responden->delete($id);
            $msg = [
                'sukses'                => 'Data responden berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }


    public function formpesan()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $survey_id = $this->request->getVar('survey_id');
            $list =  $this->surveytopik->find($survey_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Masukan Saran',
                'survey_id'     => $list['survey_id'],
                'nama_survey'   => $list['nama_survey'],
                'pesan'          => $list['pesan'],
                'nohp'          => $list['nohp'],
                'nama'          => $list['nama'],
                'folder'      => $tadmin['folder'],
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveypesan/index', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }


    // Detail pertayaan
    public function pertanyaan($survey_id = null)
    {
        if (!isset($survey_id)) return redirect()->to('berita');
        if (session()->get('id') == '') {
            // return redirect()->to('');
            return redirect()->to(base_url(''));
        }
        if ($survey_id == '') {
            return redirect()->to(base_url('surveytopik/all'));
        }
        $list =  $this->pertanyaan->listpertanyaan($survey_id);
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'     => 'Pertanyaan',
            'subtitle'  => 'Quisioner',
            'survey_id' => $survey_id,
            'list'      => $list,
            'folder'    => $tadmin['folder'],
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveypertanyaan/index', $data);
    }

    // get data
    public function getpertanyaan()
    {
        if ($this->request->isAJAX()) {
            $survey_id  = $this->request->getVar('survey_id');
            $list       =  $this->pertanyaan->listpertanyaan($survey_id);
            $tadmin = $this->template->tempadminaktif();
            $id_grup    = session()->get('id_grup');
            $url        = 'survey/all';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            if ($survey_id == '') {

                return redirect()->to(base_url('survey/all'));
            }

            $data = [
                'title'     => 'Managemen Pertanyaan',
                'list'      => $list,
                'akses'     => $akses,
                'hapus'     => $hapus,
                'ubah'      => $ubah,
                'tambah'    => $tambah,
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveypertanyaan/list', $data)

            ];

            echo json_encode($msg);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }

    public function formtambahpertanyaan()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'     => 'Tambah Pertanyaan',
                'survey_id' => $this->request->getVar('survey_id'),
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveypertanyaan/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanPertanyaan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'pertanyaan'  => [
                    'label'   => 'Pertanyaan',
                    'rules'   => 'required|is_unique[survey_pertanyaan.pertanyaan]',
                    'errors'  => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'pertanyaan'  => $validation->getError('pertanyaan'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'survey_id'    => $this->request->getVar('survey_id'),
                    'pertanyaan'   => $this->request->getVar('pertanyaan'),
                    'status'       => '1',
                ];

                $this->pertanyaan->insert($insertdata);

                $msg = [
                    'sukses'                => 'Data berhasil disimpan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            }
        }
    }

    public function formeditpertanyaan()
    {
        if ($this->request->isAJAX()) {

            $pertanyaan_id = $this->request->getVar('pertanyaan_id');

            $list =  $this->pertanyaan->find($pertanyaan_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Edit Pertanyaan',
                'pertanyaan_id'   => $pertanyaan_id,
                'pertanyaan' => $list['pertanyaan'],
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveypertanyaan/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatepertanyaan()
    {
        if ($this->request->isAJAX()) {
            $pertanyaan_id = $this->request->getVar('pertanyaan_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'pertanyaan' => [
                    'label' => 'Pertanyaan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'pertanyaan' => $validation->getError('pertanyaan'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $updatedata = [
                    'pertanyaan'  => $this->request->getVar('pertanyaan'),

                ];
                $this->pertanyaan->update($pertanyaan_id, $updatedata);
                $msg = [
                    'sukses' => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    //Hapus

    public function hapuspertanyaan()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pertanyaan_id');
            //check
            $this->pertanyaan->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapusperall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('pertanyaan_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {

                $this->pertanyaan->delete($id[$i]);
            }

            $msg = [
                'sukses' => "$jmldata Data berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    // end tanya & Start Jawab=====================================================


    public function jawaban($pertanyaan_id = null)
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($pertanyaan_id == '') {

            return redirect()->to(base_url('survey/all'));
        }
        $list =  $this->jawaban->listjawaban($pertanyaan_id);
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'         => 'Survei',
            'subtitle'      => 'Jawaban',
            'pertanyaan_id' => $pertanyaan_id,
            'list'          => $list,
            'folder'        => $tadmin['folder'],

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveyjawaban/index', $data);
    }

    // get datajawaban
    public function getjawaban()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $pertanyaan_id = $this->request->getVar('pertanyaan_id');
            $list       =  $this->jawaban->listjawaban($pertanyaan_id);
            $jjawab     = $this->jawaban->where('pertanyaan_id', $pertanyaan_id)->get()->getNumRows();
            $id_grup    = session()->get('id_grup');
            $url        = 'survey/all';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            if ($pertanyaan_id == '') {

                return redirect()->to(base_url('survey/all'));
            }
            $tadmin             = $this->template->tempadminaktif();
            $data = [
                'title'      => 'Management Jawaban',
                'list'       => $list,
                'jum'       => $jjawab,
                'akses'     => $akses,
                'hapus'     => $hapus,
                'ubah'      => $ubah,
                'tambah'    => $tambah,
            ];
            $msg = [

                'data' => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveyjawaban/list', $data)

            ];

            echo json_encode($msg);
        } else {
            return redirect()->to(base_url('dashboard'));
        }
    }


    public function formtambahjawaban()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $pertanyaan_id = $this->request->getVar('pertanyaan_id');
            $jjawab = $this->jawaban->where('pertanyaan_id', $pertanyaan_id)->get()->getNumRows();
            $data = [
                'title'                 => 'Tambah Jawaban',
                'pertanyaan_id'         => $pertanyaan_id,
                'jum'                   => $jjawab,
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            $tadmin   = $this->template->tempadminaktif();
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveyjawaban/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function simpanjawaban()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('pertanyaan_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'jawaban' => [
                    'label' => 'Jawaban',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'jawaban'  => $validation->getError('jawaban'),

                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $insertdata = [
                    'pertanyaan_id'    => $this->request->getVar('pertanyaan_id'),
                    'jawaban'           => $this->request->getVar('jawaban'),
                    'nilai'             => $this->request->getVar('nilai'),
                ];

                $this->jawaban->insert($insertdata);
                $msg = [
                    'sukses'                => 'Data berhasil disimpan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formeditjawaban()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $jawaban_id = $this->request->getVar('jawaban_id');

            $list =  $this->jawaban->find($jawaban_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Edit Data',
                'jawaban_id'    => $jawaban_id,
                'pertanyaan_id' => $list['pertanyaan_id'],
                'jawaban'       => $list['jawaban'],
                'nilai'         => $list['nilai'],
            ];
            $msg = [
                'csrf_tokencmsdatagoe'  => csrf_hash(),
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/surveytopik/surveyjawaban/edit', $data),
            ];
            echo json_encode($msg);
        }
    }


    public function updatejawaban()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $jawaban_id = $this->request->getVar('jawaban_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'jawaban' => [
                    'label' => 'Jawaban',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong.',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'jawaban' => $validation->getError('jawaban'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'jawaban'  => $this->request->getVar('jawaban'),
                    // 'nilai'  => $this->request->getVar('nilai'),

                ];

                $this->jawaban->update($jawaban_id, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapusjawaban()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('jawaban_id');

            $this->jawaban->delete($id);
            $msg = [
                'sukses'                => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapusjwball()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('jawaban_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check

                $this->jawaban->delete($id[$i]);
            }

            $msg = [
                'sukses'                => "$jmldata Data berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    // publik
    public function isisurvei()
    {

        if ($this->request->isAJAX()) {

            if (get_cookie("survei") != 'cossi') {
                $validation = \Config\Services::validation();
                $valid = $this->validate([
                    'jawaban_id' => [
                        'label' => 'Pilihan',
                        'rules' => 'required',
                        'errors' => [
                            'required' => '{field} tidak boleh kosong',
                        ]
                    ]
                ]);
                if (!$valid) {
                    $msg = [
                        'error' => [
                            'jawaban_id' => $validation->getError('jawaban_id'),
                        ],
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {
                    // $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                    // $secretkey = $konfigurasi['g_secretkey'];
                    // $g_sitekey = $konfigurasi['g_sitekey'];
                    // // gcaptcha
                    // $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));
                    // $secret = $secretkey;

                    $survey_id = $this->request->getVar('survey_id');
                    $nilai = $this->request->getVar('totalnil');

                    $listtopik =  $this->surveytopik->find($survey_id);
                    $data = [
                        'skor'        => $listtopik['skor'] + $nilai
                    ];
                    $this->surveytopik->update($survey_id, $data);


                    $updatedata = [
                        'hits'        => $listtopik['hits'] + 1,
                    ];

                    $this->surveytopik->update($survey_id, $updatedata);
                    $insertdata = [
                        'survey_id'   => $survey_id,
                        'saran'       => $this->request->getVar('saran'),
                        'nohp'       => $this->request->getVar('nohp'),
                        'nama'       => $this->request->getVar('nama'),
                        'jpoin'       => $nilai,
                        'tanggal'     => date('Y-m-d'),
                    ];
                    $this->responden->insert($insertdata);
                    set_cookie("survei", "cossi", 7000);
                    $msg = [
                        'sukses'                => 'Terima kasih atas partisipasi Anda mengikuti survei kami.!',
                        'csrf_tokencmsdatagoe'  => csrf_hash()
                    ];
                }

                // jika sudah isi
            } else {
                $msg = [
                    'gagal'                => 'Anda telah berpartisipasi..!',
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            }
            echo json_encode($msg);
        }
    }
}
