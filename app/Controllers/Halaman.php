<?php

namespace App\Controllers;

class Halaman extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'       => 'Halaman',
            'subtitle'    => 'Statis',
            'folder'        => $tadmin['folder'],
            'csrf_tokencmsdatagoe'  => csrf_hash(),
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'setkonten/halaman/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {

            $id_grup = session()->get('id_grup');
            $urlget = 'halaman';
            $tadmin = $this->template->tempadminaktif();
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $urlget);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Halaman',
                        'list'      => 'cmsdatagoe',
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data'                  => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/halaman/list', $data),
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


    // Start Serverside

    public function listdata2()
    {

        $request    = \Config\Services::request();
        $list_data  = $this->berita;
        $id         = session()->get('id');
        $id_grup    = session()->get('id_grup');
        $urlget     = 'halaman';
        $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $urlget);

        $akses      = $listgrupf->akses;
        $hapus      = $listgrupf->hapus;
        $ubah       = $listgrupf->ubah;
        $tambah     = $listgrupf->tambah;

        if ($akses == '1') {

            $where = [
                'jenis_berita =' => 'Halaman'
            ];
        } elseif ($akses == '2') {
            $where = [
                'berita.id =' => $id,
                'jenis_berita =' => 'Halaman'
            ];
        }

        $column_order   = array(null, null, 'berita.judul_berita', null, null, null, null);
        $column_search  = array('berita.judul_berita', 'berita.tgl_berita');
        $order          = array('berita.berita_id' => 'DESC');
        $lists          = $list_data->get_datatables('berita', $column_order, $column_search, $order, $where);
        $data           = array();
        $no             = $request->getPost("start");
        foreach ($lists as $list) {
            $no++;

            if ($list->status == '1') {
                if ($ubah == '1') {
                    $sts = '<button type="button" class="btn btn-light btn-sm p-1" onclick="toggle(' . $list->berita_id . ')" title="Klik disini untuk Non Aktifkan"><i class="fa fa-check-circle text-success"></i></button>';
                } else {
                    $sts = '<button type="button" class="btn btn-light btn-sm p-1" title="Telah diterbitkan"><i class="fa fa-check-circle text-success"></i></button>';
                }
            } else {
                if ($ubah == '1') {
                    $sts = '<button type="button" class="btn btn-light btn-sm p-1" onclick="toggle(' . $list->berita_id . ')" title="Klik disini untuk Terbitkan"><i class="far fa-eye-slash text-danger"></i></button>';
                } else {
                    $sts = '<button type="button" class="btn btn-light btn-sm p-1" title="Non Aktif"><i class="far fa-eye-slash text-danger"></i></button>';
                }
            }

            if ($list->filepdf != '') {
                if ($ubah == '1') {
                    $judulberita = ' <i class="far fa-file-pdf text-danger pointer" onclick="gantipdf(' . $list->berita_id . ')" title="Ganti file PDF"></i> ' . $list->judul_berita . '<i class="far fa-trash-alt text-danger pointer" onclick="hapuspdf(' . $list->berita_id . ')" title="Hapus file PDF yang disematkan"></i>';
                } else {
                    // if del
                    if ($hapus == '1') {
                        $judulberita = ' <i class="far fa-file-pdf text-danger pointer" ></i> ' . $list->judul_berita .
                            '<i class="far fa-trash-alt text-danger pointer" onclick="hapuspdf(' . $list->berita_id . ')" title="Hapus file PDF yang disematkan"></i>';
                    } else {
                        // no del
                        $judulberita = ' <i class="far fa-file-pdf text-danger " ></i> ' . $list->judul_berita .
                            '';
                    }
                }
            } else {
                if ($tambah == '1') {
                    $judulberita = ' <i class="far fa-file-alt pointer pointer" onclick="gantipdf(' . $list->berita_id . ')" title="Tambahkan file PDF"></i> ' . $list->judul_berita . '';
                } else {
                    // no add
                    $judulberita = ' <i class="far fa-file-alt " ></i> ' . $list->judul_berita . '';
                }
            }

            $link1 = ' <i class="mdi mdi-link-variant"></i><a class="text-primary" target="_blank" href="' . base_url('/page/' . $list->slug_berita)  . ' ">page/' . esc($list->slug_berita) .  '</a>';
            if ($ubah == '1') {

                if ($list->gambar == 'default.png') {
                    $gambar = '<span class="badge badge-warning pointer" style="font-size:12px" onclick="gantifoto(' . $list->berita_id . ')" title="Tambahkan Cover" >No Cover </span>';
                } else {
                    $gambar = '<img src="' . base_url() . '/public/img/informasi/profil/' . $list->gambar . '" class="img-circle elevation-2 pointer p-0" width="60px" onclick="gantifoto(' . $list->berita_id . ')" title="Ganti cover" />';
                }

                $tedit = '<button type="button" class="btn btn-light btn-sm p-1" onclick="edit(' . $list->berita_id . ')"><i class="fa fa-edit text-warning"></i></button>';

                // no edit
            } else {
                if ($list->gambar == 'default.png') {
                    $gambar = '<span class="badge badge-warning pointer" style="font-size:12px" >No Cover </span>';
                } else {
                    $gambar = '<img src="' . base_url() . '/public/img/informasi/profil/' . $list->gambar . '" class="img-circle elevation-2 pointer p-0" width="60px"  />';
                }
                $tedit = '<button type="button" class="btn btn-light btn-sm p-1" ><i class="fa fa-edit text-secondary"></i></button>';
            }

            if ($ubah == '1') {
            } else {
            }

            if ($hapus == '1') {
                $thapus = '<button type="button" class="btn btn-light btn-sm p-1" onclick="hapus(' . $list->berita_id . ')"><i class="far fa-trash-alt text-danger"></i></button>';
            } else {
                $thapus = '<button type="button" class="btn btn-light btn-sm p-1"><i class="far fa-trash-alt text-secondary"></i></button>';
            }
            $row = [];
            $row[] = "<input type=\"checkbox\" name=\"berita_id[]\" class=\"centangBeritaid\" value=\"$list->berita_id\">";
            // $row[] = $no;
            $row[] = $gambar;
            $row[] = $judulberita;
            $row[] = $link1;
            $row[] = date_indo($list->tgl_berita);
            $row[] = $list->hits . " Kali";
            // $row[] = $sts;
            $row[] = $sts . " " . $tedit . " " . $thapus;
            $data[] = $row;
        }

        if ($akses == '1') {
            $total_count = $this->db->query("SELECT jenis_berita FROM `berita` WHERE `jenis_berita`='Halaman'")->getResult();
        } elseif ($akses == '2') {
            $total_count = $this->db->query(" SELECT jenis_berita,id FROM `berita` WHERE id='" . $id . "' AND `jenis_berita`='Halaman'")->getResult();
        }

        $output = array(
            "draw"              => $request->getPost("draw"),
            "recordsTotal"      => count($total_count),
            "recordsFiltered"   => count($total_count),
            "data"              => $data,

        );

        return json_encode($output);
    }

    //publish dan unpublish berita
    public function toggle()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $cari =  $this->berita->find($id);

            if ($cari['status'] == '1') {
                $list =  $this->berita->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->berita->update($id, $updatedata);
                $msg = [
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                    'sukses' => 'Berhasil nonaktifkan halaman!',
                ];
            } else {
                $list =  $this->berita->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->berita->update($id, $updatedata);
                $msg = [
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                    'sukses' => 'Berhasil mengaktifkan halaman!',
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
                'title' => 'Tambah Halaman',

            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/halaman/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }


    public function simpanHalaman()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'judul_berita' => [
                    'label' => 'Judul halaman',
                    'rules' => 'required|is_unique[berita.judul_berita]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

                'isi' => [
                    'label' => 'Isi halaman',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'gambar' => [
                    'label' => 'gambar halaman',
                    'rules' => 'max_size[gambar,2024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 2024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'judul_berita'  => $validation->getError('judul_berita'),
                        'isi'           => $validation->getError('isi'),
                        'gambar'       => $validation->getError('gambar'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $userid = session()->get('id');
                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();
                $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $ceksts = $konfigurasi['sts_posting'];
                // cek role halaman
                $id_grup = session()->get('id_grup');
                $urlget = 'halaman';
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

                //jika gambar tidak ada
                if ($filegambar->GetError() == 4) {

                    $insertdata = [

                        'judul_berita'  => $this->request->getVar('judul_berita'),
                        'slug_berita'   => mb_url_title($this->request->getVar('judul_berita'), '-', TRUE),
                        'isi'           => $this->request->getVar('isi'),
                        'status'        => $stspos,
                        'gambar'        => 'default.png',
                        'tgl_berita'    => date('Y-m-d'),
                        'id'            => $userid,
                        'jenis_berita'  => 'Halaman',
                        'hits'          => '0',
                        'kategori_id'   => '0',
                        'ket_foto'      => $this->request->getVar('ket_foto'),
                    ];

                    $this->berita->insert($insertdata);

                    $msg = [
                        'sukses' => 'Halaman berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {

                    $insertdata = [

                        'judul_berita'  => $this->request->getVar('judul_berita'),
                        'slug_berita'   => mb_url_title($this->request->getVar('judul_berita'), '-', TRUE),
                        'isi'           => $this->request->getVar('isi'),
                        'status'        => $stspos,
                        'gambar'        => $nama_file,
                        'tgl_berita'    => date('Y-m-d'),
                        'id'            => $userid,
                        'jenis_berita'  => 'Halaman',
                        'hits'          => '0',
                        'kategori_id'   => '0',
                        'ket_foto'      => $this->request->getVar('ket_foto'),
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
                        ->save('public/img/informasi/profil/' . $nama_file, 65);
                    $msg = [
                        'sukses' => 'Halaman berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                }
                echo json_encode($msg);
            }
        }
    }


    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('berita_id');
            //check
            $cekdata = $this->berita->find($id);

            $pdflama = $cekdata['filepdf'];
            $fotolama = $cekdata['gambar'];

            if ($pdflama != '' && file_exists('public/img/informasi/pdf/' . $pdflama)) {
                unlink('public/img/informasi/pdf/' . $pdflama);
            }

            if ($fotolama != 'default.png' && file_exists('public/img/informasi/profil/' . $fotolama)) {
                unlink('public/img/informasi/profil/' . $fotolama);
            }

            $this->berita->delete($id);
            $msg = [
                'sukses' => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapuspdf()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('berita_id');
            //check
            $cekdata = $this->berita->find($id);
            $pdflama = $cekdata['filepdf'];

            if ($pdflama != '' && file_exists('public/img/informasi/pdf/' . $pdflama)) {
                unlink('public/img/informasi/pdf/' . $pdflama);
            }

            $updatedata = [
                'filepdf'           => ''
            ];

            $this->berita->update($id, $updatedata);

            $msg = [
                'sukses'                => 'Data PDF yang disematkan sukses Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }


    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('berita_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->berita->find($id[$i]);

                $pdflama = $cekdata['filepdf'];
                $fotolama = $cekdata['gambar'];

                if ($pdflama != '' && file_exists('public/img/informasi/pdf/' . $pdflama)) {
                    unlink('public/img/informasi/pdf/' . $pdflama);
                }

                if ($fotolama != 'default.png' && file_exists('public/img/informasi/profil/' . $fotolama)) {
                    unlink('public/img/informasi/profil/' . $fotolama);
                }
                $this->berita->delete($id[$i]);
            }

            $msg = [
                'sukses'                => "$jmldata Data berita berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $berita_id = $this->request->getVar('berita_id');
            $list =  $this->berita->find($berita_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'          => 'Edit Halaman',
                'berita_id'      => $list['berita_id'],
                'judul_berita'   => $list['judul_berita'],
                'isi'            => $list['isi'],
                'filepdf'        => $list['filepdf'],
                'ket_foto'       => $list['ket_foto'],


            ];
            $msg = [
                'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/halaman/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updateprofil()
    {
        if ($this->request->isAJAX()) {
            $berita_id = $this->request->getVar('berita_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'judul_berita' => [
                    'label' => 'Judul halaman',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'isi' => [
                    'label' => 'Isi Halaman',
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
                        'isi'       => $validation->getError('isi')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [
                    'judul_berita'  => $this->request->getVar('judul_berita'),
                    'slug_berita'   => mb_url_title($this->request->getVar('judul_berita'), '-', TRUE),
                    'isi'           => $this->request->getVar('isi'),
                    'ket_foto'      => $this->request->getVar('ket_foto'),

                ];

                $this->berita->update($berita_id, $updatedata);

                $msg = [
                    'sukses' => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    // gnti pdf
    public function formgantipdf()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('berita_id');
            $list =  $this->berita->find($id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'       => 'Upload File PDF',
                'id'          => $list['berita_id'],
                'filepdf'   => $list['filepdf']

            ];
            $msg = [
                'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/halaman/gantipdf', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }


    public function douploadpdf()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('berita_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'filepdf' => [
                    'label' => 'File PDF',
                    'rules' => [
                        'uploaded[filepdf]',
                        'mime_in[filepdf,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[filepdf,5096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal 5096 KB..!!',
                        'mime_in' => 'Format file harus PDF..!!'
                    ]
                ]


            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'filepdf' => $validation->getError('filepdf')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check
                $cekdata = $this->berita->find($id);
                $pdflama = $cekdata['filepdf'];
                if ($pdflama != '' && file_exists('public/img/informasi/pdf/' . $pdflama)) {
                    unlink('public/img/informasi/pdf/' . $pdflama);
                }

                $filepdf = $this->request->getFile('filepdf');
                $nama_file = $filepdf->getRandomName();

                // $filepdf->move('public/img/informasi/pdf/', $nama_file); //folder foto
                if ($filepdf->isValid() && !$filepdf->hasMoved()) {

                    $filepdf->move(ROOTPATH . 'public/img/informasi/pdf/', $nama_file);
                    $updatedata = [
                        'filepdf' => $nama_file
                    ];

                    $this->berita->update($id, $updatedata);
                }

                $msg = [
                    'sukses' => 'File PDF berhasil diupdate!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }



    public function formgantifoto()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('berita_id');
            $list =  $this->berita->find($id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'       => 'Ganti Cover',
                'id'          => $list['berita_id'],
                'gambar'   => $list['gambar'],
                'csrf_tokencmsdatagoe'  => csrf_hash(),

            ];
            $msg = [
                'csrf_tokencmsdatagoe'  => csrf_hash(),
                'sukses' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/halaman/gantifoto', $data),
            ];
            echo json_encode($msg);
        }
    }

    public function douploadBerita()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('berita_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Cover halaman',
                    'rules' => 'uploaded[gambar]|max_size[gambar,2024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
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
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check
                $cekdata = $this->berita->find($id);
                $fotolama = $cekdata['gambar'];

                if ($fotolama != 'default.png' && file_exists('public/img/informasi/profil/' . $fotolama)) {
                    unlink('public/img/informasi/profil/' . $fotolama);
                }

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'gambar' => $nama_file
                ];

                if ($filegambar->isValid() && !$filegambar->hasMoved()) {

                    $filegambar->move(ROOTPATH . 'public/img/informasi/profil/', $nama_file);
                    $updatedata = [
                        'gambar' => $nama_file
                    ];

                    $this->berita->update($id, $updatedata);
                }


                $msg = [
                    'sukses' => 'Cover berhasil diganti!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    //Detail Halaman

    public function detail($slug_berita = null)
    {
        if (!isset($slug_berita)) return redirect()->to('/');
        // $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $konfigurasi         = $this->konfigurasi->vkonfig();
        $berita = $this->berita->detail_halaman($slug_berita);
        $template = $this->template->tempaktif();
        $kategori = $this->kategori->list();
        if ($berita) {

            // Update hits
            $data = [
                'hits'        => $berita->hits + 1
            ];
            $this->berita->update($berita->berita_id, $data);

            $data = [
                'title'          => $berita->judul_berita,
                'deskripsi'      => $berita->ringkasan,
                'url'            => base_url('page/' . $berita->slug_berita),
                'img'            => base_url('/public/img/informasi/profil/' . $berita->gambar),
                'konfigurasi'    => $konfigurasi,
                'berita'         => $berita,
                'beritapopuler'  => $this->berita->populer()->paginate(8),
                'populer3'       => $this->berita->populer()->paginate(3),
                'terkini3'       => $this->berita->terkini3(),
                'kategori'       => $kategori,
                'mainmenu'       => $this->menu->mainmenu(),
                'footer'         => $this->menu->footermenu(),
                'topmenu'        => $this->menu->topmenu(),
                'banner'         => $this->banner->list(),
                'infografis'     => $this->banner->listinfo(),
                'infografis1'    => $this->banner->listinfo1(),
                'agenda'         => $this->agenda->listagendapage()->paginate(4),
                'pengumuman'     => $this->pengumuman->listpengumumanpage()->paginate(10),
                'linkterkaitall' => $this->linkterkait->publishlinkall(),
                'iklankanan1'    => $this->banner->listiklankanan1(),
                'folder'         => $template['folder']

            ];

            if ($template['duatema'] == 1) {
                $agent = $this->request->getUserAgent();
                if ($agent->isMobile()) {
                    return view('frontend/' . $template['folder'] . '/mobile/' . 'content/detailhalaman', $data);
                } else {
                    return view('frontend/' . $template['folder'] . '/desktop/' . 'content/detailhalaman', $data);
                }
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/detailhalaman', $data);
            }
        } else {
            return redirect()->to('/');
        }
    }
}
