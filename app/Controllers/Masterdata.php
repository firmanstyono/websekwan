<?php

namespace App\Controllers;

class Masterdata extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin             = $this->template->tempadminaktif();
        $uri                = service('uri');
        $request            = $uri->getSegment(1);

        if ($request == 'm-caraperoleh_info') {
            $title  = 'Cara Memperoleh Informasi';
            $jns    = 1;
        } elseif ($request == 'm-pekerjaan') {
            $title  = 'List Pekerjaan';
            $jns    = 2;
        } elseif ($request == 'm-caradapat_info') {
            $title  = 'Cara Mendapatkan Informasi';
            $jns    = 3;
        }

        $data = [
            'title'       => 'Data',
            'subtitle'    => $title,
            'reqs'        => $request,
            'jns'         => $jns,
            'folder'      => $tadmin['folder']
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'cmscust/master/index', $data);
    }

    public function getdata()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $request =  $this->request->getVar('req');

            $id_grup = session()->get('id_grup');

            if ($request == 'm-caraperoleh_info') {
                $list = $this->masterdata->list1();
                $jns = 1;
                $url = 'm-caraperoleh_info';
            } elseif ($request == 'm-pekerjaan') {
                $list = $this->masterdata->list2();
                $jns = 2;
                $url = 'm-pekerjaan';
            } elseif ($request == 'm-caradapat_info') {
                $list = $this->masterdata->list3();
                $jns = 3;
                $url = 'm-caradapat_info';
            }

            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            $tadmin = $this->template->tempadminaktif();
            foreach ($listgrupf as $data) :
                $akses  = $data['akses'];
                $tambah = $data['tambah'];
                $ubah   = $data['ubah'];
                $hapus  = $data['hapus'];
            endforeach;

            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses

                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'list'          => $list,
                        'akses'         => $akses,
                        'tambah'        => $tambah,
                        'ubah'          => $ubah,
                        'hapus'         => $hapus,
                        'req'           => $request,
                        'jns'           => $jns
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'cmscust/master/list', $data)
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
            $request =  $this->request->getVar('req');
            $jns =  $this->request->getVar('jns');
            $data = [
                'title' => 'Tambah Data',
                'req'     => $request,
                'jns'     => $jns

            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'cmscust/master/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpandata()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_master' => [
                    'label' => 'Nama',
                    'rules' => 'required|is_unique[custome__masterdata.nama_master]',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                        'is_unique' => '{field} tidak boleh sama',
                    ]
                ],

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_master' => $validation->getError('nama_master'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $jns = $this->request->getVar('jns_master');

                $simpandata = [
                    'nama_master'   => $this->request->getVar('nama_master'),
                    'slug_master'   => mb_url_title($this->request->getVar('nama_master'), '-', TRUE),
                    'jns_master'    => $jns,
                    'sts_master'    => 1,

                ];

                $this->masterdata->insert($simpandata);
                $msg = [
                    'sukses'                => 'Data berhasil disimpan',
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
            $id_masterdata  = $this->request->getVar('id_masterdata');
            $request        =  $this->request->getVar('req');
            $list           =  $this->masterdata->find($id_masterdata);
            $tadmin         = $this->template->tempadminaktif();

            $data = [
                'title'         => 'Edit Data',
                'id_masterdata' => $list['id_masterdata'],
                'nama_master'   => $list['nama_master'],
                'req'           => $request
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'cmscust/master/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_master' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_master' => $validation->getError('nama_master'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $id_masterdata = $this->request->getVar('id_masterdata');

                $updatedata = [
                    'nama_master'   => $this->request->getVar('nama_master'),
                    'slug_master'   => mb_url_title($this->request->getVar('nama_master'), '-', TRUE),
                ];

                $this->masterdata->update($id_masterdata, $updatedata);

                $msg = [
                    'sukses'                => 'Data berhasil diupdate',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapusdata()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id_masterdata      = $this->request->getVar('id_masterdata');
            // cek
            $cekdata    = $this->masterdata->find($id_masterdata);
            $filelama   = $cekdata['image_master'];

            if ($filelama != '' && file_exists('public/img/calon/' . $filelama)) {
                unlink('public/img/calon/' . $filelama);
            }
            $this->masterdata->delete($id_masterdata);

            $msg = [
                'sukses'                => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }
    // upload foto calon
    public function formuploadfoto()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {
            $id         = $this->request->getVar('id_masterdata');
            $list       = $this->masterdata->find($id);
            $tadmin     = $this->template->tempadminaktif();
            $data = [
                'title'                 => 'Upload foto',
                'id'                    => $id,
                'image_master'          => $list['image_master'],
                'nama_master'           => $list['nama_master']
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'cmscust/master/gantifile', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function douploadfoto()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();

            $valid = $this->validate([
                'image_master' => [
                    'label' => 'Foto Profil',
                    'rules' => 'uploaded[image_master]|max_size[image_master,1024]|mime_in[image_master,image/png,image/jpg,image/jpeg,image/gif]|is_image[image_master]',
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
                        'image_master' => $validation->getError('image_master')
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {

                //check file lama
                $id         = $this->request->getVar('id_masterdata');
                $cekdata    = $this->masterdata->find($id);
                $filelama   = $cekdata['image_master'];

                if ($filelama != '' && file_exists('public/img/calon/' . $filelama)) {
                    unlink('public/img/calon/' . $filelama);
                }
                $filefoto           = $this->request->getFile('image_master');
                $nama_file          = $filefoto->getRandomName();
                $updatedata = [
                    'image_master' => $nama_file
                ];

                $this->masterdata->update($id, $updatedata);
                \Config\Services::image()
                    ->withFile($filefoto)
                    ->fit(215, 220, 'center')
                    ->save('public/img/calon/' . $nama_file);


                $msg = [
                    'sukses'                => 'File berhasil diupload!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }
}
