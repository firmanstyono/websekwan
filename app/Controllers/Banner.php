<?php

namespace App\Controllers;

class Banner extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'        => 'Setting',
            'subtitle'        => 'Banner',
            'folder'        => $tadmin['folder']

        ];

        return view('backend/' . $tadmin['folder'] . '/' . 'setkonten/banner/index', $data);
    }

    public function getdata()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id_grup    = session()->get('id_grup');
            $url        = 'banner';
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
                        'title'     => 'Banner',
                        'list'      => $this->banner->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,

                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/banner/list', $data)
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
                'title' => 'Tambah Banner',
                'kategori' => $this->kategori->list(),
                'halaman' => $this->berita->listhalaman(),
                'berita' => $this->berita->listberitabaner(),
                'modulpublic'       => $this->modulpublic->listaktif(),

            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/banner/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function uploadfoto()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ket' => [
                    'label' => 'Keterangan Banner',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'banner_image' => [
                    'label' => 'Gambar Banner',
                    'rules' => 'uploaded[banner_image]|max_size[banner_image,1024]|mime_in[banner_image,image/png,image/jpg,image/jpeg,image/gif]|is_image[banner_image]',
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
                        'ket'           => $validation->getError('ket'),
                        'banner_image'  => $validation->getError('banner_image')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                $template = $this->template->tempaktif();
                $lebar = $template['wlbanner'];
                $panjang = $template['hpbanner'];

                $filegambar = $this->request->getFile('banner_image');
                $nama_file = $filegambar->getRandomName();
                $insertdata = [
                    'ket'           => $this->request->getVar('ket'),
                    'link'          => $this->request->getVar('link'),
                    'banner_image'  => $nama_file,
                    'type'          => '0'
                ];

                $this->banner->insert($insertdata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit($lebar, $panjang, 'center')
                    ->save('public/img/banner/' .  $nama_file, 70);

                $msg = [
                    'sukses'                => 'Banner berhasil diupload!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function formedit()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id_banner = $this->request->getVar('id_banner');
            $list =  $this->banner->find($id_banner);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'             => 'Edit Banner',
                'id_banner'         => $list['id_banner'],
                'ket'               => $list['ket'],
                'link'              => $list['link'],
                'banner'            => $list['banner_image'],
                'kategori'          => $this->kategori->list(),
                'halaman'           => $this->berita->listhalaman(),
                'berita'            => $this->berita->listberitabaner(),
                'modulpublic'       => $this->modulpublic->listaktif(),
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/banner/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatebanner()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id_banner = $this->request->getVar('id_banner');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'ket' => [
                    'label' => 'Keterangan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'ket' => $validation->getError('ket'),

                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                echo json_encode($msg);
            } else {

                $data = [
                    'ket'   => $this->request->getVar('ket'),
                    'link'   => $this->request->getVar('link'),
                ];

                $this->banner->update($id_banner, $data);
                $msg = [
                    'sukses' => 'Data berhasil diubah!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];


                echo json_encode($msg);
            }
        }
    }

    public function formgantibanner()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id_banner = $this->request->getVar('id_banner');
            $list =  $this->banner->find($id_banner);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'       => 'Ganti Banner',
                'id_banner'   => $list['id_banner'],
                'banner_image'      => $list['banner_image']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/banner/gantibanner', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function douploadbanner()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id_banner = $this->request->getVar('id_banner');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'banner_image' => [
                    'label' => 'Upload Banner',
                    'rules' => 'uploaded[banner_image]|mime_in[banner_image,image/png,image/jpg,image/jpeg]|is_image[banner_image]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'banner_image' => $validation->getError('banner_image')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check

                $template = $this->template->tempaktif();
                $lebar = $template['wlbanner'];
                $panjang = $template['hpbanner'];

                $cekdata = $this->banner->find($id_banner);
                $fotolama = $cekdata['banner_image'];
                if ($fotolama != '' && file_exists('public/img/banner/' . $fotolama)) {
                    unlink('public/img/banner/' . $fotolama);
                }

                $filegambar = $this->request->getFile('banner_image');
                $nama_file = $filegambar->getRandomName();
                $updatedata = [
                    'banner_image'             => $nama_file,
                ];

                $this->banner->update($id_banner, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit($lebar, $panjang, 'center')
                    ->save('public/img/banner/' .  $nama_file, 70);

                $msg = [
                    'sukses' => 'Banner berhasil diganti!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }


    public function hapus()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $id_banner = $this->request->getVar('id_banner');
            //check
            $cekdata = $this->banner->find($id_banner);
            $fotolama = $cekdata['banner_image'];
            if ($fotolama != '' && file_exists('public/img/banner/' . $fotolama)) {
                unlink('public/img/banner/' . $fotolama);
            }
            $this->banner->delete($id_banner);
            $msg = [
                'sukses'                 => 'Data berhasil dihapus!',
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
            $id_banner = $this->request->getVar('id_banner');
            $jmldata = count($id_banner);
            for ($i = 0; $i < $jmldata; $i++) {
                //check
                $cekdata = $this->banner->find($id_banner[$i]);
                $fotolama = $cekdata['banner_image'];
                if ($fotolama != '' && file_exists('public/img/banner/' . $fotolama)) {
                    unlink('public/img/banner/' . $fotolama);
                }

                $this->banner->delete($id_banner[$i]);
            }
            $msg = [
                'sukses'                => "$jmldata Banner berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }
}
