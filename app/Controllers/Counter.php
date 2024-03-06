<?php

namespace App\Controllers;

class Counter extends BaseController
{

    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin             = $this->template->tempadminaktif();
        $data = [
            'title'         => 'Counter',
            'subtitle'      => 'Data',
            'folder'      => $tadmin['folder'],
        ];
        return view('backend/' . $tadmin['folder'] . '/' . 'setkonten/counter/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup    = session()->get('id_grup');
            $url        = 'counter';
            $listgrupf  =  $this->grupakses->viewgrupakses($id_grup, $url);

            $akses  = $listgrupf->akses;
            $hapus  = $listgrupf->hapus;
            $ubah   = $listgrupf->ubah;
            $tambah = $listgrupf->tambah;
            // jika temukan maka eksekusi
            $tadmin             = $this->template->tempadminaktif();
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Counter Data',
                        'list'      => $this->counter->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah,
                        'tambah'    => $tambah,
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/counter/list', $data)
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

    // add menu
    public function formtambah()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'title'             => 'Tambah Counter',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            $tadmin             = $this->template->tempadminaktif();
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/counter/tambah', $data)
            ];
            echo json_encode($msg);
        }
    }

    public function simpan()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nm' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ],
                'jm' => [
                    'label' => 'Jumlah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ic' => [
                    'label' => 'Icon',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nm' => $validation->getError('nm'),
                        'ic' => $validation->getError('ic'),
                        'jm'    => $validation->getError('jm'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $simpandata = [
                    'nm'     => $this->request->getVar('nm'),
                    'jm'     => $this->request->getVar('jm'),
                    'ic'     => $this->request->getVar('ic'),
                    'sumber'  => $this->request->getVar('sumber'),
                    'link'   => $this->request->getVar('link'),
                    'bgc'   => $this->request->getVar('bgc'),

                ];

                $this->counter->insert($simpandata);
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
        if ($this->request->isAJAX()) {
            $id_counter = $this->request->getVar('id_counter');
            $list       =  $this->counter->find($id_counter);
            $tadmin             = $this->template->tempadminaktif();

            $data = [
                'title'             => 'Edit Counter',
                'id_counter'        => $id_counter,
                'nm'                => $list['nm'],
                'jm'                => $list['jm'],
                'ic'                => $list['ic'],
                'sumber'            => $list['sumber'],
                'link'              => $list['link'],
                'bgc'               => $list['bgc'],

            ];
            $msg = [

                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'setkonten/counter/edit', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function updatedata()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nm' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'jm' => [
                    'label' => 'Jumlah',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',

                    ]
                ],
                'ic' => [
                    'label' => 'Icon',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]

            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nm' => $validation->getError('nm'),
                        'ic' => $validation->getError('ic'),
                        'jm'    => $validation->getError('jm'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $updatedata = [

                    'nm'     => $this->request->getVar('nm'),
                    'jm'     => $this->request->getVar('jm'),
                    'ic'     => $this->request->getVar('ic'),
                    'sumber'  => $this->request->getVar('sumber'),
                    'link'   => $this->request->getVar('link'),
                    'bgc'   => $this->request->getVar('bgc'),


                ];

                $id_counter = $this->request->getVar('id_counter');
                $this->counter->update($id_counter, $updatedata);
                $msg = [
                    'sukses'                => 'Data berhasil diupdate',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id_counter = $this->request->getVar('id_counter');

            $this->counter->delete($id_counter);
            $msg = [
                'sukses'                => 'Data Berhasil Dihapus',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    //publish dan unpublish
    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getVar('id_counter');
            $cari =  $this->counter->find($id);

            if ($cari['sts'] == '1') {
                $list =  $this->counter->getaktif($id);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'sts'        => $toggle,
                ];
                $this->counter->update($id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil Non Aktifkan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->counter->getnonaktif($id);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'sts'        => $toggle,
                ];
                $this->counter->update($id, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil Mengaktifkan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }
}
