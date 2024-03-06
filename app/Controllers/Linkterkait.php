<?php

namespace App\Controllers;

class Linkterkait extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'        => 'Setting',
            'subtitle'    => 'Link Terkait',
            'folder'        => $tadmin['folder']
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'setkonten/linkterkait/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');

            $url        = 'linkterkait';
            $listgrupf  = $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            // jika temukan maka eksekusi
            $tadmin = $this->template->tempadminaktif();
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Link Terkait',
                        'list'      => $this->linkterkait->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,

                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/linkterkait/list', $data)

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

    //publish dan unpublish linkterkait
    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id');
            $cari =  $this->linkterkait->find($id);

            if ($cari['status'] == '1') {
                $list =  $this->linkterkait->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->linkterkait->update($id, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil nonaktifkan link terkait!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->linkterkait->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'status'        => $toggle,
                ];
                $this->linkterkait->update($id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil mengaktifkan link terkait!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
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
                'title' => 'Tambah Link Terkait',

            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/linkterkait/tambah', $data)

            ];
            echo json_encode($msg);
        }
    }

    public function simpanLink()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama_link' => [
                    'label' => 'Nama Link',
                    'rules' => 'required|is_unique[link_terkait.nama_link]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama'
                    ]
                ],

                'url' => [
                    'label' => 'Alamat URL',
                    'rules' => 'required|valid_url',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'valid_url' => '{field} tidak valid'
                    ]
                ],

                'gambar' => [
                    'label' => 'logo link terkait',
                    'rules' => 'max_size[gambar,1024]|mime_in[gambar,image/png,image/jpg,image/jpeg,image/gif]|is_image[gambar]',
                    'errors' => [

                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_link'  => $validation->getError('nama_link'),
                        'url'           => $validation->getError('url'),
                        'gambar'       => $validation->getError('gambar')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                //jika gambar tidak ada
                if ($filegambar->GetError() == 4) {

                    $insertdata = [

                        'nama_link'  => $this->request->getVar('nama_link'),
                        'url'           => $this->request->getVar('url'),
                        'status'        => '1',
                        'gambar'        => 'url.png'

                    ];

                    $this->linkterkait->insert($insertdata);

                    $msg = [
                        'sukses' => 'Link terkait berhasil disimpan!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {

                    $insertdata = [

                        'nama_link'  => $this->request->getVar('nama_link'),
                        'url'           => $this->request->getVar('url'),
                        'status'        => '1',
                        'gambar'        => $nama_file,

                    ];

                    $this->linkterkait->insert($insertdata);
                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->save('public/img/linkterkait/' .  $nama_file);
                    $msg = [
                        'sukses'                => 'Link terkait berhasil disimpan!',
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

            $id = $this->request->getVar('id_link');
            //check
            $cekdata = $this->linkterkait->find($id);
            $fotolama = $cekdata['gambar'];
            if ($fotolama != 'url.png' && file_exists('public/img/linkterkait/' . $fotolama)) {

                unlink('public/img/linkterkait/' . $fotolama);
            }
            $this->linkterkait->delete($id);
            $msg = [
                'sukses'                => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_link');
            $jmldata = count($id);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->linkterkait->find($id[$i]);
                $fotolama = $cekdata['gambar'];
                if ($fotolama != 'url.png' && file_exists('public/img/linkterkait/' . $fotolama)) {
                    unlink('public/img/linkterkait/' . $fotolama);
                }
                $this->linkterkait->delete($id[$i]);
            }

            $msg = [
                'sukses'                => "$jmldata Data link terkait berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $id_link = $this->request->getVar('id_link');
            $list =  $this->linkterkait->find($id_link);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'       => 'Edit Link Terkait',
                'id_link'     => $list['id_link'],
                'nama_link'   => $list['nama_link'],
                'url'         => $list['url']

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/linkterkait/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatelinkterkait()
    {
        if ($this->request->isAJAX()) {
            $id_link = $this->request->getVar('id_link');
            $validation = \Config\Services::validation();

            $valid = $this->validate([

                'nama_link' => [
                    'label' => 'Nama link',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

                'url' => [
                    'label' => 'Alamat URL',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_link'   => $validation->getError('nama_link'),
                        'url'       => $validation->getError('url')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $updatedata = [
                    'nama_link'  => $this->request->getVar('nama_link'),
                    'url'        => $this->request->getVar('url')
                ];

                $this->linkterkait->update($id_link, $updatedata);

                $msg = [
                    'sukses'                => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formgantifoto()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_link');
            $list =  $this->linkterkait->find($id);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'       => 'Ganti Logo',
                'id'          => $list['id_link'],
                'gambar'      => $list['gambar']

            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/linkterkait/gantifoto', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }


    public function douploadLink()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getVar('id_link');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'gambar' => [
                    'label' => 'Logo link',
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
                $cekdata = $this->linkterkait->find($id);
                $fotolama = $cekdata['gambar'];

                if ($fotolama != 'url.png' && file_exists('public/img/linkterkait/' . $fotolama)) {
                    unlink('public/img/linkterkait/' . $fotolama);
                }

                $filegambar = $this->request->getFile('gambar');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'gambar' => $nama_file
                ];

                $this->linkterkait->update($id, $updatedata);
                \Config\Services::image()
                    ->withFile($filegambar)
                    ->save('public/img/linkterkait/' .  $nama_file);

                $msg = [
                    'sukses'                => 'Logo link terkait berhasil diganti!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }
}
