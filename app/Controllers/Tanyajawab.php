<?php

namespace App\Controllers;

class Tanyajawab extends BaseController
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
            'title'         => 'Bantuan | ' . $konfigurasi->nama,
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
            'faq'       =>  $this->faqtanya->listpublish(),

            'folder'        => $template['folder']

        ];
        return view('' . $template['folder'] . '/' . 'content/bantuan', $data);
    }


    public function detail()
    {

        $konfigurasi    = $this->konfigurasi->vkonfig();
        $kategori = $this->kategori->list();
        $agenda = $this->agenda->listagendapage();
        $surveytopik = $this->surveytopik->listsurveytopikpg();
        $pengumuman = $this->pengumuman->listpengumumanpage();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Bantuan | ' . $konfigurasi->nama,
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
            'faq'       =>  $this->faqtanya->listpublish(),

            'folder'        => $template['folder']

        ];
        return view('' . $template['folder'] . '/' . 'content/detailtiket', $data);
    }

    public function list()
    {
        $tadmin = $this->template->tempadminaktif();
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();

        $data = [
            'title'         => 'Tanya Jawab ',
            'subtitle'      => $konfigurasi['nama'],
            'folder'        => $tadmin['folder']
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'setkonten/faqtanya/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');

            $url        = 'tanyajawab/list';
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
                        'title'     => 'Tanya Jawab',
                        'list'      => $this->faqtanya->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/faqtanya/list', $data)
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
                'title' => 'Tambah Pertanyaan',
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/faqtanya/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpanfaqtanya()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'faqtanya' => [
                    'label' => 'Pertanyaan',
                    'rules' => 'required|is_unique[faq_tanya.faqtanya]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'faqtanya'    => $validation->getError('faqtanya'),

                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $insertdata = [
                    'faqtanya'  => $this->request->getVar('faqtanya'),
                    'sts_faqtanya'       => '1',
                    // 'id'           => session()->get('id')

                ];
                $this->faqtanya->insert($insertdata);
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

            $id = $this->request->getVar('faq_tanyaid');

            $this->faqtanya->delete($id);
            $msg = [
                'sukses'                => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('faq_tanyaid');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check

                $this->faqtanya->delete($id[$i]);
            }

            $msg = [
                'sukses'                => "$jmldata Data berhasil dihapus",
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

            $faq_tanyaid = $this->request->getVar('faq_tanyaid');
            $list =  $this->faqtanya->find($faq_tanyaid);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Edit Pertanyaan',
                'faq_tanyaid'     => $list['faq_tanyaid'],
                'faqtanya'   => $list['faqtanya'],

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/faqtanya/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatefaqtanya()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $faq_tanyaid = $this->request->getVar('faq_tanyaid');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'faqtanya' => [
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
                        'faqtanya'    => $validation->getError('faqtanya'),

                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'faqtanya'     => $this->request->getVar('faqtanya'),
                ];
                $this->faqtanya->update($faq_tanyaid, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    // end tanya & Start Jawab=====================================================

    public function jawaban($faq_tanyaid = null)
    {

        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($faq_tanyaid == '') {
            return redirect()->to(base_url('tanyajawab'));
        }
        $list =  $this->faqjawab->listjawaban($faq_tanyaid);
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'         => 'Tanya Jawab',
            'subtitle'      => 'Jawaban',
            'faq_tanyaid'   => $faq_tanyaid,
            'list'          => $list,
            'folder'        => $tadmin['folder']

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'setkonten/faqtanya/faqjawab/index', $data);
    }

    // get datajawaban
    public function getjawaban()
    {
        if ($this->request->isAJAX()) {
            $faq_tanyaid    = $this->request->getVar('faq_tanyaid');
            $list           =  $this->faqjawab->listjawaban($faq_tanyaid);
            $tadmin         = $this->template->tempadminaktif();
            $id_grup        = session()->get('id_grup');

            $url        = 'tanyajawab/list';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            if ($faq_tanyaid == '') {

                return redirect()->to(base_url('tanyajawab'));
            }

            $data = [
                'title'      => 'Management Jawaban',
                'list'       => $list,
                'akses'     => $akses,
                'hapus'     => $hapus,
                'ubah'      => $ubah,
                'tambah'    => $tambah,
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/faqtanya/faqjawab/list', $data)
            ];

            echo json_encode($msg);
        } else {
            return redirect()->to(base_url('admin'));
        }
    }


    public function formtambahjawaban()
    {
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title' => 'Tambah Jawaban',
                'faq_tanyaid' => $this->request->getVar('faq_tanyaid'),
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/faqtanya/faqjawab/tambah', $data)
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

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'faq_jawaban' => [
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
                        'faq_jawaban'  => $validation->getError('faq_jawaban'),

                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $insertdata = [
                    'faq_tanyaid'    => $this->request->getVar('faq_tanyaid'),
                    'faq_jawaban'    => $this->request->getVar('faq_jawaban'),
                    'sts_jwb'    => '1',
                ];

                $this->faqjawab->insert($insertdata);
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

            $faq_jawabid = $this->request->getVar('faq_jawabid');
            $list =  $this->faqjawab->find($faq_jawabid);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'         => 'Edit Data',
                'faq_jawabid'    => $faq_jawabid,
                'faq_tanyaid'   => $list['faq_tanyaid'],
                'faq_jawaban' => $list['faq_jawaban'],

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/faqtanya/faqjawab/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
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
            $faq_jawabid = $this->request->getVar('faq_jawabid');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'faq_jawaban' => [
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
                        'faq_jawaban' => $validation->getError('faq_jawaban'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check
                $updatedata = [
                    'faq_jawaban'  => $this->request->getVar('faq_jawaban'),
                ];

                $this->faqjawab->update($faq_jawabid, $updatedata);
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
            $id = $this->request->getVar('faq_jawabid');

            $this->faqjawab->delete($id);
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
            $id = $this->request->getVar('faq_jawabid');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $this->faqjawab->delete($id[$i]);
            }
            $msg = [
                'sukses'                => "$jmldata Data berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }
}
