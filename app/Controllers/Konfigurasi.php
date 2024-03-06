<?php

namespace App\Controllers;

class Konfigurasi extends BaseController
{
    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $id_grup = session()->get('id_grup');
        $url = 'konfigurasi';
        $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
        $tadmin = $this->template->tempadminaktif();
        foreach ($listgrupf as $data) :
            $akses = $data['akses'];
        endforeach;
        // jika temukan maka eksekusi
        if ($listgrupf) {
            # cek akses
            $id_setaplikasi = 1;
            // $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
            $list =  $this->konfigurasi->find($id_setaplikasi);
            $template = $this->template->tempaktif();
            if ($akses == '1' || $akses == '2') {
                $data = [
                    'title'             => 'Dashboard',
                    'subtitle'          => 'PENGATURAN SITUS',
                    'konfigurasi'       => $this->konfigurasi->list(),
                    'id_setaplikasi'    => $list['id_setaplikasi'],
                    'nama'              => $list['nama'],
                    'alamat'            => $list['alamat'],
                    'no_telp'           => $list['no_telp'],
                    'google_map'        => $list['google_map'],
                    'kabupaten'         => $list['kabupaten'],
                    'provinsi'          => $list['provinsi'],
                    'website'           => $list['website'],
                    'email'             => $list['email'],
                    'deskripsi'         => $list['deskripsi'],
                    'logo'              => $list['logo'],
                    'sts_sambutan'      => $list['sts_sambutan'],
                    'icon'              => $list['icon'],
                    'link_gmap'         => $list['link_gmap'],
                    'sosmed_fb'         => $list['sosmed_fb'],
                    'sosmed_instagram'  => $list['sosmed_instagram'],
                    'sosmed_twiter'     => $list['sosmed_twiter'],
                    'sosmed_youtube'    => $list['sosmed_youtube'],
                    'kategori_id'       => $list['kategori_id'],
                    'mkategori'         => $this->kategori->list(),
                    'judul_section'     => $list['judul_section'],
                    'sts_section'       => $list['sts_section'],
                    'sts_modal'         => $list['sts_modal'],
                    'sts_rt'            => $list['sts_rt'],
                    'sts_count'         => $list['sts_count'],

                    'vercms'            => $list['vercms'],
                    'sts_regis'         => $list['sts_regis'],
                    'sts_web'           => $list['sts_web'],
                    'sts_posting'       => $list['sts_posting'],

                    'smtp_host'         => $list['smtp_host'],
                    'smtp_username'     => $list['smtp_username'],
                    'smtp_password'     => $list['smtp_password'],
                    'smtp_port'         => $list['smtp_port'],
                    'smtp_pengirim'     => $list['smtp_pengirim'],
                    'smtp_pesanbalas'   => $list['smtp_pesanbalas'],
                    'saveweb'           => session()->get('setweb'),
                    'konek_opd'         => $list['konek_opd'],
                    'id_grup'           => $list['id_grup'],
                    'footer_cms'        => $list['footer_cms'],
                    'listgrup'          => $this->grupuser->listgrups(),
                    'akses'             => $akses,
                    'katamutiara'       => $list['katamutiara'],
                    'tokenwa'           => $list['tokenwa'],
                    'no_waysender'      => $list['no_waysender'],
                    'wa_penerima'       => $list['wa_penerima'],
                    'namasingkat'       => $list['namasingkat'],
                    'urlserver'         => $list['urlserver'],
                    'g_secretkey'       => $list['g_secretkey'],
                    'g_sitekey'         => $list['g_sitekey'],
                    'csrf_tokencmsdatagoe' => csrf_hash(),
                    'folder'            => $tadmin['folder'],

                    'wllogo'            => $template['wllogo'],
                    'hplogo'            => $template['hplogo'],
                    'wlbanner'          => $template['wlbanner'],
                    'hpbanner'          => $template['hpbanner'],
                    'verbost'           => $template['verbost'],
                    'temaaktif'         => $template['nama'],
                    // 'ukuran_upload'     => $list['ukuran_upload'],
                ];
                return view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/konfigurasi/index', $data);
                // return view('admin/pengaturan/konfigurasi/konfigursasi', $data);
            } else {

                return redirect()->to(base_url('dasboard'));
            }
        } else {

            return redirect()->to(base_url('dasboard'));
        }
    }


    public function simpankonfig()
    {
        if (session()->get('id') == '') {
            return redirect()->to(base_url(''));
        }
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'nama' => [
                    'label' => 'Nama situs',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'deskripsi' => [
                    'label' => 'Deskripsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'no_telp' => [
                    'label' => 'no_telp',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'kabupaten' => [
                    'label' => 'kabupaten',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'provinsi' => [
                    'label' => 'provinsi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'website' => [
                    'label' => 'Alamat situs',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'google_map' => [
                    'label' => 'Google Map',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'alamat' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'link_gmap' => [
                    'label' => 'Link berbagi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'sosmed_fb' => [
                    'label' => 'Facebook',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'sosmed_instagram' => [
                    'label' => 'Instagram',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'sosmed_twiter' => [
                    'label' => 'Twitter',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'sosmed_youtube' => [
                    'label' => 'Youtube',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'judul_section' => [
                    'label' => 'Judul Section',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                // 'wllogo' => [
                //     'label' => 'Lebar Logo',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
                // 'hplogo' => [
                //     'label' => 'Tinggi Logo',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
                // 'wlbanner' => [
                //     'label' => 'Lebar Banner',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],
                // 'hpbanner' => [
                //     'label' => 'Panjang Banner',
                //     'rules' => 'required',
                //     'errors' => [
                //         'required' => '{field} tidak boleh kosong',
                //     ]
                // ],

            ]);
            if (!$valid) {

                $msg = [
                    'error' => [
                        'nama'        => $validation->getError('nama'),
                        'deskripsi'   => $validation->getError('deskripsi'),
                        'no_telp'     => $validation->getError('no_telp'),
                        'kabupaten'   => $validation->getError('kabupaten'),
                        'provinsi'    => $validation->getError('provinsi'),
                        'website'     => $validation->getError('website'),
                        'google_map'  => $validation->getError('google_map'),
                        'email'       => $validation->getError('email'),
                        'alamat'      => $validation->getError('alamat'),
                        'link_gmap'   => $validation->getError('link_gmap'),
                        'sosmed_fb'   => $validation->getError('sosmed_fb'),
                        'sosmed_instagram'   => $validation->getError('sosmed_instagram'),
                        'sosmed_twiter'   => $validation->getError('sosmed_twiter'),
                        'sosmed_youtube'   => $validation->getError('sosmed_youtube'),
                        'judul_section'   => $validation->getError('judul_section'),
                        // 'wllogo'        => $validation->getError('wllogo'),
                        // 'hplogo'        => $validation->getError('hplogo'),
                        // 'wlbanner'      => $validation->getError('wlbanner'),
                        // 'hpbanner'       => $validation->getError('hpbanner'),
                        // 'ukuran_upload'   => $validation->getError('ukuran_upload'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
                // echo json_encode($msg);
            } else {
                $id_setaplikasi  = $this->request->getVar('id_setaplikasi');
                $simpandata = [
                    'nama'          => $this->request->getVar('nama'),
                    'alamat'        => $this->request->getVar('alamat'),
                    'no_telp'       => $this->request->getVar('no_telp'),
                    'kabupaten'     => $this->request->getVar('kabupaten'),
                    'provinsi'      => $this->request->getVar('provinsi'),
                    'website'       => $this->request->getVar('website'),
                    'email'         => $this->request->getVar('email'),
                    'deskripsi'     => $this->request->getVar('deskripsi'),
                    'google_map'    => $this->request->getVar('google_map'),
                    'link_gmap'    => $this->request->getVar('link_gmap'),
                    'sosmed_fb'    => $this->request->getVar('sosmed_fb'),
                    'sosmed_instagram'    => $this->request->getVar('sosmed_instagram'),
                    'sosmed_twiter'    => $this->request->getVar('sosmed_twiter'),
                    'sosmed_youtube'    => $this->request->getVar('sosmed_youtube'),
                    'kategori_id'    => $this->request->getVar('kategori'),
                    'judul_section'    => $this->request->getVar('judul_section'),
                    'sts_section'    => $this->request->getVar('sts_section'),
                    'sts_modal'    => $this->request->getVar('sts_modal'),
                    'sts_rt'    => $this->request->getVar('sts_rt'),
                    'sts_count'    => $this->request->getVar('sts_count'),
                    // 'wllogo'    => $this->request->getVar('wllogo'),
                    // 'hplogo'    => $this->request->getVar('hplogo'),
                    // 'wlbanner'    => $this->request->getVar('wlbanner'),
                    // 'hpbanner'    => $this->request->getVar('hpbanner'),
                    // 'verbost'    => $this->request->getVar('verbost'),
                    'sts_regis'    => $this->request->getVar('sts_regis'),
                    'sts_posting'    => $this->request->getVar('sts_posting'),
                    'smtp_host'    => $this->request->getVar('smtp_host'),
                    'smtp_username'    => $this->request->getVar('smtp_username'),
                    'smtp_password'    => $this->request->getVar('smtp_password'),
                    'smtp_port'    => $this->request->getVar('smtp_port'),
                    'smtp_pengirim'    => $this->request->getVar('smtp_pengirim'),
                    'smtp_pesanbalas'    => $this->request->getVar('smtp_pesanbalas'),
                    'konek_opd'    => $this->request->getVar('konek_opd'),
                    'id_grup'       => $this->request->getVar('id_grup'),
                    'footer_cms'        => $this->request->getVar('footer_cms'),
                    'katamutiara'    => $this->request->getVar('katamutiara'),
                    'tokenwa'        => $this->request->getVar('tokenwa'),
                    'no_waysender'    => $this->request->getVar('no_waysender'),
                    'wa_penerima'    => $this->request->getVar('wa_penerima'),
                    'namasingkat'    => $this->request->getVar('namasingkat'),
                    'urlserver'    => $this->request->getVar('urlserver'),
                    'g_secretkey'    => $this->request->getVar('g_secretkey'),
                    'g_sitekey'    => $this->request->getVar('g_sitekey'),
                    // 'csrf_tokencmsdatagoe' => csrf_hash()
                    // 'ukuran_upload'    => $this->request->getVar('ukuran_upload'),

                ];
                $this->konfigurasi->update($id_setaplikasi, $simpandata);

                $msg = [
                    'sukses'                => 'Data berhasil diupdate',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }

    public function formuploadlogo()
    {
        if (session()->get('id') == '') {
            return redirect()->to(base_url(''));
        }
        if ($this->request->isAJAX()) {
            $tadmin = $this->template->tempadminaktif();
            $list =  $this->konfigurasi->orderBy('id_setaplikasi ')->first();
            $data = [
                'title'          => 'Ganti Logo Website',
                'logo'           => $list['logo'],
                'id_setaplikasi' => $list['id_setaplikasi']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/konfigurasi/uploadlogo', $data),
                'csrf_tokencmsdatagoe' => csrf_hash()
            ];
            echo json_encode($msg);
        }
    }

    public function douploadlogo()
    {
        if (session()->get('id') == '') {
            return redirect()->to(base_url(''));
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'logo' => [
                    'label' => 'Upload Logo',
                    'rules' => 'uploaded[logo]|mime_in[logo,image/png,image/jpg,image/jpeg]|is_image[logo]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar logo',
                        'mime_in' => 'Harus gambar!'
                    ],

                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'logo' => $validation->getError('logo'),

                    ],
                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {
                $id_setaplikasi = $this->request->getVar('id_setaplikasi');
                // $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $template = $this->template->tempaktif();

                $lebar = $template['wllogo'];
                $panjang = $template['hplogo'];

                //check
                $cekdata = $this->konfigurasi->find($id_setaplikasi);
                $fotolama = $cekdata['logo'];
                if ($fotolama != '' && file_exists('public/img/konfigurasi/logo/' . $fotolama)) {
                    unlink('public/img/konfigurasi/logo/' . $fotolama);
                }

                $filegambar = $this->request->getFile('logo');
                $nama_file = $filegambar->getRandomName();
                $updatedata = [
                    'logo'             => $nama_file,
                ];

                $this->konfigurasi->update($id_setaplikasi, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->fit($lebar, $panjang, 'center')
                    ->save('public/img/konfigurasi/logo/' .  $nama_file);

                $msg = [
                    'sukses'                => 'Logo berhasil diupload!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }


    public function formuploadicon()
    {
        if (session()->get('id') == '') {
            return redirect()->to(base_url(''));
        }
        if ($this->request->isAJAX()) {
            $id_setaplikasi = $this->request->getVar('id_setaplikasi');
            $list = $this->konfigurasi->find($id_setaplikasi);
            $tadmin = $this->template->tempadminaktif();
            $data = [
                'title' => 'Upload Icon Website',
                'list'  => $list,
                'id_setaplikasi' => $list['id_setaplikasi']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'pengaturan/konfigurasi/uploadicon', $data),
                'csrf_tokencmsdatagoe' => csrf_hash()
            ];
            echo json_encode($msg);
        }
    }

    public function douploadicon()
    {
        if (session()->get('id') == '') {
            return redirect()->to(base_url(''));
        }
        if ($this->request->isAJAX()) {

            $id_setaplikasi = $this->request->getVar('id_setaplikasi');

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'icon' => [
                    'label' => 'Upload Icon',
                    'rules' => 'uploaded[icon]|mime_in[icon,image/png,image/jpg,image/jpeg]|is_image[icon]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar',
                        'mime_in' => 'Harus gambar!'
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'icon' => $validation->getError('icon')
                    ],

                    'csrf_tokencmsdatagoe' => csrf_hash()
                ];
            } else {

                //check
                $cekdata = $this->konfigurasi->find($id_setaplikasi);
                $fotolama = $cekdata['icon'];
                if ($fotolama != '' && file_exists('public/img/konfigurasi/icon/' . $fotolama)) {
                    unlink('public/img/konfigurasi/icon/' . $fotolama);
                }

                $filegambar = $this->request->getFile('icon');
                $nama_file = $filegambar->getRandomName();

                $updatedata = [
                    'icon' => $nama_file,
                ];

                $this->konfigurasi->update($id_setaplikasi, $updatedata);

                \Config\Services::image()
                    ->withFile($filegambar)
                    ->save('public/img/konfigurasi/icon/' .  $nama_file);

                $msg = [
                    'sukses'                => 'Icon berhasil diupload!',
                    'csrf_tokencmsdatagoe'  => csrf_hash()
                ];
            }
            echo json_encode($msg);
        }
    }
}
