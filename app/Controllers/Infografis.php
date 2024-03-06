<?php

namespace App\Controllers;

class Infografis extends BaseController
{
    public function index()
    {
        $konfigurasi        = $this->konfigurasi->vkonfig();
        $infografis = $this->banner->listinfopage();
        $template = $this->template->tempaktif();
        $data = [
            'title'         => 'Infografis | ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),
            'infografis'    => $infografis->paginate(6, 'hal'),
            'pager'         => $infografis->pager,
            'jum'           => $this->infografis->totinfografis(),
            'agenda'        => $this->agenda->listagendapage()->paginate(4),
            'foto'          => $this->foto->listfotopage()->paginate(6),
            'banner'        => $this->banner->list(),
            'beritaterkini' => $this->berita->terkini(),
            'beritapopuler' => $this->berita->populer()->paginate(6),
            'section'       => $this->section->list(),
            'linkterkaitall'    => $this->linkterkait->publishlinkall(),
            'infografis10'    => $this->banner->listinfopage()->paginate(10),
            'kategori'      => $this->kategori->list(),
            'folder'        => $template['folder']
        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/semua_infografis', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_infografis', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/semua_infografis', $data);
        }
    }

    public function all()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'        => 'Informasi',
            'subtitle'        => 'Info Grafis',
            'folder'        => $tadmin['folder']
        ];

        return view('backend/' . $tadmin['folder'] . '/' . 'setkonten/infografis/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup    = session()->get('id_grup');
            $url        = 'infografis/all';
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
                        'title'     => 'Info Grafis',
                        'list'      => $this->banner->listgrafis(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/infografis/list', $data)
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
                'title' => 'Tambah Info Grafis'
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/infografis/tambah', $data)
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
                    'label' => 'Keterangan Foto',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'banner_image' => [
                    'label' => 'Gambar Info Grafis',
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


                $filegambar = $this->request->getFile('banner_image');
                $nama_file = $filegambar->getRandomName();
                $insertdata = [
                    'ket'           => $this->request->getVar('ket'),
                    'banner_image'  => $nama_file,
                    'type'          => '1'
                ];

                $this->banner->insert($insertdata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit(800, 600, 'center')
                    ->save('public/img/informasi/infografis/thumb/' . 'thumb_' .  $nama_file, 65);

                $filegambar->move('public/img/informasi/infografis/', $nama_file); //folder gbr
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
        if ($this->request->isAJAX()) {
            $id_banner = $this->request->getVar('id_banner');
            $list =  $this->banner->find($id_banner);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title'       => 'Edit Info Grafis',
                'id_banner'   => $list['id_banner'],
                'ket'         => $list['ket'],
                'banner'      => $list['banner_image']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/infografis/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updateinfografis()
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
                ],
                'banner' => [
                    'label' => 'Banner',
                    'rules' => 'max_size[banner_image,1024]|mime_in[banner_image,image/png,image/jpg,image/jpeg,image/gif]|is_image[banner_image]',
                    'errors' => [

                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'ket' => $validation->getError('ket'),
                        'banner' => $validation->getError('banner')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $filegambar = $this->request->getFile('banner_image');
                $nama_file = $filegambar->getRandomName();
                //jika edit saja
                if ($filegambar->GetError() == 4) {
                    $data = [
                        'ket'   => $this->request->getVar('ket'),
                    ];

                    $this->banner->update($id_banner, $data);
                    $msg = [
                        'sukses'                => 'Data berhasil diubah!',
                        'csrf_tokencmsdatagoe'  => csrf_hash(),
                    ];
                } else {

                    //check
                    $cekdata = $this->banner->find($id_banner);
                    $fotolama = $cekdata['banner_image'];
                    if ($fotolama != 'default.png' && file_exists('public/img/informasi/infografis/' . $fotolama)) {
                        unlink('public/img/informasi/infografis/' . $fotolama);
                    }
                    if ($fotolama != 'default.png' && file_exists('public/img/informasi/infografis/thumb/' . 'thumb_' . $fotolama)) {
                        unlink('public/img/informasi/infografis/thumb/' . 'thumb_' . $fotolama);
                    }

                    $updatedata = [
                        'ket'   => $this->request->getVar('ket'),
                        'banner_image' => $nama_file
                    ];

                    $this->banner->update($id_banner, $updatedata);

                    \Config\Services::image()
                        ->withFile($filegambar)
                        ->fit(800, 600, 'center')
                        ->save('public/img/informasi/infografis/thumb/' . 'thumb_' .  $nama_file, 65);
                    $filegambar->move('public/img/informasi/infografis/', $nama_file); //folder gbr

                    $msg = [
                        'sukses'                => 'Info Grafis berhasil diganti!',
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

            $id_banner = $this->request->getVar('id_banner');
            //check
            $cekdata = $this->banner->find($id_banner);
            $fotolama = $cekdata['banner_image'];
            if ($fotolama != 'default.png' && file_exists('public/img/informasi/infografis/' . $fotolama)) {
                unlink('public/img/informasi/infografis/' . $fotolama);
            }
            if ($fotolama != 'default.png' && file_exists('public/img/informasi/infografis/thumb/' . 'thumb_' . $fotolama)) {
                unlink('public/img/informasi/infografis/thumb/' . 'thumb_' . $fotolama);
            }

            $this->banner->delete($id_banner);
            $msg = [
                'sukses'                => 'Data berhasil dihapus!',
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
                if ($fotolama != 'default.png' && file_exists('public/img/informasi/infografis/' . $fotolama)) {
                    unlink('public/img/informasi/infografis/' . $fotolama);
                }
                if ($fotolama != 'default.png' && file_exists('public/img/informasi/infografis/thumb/' . 'thumb_' . $fotolama)) {
                    unlink('public/img/informasi/infografis/thumb/' . 'thumb_' . $fotolama);
                }

                $this->banner->delete($id_banner[$i]);
            }

            $msg = [
                'sukses'                => "$jmldata Info Grafis berhasil dihapus",
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    //lihat info grafis front end

    public function formlihatinfo()
    {
        if ($this->request->isAJAX()) {
            $id_banner = $this->request->getVar('id_banner');
            $list =  $this->banner->find($id_banner);
            $tadmin = $this->template->tempadminaktif();

            $data = [
                'title'       => 'Info Grafis',
                'id_banner'   => $list['id_banner'],
                'ket'         => $list['ket'],
                'banner'      => $list['banner_image']
            ];
            $msg = [

                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'modal/v_infografis', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),

            ];
            echo json_encode($msg);
        }
    }
}
