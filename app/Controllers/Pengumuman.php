<?php

namespace App\Controllers;

class Pengumuman extends BaseController
{
    public function index()
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $pengumuman = $this->pengumuman->listpengumumanpage();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Pengumuman | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'pengumuman'    => $pengumuman->paginate(6, 'hal'),
            'pager'         => $pengumuman->pager,
            'jum'           => $this->pengumuman->totpengumuman(),
            'banner'        => $this->banner->list(),
            'infografis'    => $this->banner->listinfo(),
            'infografis1'   => $this->banner->listinfo1(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'beritapopuler' => $this->berita->populer()->paginate(8),
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
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/semua_pengumuman', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_pengumuman', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_pengumuman', $data);
        }
    }

    //list semua pengumuman
    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'        => 'Informasi',
            'subtitle'    => 'Pengumuman',
            'folder'    =>  $tadmin['folder'],

        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'informasi/pengumuman/index', $data);
    }


    public function getdata($id = null)
    {
        if ($this->request->isAJAX()) {
            $id_grup     = session()->get('id_grup');
            $id          = session()->get('id');
            $url         = 'pengumuman/all';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;

            if ($akses == 1) {
                $list =  $this->pengumuman->listpengumuman();
            } elseif ($akses == 2) {
                $list = $this->pengumuman->listpengumumanauthor($id);
            }
            $tadmin = $this->template->tempadminaktif();
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Pengumuman',
                        'list'      => $list,
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/pengumuman/list', $data)

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
                'title'                 => 'Tambah Pengumuman',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'informasi/pengumuman/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }
    public function simpanPengumuman()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Pengumuman',
                    'rules' => 'required|is_unique[informasi.nama]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

                'isi_informasi' => [
                    'label' => 'Deskripsi Pengumuman',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'gambar' => [
                    'label' => 'cover pengumuman',
                    'rules' => 'max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        // 'uploaded' => 'Silahkan Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'           => $validation->getError('nama'),
                        'isi_informasi'  => $validation->getError('isi_informasi'),
                        'gambar'       => $validation->getError('gambar')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $userid = session()->get('id');
                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                //jika gambar tidak ada
                if ($filegambar->GetError() == 4) {

                    $insertdata = [
                        'nama'  => $this->request->getVar('nama'),
                        'slug_informasi'   => mb_url_title($this->request->getVar('nama'), '-', TRUE),
                        'isi_informasi'   => $this->request->getVar('isi_informasi'),
                        'tgl_informasi'    => date('Y-m-d'),
                        'gambar'        => 'default.png',
                        'id'            => $userid,
                        'type'            => '1',
                        'hits'            => '0'
                    ];
                    $this->pengumuman->insert($insertdata);
                    $msg = [
                        'sukses'                => 'Pengumuman berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {

                    $insertdata = [
                        'nama'  => $this->request->getVar('nama'),
                        'slug_informasi'   => mb_url_title($this->request->getVar('nama'), '-', TRUE),
                        'isi_informasi'   => $this->request->getVar('isi_informasi'),
                        'tgl_informasi'    => date('Y-m-d'),
                        'gambar'        => $nama_file,
                        'id'            => $userid,
                        'type'            => '1',
                        'hits'            => '0'
                    ];

                    $this->pengumuman->insert($insertdata);
                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/informasi/pengumuman/' . $nama_file, 70);


                    $msg = [
                        'sukses'                => 'Pengumuman berhasil disimpan!',
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

            $id = $this->request->getVar('informasi_id');
            //check
            $cekdata = $this->pengumuman->find($id);
            $fotolama = $cekdata['gambar'];
            $filelama = $cekdata['fileunduh'];

            if ($fotolama != 'default.png' && file_exists('public/img/informasi/pengumuman/' . $fotolama)) {
                unlink('public/img/informasi/pengumuman/' . $fotolama);
            }
            if ($filelama != '' && file_exists('public/unduh/pengumuman/' . $filelama)) {
                unlink('public/unduh/pengumuman/' . $filelama);
            }

            $this->pengumuman->delete($id);
            $msg = [
                'sukses' => 'Data Pengumuman Berhasil Dihapus'
            ];

            echo json_encode($msg);
        }
    }

    public function hapusfile()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('informasi_id');
            //check
            $cekdata = $this->pengumuman->find($id);
            $filelama = $cekdata['fileunduh'];


            if ($filelama != '' && file_exists('public/unduh/pengumuman/' . $filelama)) {
                unlink('public/unduh/pengumuman/' . $filelama);
            }

            $updatedata = [
                'fileunduh'           => ''
            ];

            $this->pengumuman->update($id, $updatedata);

            $msg = [
                'sukses'                => 'Data file yang disematkan sukses Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }


    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('informasi_id');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check gbr
                $cekdata = $this->pengumuman->find($id[$i]);
                $fotolama = $cekdata['gambar'];
                $filelama = $cekdata['fileunduh'];

                if ($fotolama != 'default.png' && file_exists('public/img/informasi/pengumuman/' . $fotolama)) {
                    unlink('public/img/informasi/pengumuman/' . $fotolama);
                }
                if ($filelama != '' && file_exists('public/unduh/pengumuman/' . $filelama)) {
                    unlink('public/unduh/pengumuman/' . $filelama);
                }

                $this->pengumuman->delete($id[$i]);
            }

            $msg = [
                'sukses'                => "$jmldata Data pengumuman berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $informasi_id = $this->request->getVar('informasi_id');
            $list =  $this->pengumuman->find($informasi_id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'          => 'Edit Pengumuman',
                'informasi_id'   => $list['informasi_id'],
                'nama'           => $list['nama'],
                'isi_informasi'  => $list['isi_informasi']

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'informasi/pengumuman/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatepengumuman()
    {
        if ($this->request->isAJAX()) {
            $informasi_id = $this->request->getVar('informasi_id');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama' => [
                    'label' => 'Pengumuman',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],

                'isi_informasi' => [
                    'label' => 'Deskripsi Pengumuman',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama'           => $validation->getError('nama'),
                        'isi_informasi'     => $validation->getError('isi_informasi'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $updatedata = [

                    'nama'          => $this->request->getVar('nama'),
                    'slug_informasi'   => mb_url_title($this->request->getVar('nama'), '-', TRUE),
                    'isi_informasi'   => $this->request->getVar('isi_informasi'),
                ];
                $this->pengumuman->update($informasi_id, $updatedata);
                $msg = [
                    'sukses'                => 'Data pengumuman berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formgantifoto()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('informasi_id');
            $list =  $this->pengumuman->find($id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'    => 'Ganti Cover',
                'id'       => $list['informasi_id'],
                'gambar'   => $list['gambar']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'informasi/pengumuman/gantifoto', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function douploadPengumuman()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('informasi_id');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Cover',
                    'rules' => 'uploaded[gambar]|max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
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
                $cekdata = $this->pengumuman->find($id);
                $fotolama = $cekdata['gambar'];

                if ($fotolama != 'default.png' && file_exists('public/img/informasi/pengumuman/' . $fotolama)) {
                    unlink('public/img/informasi/pengumuman/' . $fotolama);
                }


                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'gambar' => $nama_file
                ];

                $this->pengumuman->update($id, $updatedata);
                \Config\Services::image()
                    ->withFile($filegambar)
                    ->save('public/img/informasi/pengumuman/' . $nama_file, 70);

                $msg = [
                    'sukses' => 'Cover berhasil diganti!',
                ];
            }
            echo json_encode($msg);
        }
    }

    //Upload file
    public function formuploadfile()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('informasi_id');
            $list =  $this->pengumuman->find($id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'       => 'File Unduhan',
                'id'          => $list['informasi_id'],
                'gambar'      => $list['gambar'],
                'fileunduh'   => $list['fileunduh']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'informasi/pengumuman/uploadfile', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    //simpan fileunduh
    public function douploadFileUnduh()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('informasi_id');
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'fileunduh' => [
                    'label' => 'File unduhan',
                    'rules' => [
                        'uploaded[fileunduh]',
                        'mime_in[fileunduh,image/jpg,image/jpeg,image/gif,image/png,application/pdf,application/doc,application/docx,application/xls,application/xlsx,application/ppt,application/pptx,text/plain,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
                        'max_size[fileunduh,2096]',
                    ],
                    'errors' => [
                        'uploaded' => 'Silahkan Masukkan file',
                        'max_size' => 'Ukuran {field} Maksimal 2096 KB..!!',
                        'mime_in' => 'Format {field} tidak valid..!!'
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'fileunduh' => $validation->getError('fileunduh')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check
                $cekdata = $this->pengumuman->find($id);
                $filelama = $cekdata['fileunduh'];

                if ($filelama != '' && file_exists('public/unduh/pengumuman/' . $filelama)) {
                    unlink('public/unduh/pengumuman/' . $filelama);
                }

                $fileunduhan = $this->request->getFile('fileunduh');
                $nama_file = $fileunduhan->getRandomName();

                if ($fileunduhan->isValid() && !$fileunduhan->hasMoved()) {

                    $fileunduhan->move(ROOTPATH . 'public/unduh/pengumuman/', $nama_file);
                    $updatedata = [
                        'fileunduh' => $nama_file
                    ];
                    $this->pengumuman->update($id, $updatedata);
                }

                $msg = [
                    'sukses' => 'File berhasil diupload!',
                ];
            }
            echo json_encode($msg);
        }
    }

    //lihat detail pengumuman front end
    public function formlihatpengumuman()
    {
        if ($this->request->isAJAX()) {
            $informasi_id = $this->request->getVar('informasi_id');
            $list =  $this->pengumuman->find($informasi_id);
            // $template = $this->template->tempaktif();
            $tadmin = $this->template->tempadminaktif();
            // Update hits
            $data = [
                'hits'        => $list['hits'] + 1
            ];
            $this->pengumuman->update($list['informasi_id'], $data);

            $data = [
                'title'          => 'Detail Pengumuman',
                'informasi_id'   => $list['informasi_id'],
                'nama'           => $list['nama'],
                'isi_informasi'  => $list['isi_informasi'],
                'tgl_informasi'  => $list['tgl_informasi'],
                'gambar'         => $list['gambar'],
                'fileunduh'       => $list['fileunduh'],
                // 'folder'          => $template['folder']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'modal/v_pengumuman', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),

            ];
            echo json_encode($msg);
        }
    }
}
