<?php

namespace App\Controllers;

class Penawaran extends BaseController
{
    public function index()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $id_grup = session()->get('id_grup');
        $url = 'penawaran';
        $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);
        $tadmin = $this->template->tempadminaktif();
        foreach ($listgrupf as $data) :
            $akses = $data['akses'];
        endforeach;
        // jika temukan maka eksekusi
        if ($listgrupf) {
            # cek akses
            if ($akses == '1' || $akses == '2') {

                $list =  $this->modalpopup->orderBy('modalpopup_id ')->first();
                $data = [
                    'title'            => 'Setting',
                    'subtitle'         => 'Modal Popup',
                    'konfigurasi'      => $this->konfigurasi->list(),
                    'modalpopup_id'    => $list['modalpopup_id'],
                    'judultawaran'     => $list['judultawaran'],
                    'isitawaran'       => $list['isitawaran'],
                    'gbrtawaran'       => $list['gbrtawaran'],
                    'linktawaran'      => $list['linktawaran'],
                    'namatombol'       => $list['namatombol'],
                    'sts_tombol'       => $list['sts_tombol'],
                    'akses'            => $akses,
                    'csrf_tokencmsdatagoe' => csrf_hash(),
                    'folder'            => $tadmin['folder'],

                ];

                return view('backend/' . $tadmin['folder'] . '/' . 'modal/penawaran/penawaran', $data);
            } else {

                return redirect()->to(base_url('dashboard'));
            }
        } else {

            return redirect()->to(base_url('dashboard'));
        }
    }

    public function submit()
    {
        if (session()->get('id') == '') {
            return redirect()->to(base_url(''));
        }
        $id_grup = session()->get('id_grup');
        $url = 'penawaran';
        $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

        foreach ($listgrupf as $data) :
            $akses = $data['akses'];
        endforeach;
        // jika temukan maka eksekusi
        if ($listgrupf) {
            if ($akses == '1') {
                if ($this->request->isAJAX()) {
                    $validation = \Config\Services::validation();
                    $valid = $this->validate([
                        'judultawaran' => [
                            'label' => 'Judul Modal Popup',
                            'rules' => 'required',
                            'errors' => [
                                'required' => '{field} tidak boleh kosong',
                            ]
                        ],
                        'isitawaran' => [
                            'label' => 'Isi Modal Popup',
                            'rules' => 'required',
                            'errors' => [
                                'required' => '{field} tidak boleh kosong',
                            ]
                        ],
                        'linktawaran' => [
                            'label' => 'Link',
                            'rules' => 'required',
                            'errors' => [
                                'required' => '{field} tidak boleh kosong',
                            ]
                        ],
                        'namatombol' => [
                            'label' => 'Tombol Modal',
                            'rules' => 'required',
                            'errors' => [
                                'required' => '{field} tidak boleh kosong',
                            ]
                        ],
                    ]);
                    if (!$valid) {
                        $msg = [
                            'error' => [
                                'judultawaran'    => $validation->getError('judultawaran'),
                                'isitawaran'      => $validation->getError('isitawaran'),
                                'linktawaran'     => $validation->getError('linktawaran'),
                                'namatombol'      => $validation->getError('namatombol'),
                            ],
                            'csrf_tokencmsdatagoe'  => csrf_hash(),
                        ];
                    } else {
                        $modalpopup_id  = $this->request->getVar('modalpopup_id');
                        $simpandata = [
                            'judultawaran'        => $this->request->getVar('judultawaran'),
                            'isitawaran'          => $this->request->getVar('isitawaran'),
                            'linktawaran'         => $this->request->getVar('linktawaran'),
                            'namatombol'          => $this->request->getVar('namatombol'),
                            'sts_tombol'          => $this->request->getVar('sts_tombol'),

                        ];

                        $this->modalpopup->update($modalpopup_id, $simpandata);
                        $msg = [
                            'sukses' => 'Data berhasil diupdate',
                            'csrf_tokencmsdatagoe' => csrf_hash(),
                        ];
                    }
                    echo json_encode($msg);
                } else {
                    exit('404 Not Found');
                }
            } else {
                return redirect()->to(base_url(''));
            }
        } else {
            return redirect()->to(base_url(''));
        }
    }

    public function formuploadtawaran()
    {
        if (session()->get('id') == '') {
            return redirect()->to(base_url(''));
        }
        if ($this->request->isAJAX()) {
            $tadmin             = $this->template->tempadminaktif();
            $modalpopup_id      = $this->request->getVar('modalpopup_id');
            $list               = $this->modalpopup->find($modalpopup_id);

            $data = [
                'title'                 => 'Upload Gambar',
                'list'                  => $list,
                'modalpopup_id'         => $list['modalpopup_id'],
            ];
            $msg = [
                'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'modal/penawaran/uploadlogo', $data),
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];
            echo json_encode($msg);
        }
    }

    public function douploadlogo()
    {
        if (session()->get('id') == '') {
            return redirect()->to(base_url(''));
        }
        $id_grup = session()->get('id_grup');
        $url        = 'penawaran';
        $listgrupf  =  $this->grupakses->listgrupakses($id_grup, $url);

        foreach ($listgrupf as $data) :
            $akses = $data['akses'];
        endforeach;

        if ($this->request->isAJAX()) {
            // jika temukan maka eksekusi
            if ($listgrupf) {
                if ($akses == '1') {

                    $validation = \Config\Services::validation();
                    $valid = $this->validate([
                        'gbrtawaran' => [
                            'label' => 'Upload Gambar',
                            'rules' => 'uploaded[gbrtawaran]|mime_in[gbrtawaran,image/png,image/jpg,image/jpeg,image/gif]|is_image[gbrtawaran]',
                            'errors' => [
                                'uploaded' => 'Masukkan gambar',
                                'mime_in' => 'Harus gambar!'
                            ],

                        ]
                    ]);
                    if (!$valid) {
                        $msg = [
                            'error' => [
                                'gbrtawaran' => $validation->getError('gbrtawaran')
                            ],
                            'csrf_tokencmsdatagoe' => csrf_hash()
                        ];
                    } else {
                        //check
                        $modalpopup_id = $this->request->getVar('modalpopup_id');
                        $cekdata = $this->modalpopup->find($modalpopup_id);
                        $fotolama = $cekdata['gbrtawaran'];

                        if ($fotolama != 'default.png' && file_exists('public/img/informasi/' . $fotolama)) {
                            unlink('public/img/informasi/' . $fotolama);
                        }

                        $filegambar = $this->request->getFile('gbrtawaran');
                        $ext = $filegambar->getClientExtension();

                        if ($ext == 'php' || $ext == 'js' || $ext == 'htm' || $ext == 'html' || $ext == 'phtml' || $ext == 'fLA' || $ext == 'txt' || $ext == 'py' || $ext == 'exe') {
                            $msg = [
                                'nofile'                => 'File tidak diijinkan!',
                                'csrf_tokencmsdatagoe'  => csrf_hash(),
                            ];
                        } else {

                            $nama_file = $filegambar->getRandomName();
                            $updatedata = [
                                'gbrtawaran' => $nama_file,
                            ];

                            $this->modalpopup->update($modalpopup_id, $updatedata);
                            \Config\Services::image()
                                ->withFile($filegambar)
                                ->save('public/img/informasi/' .  $nama_file);
                            $msg = [
                                'sukses'                => 'Gambar berhasil diupload!',
                                'csrf_tokencmsdatagoe'  => csrf_hash(),
                            ];
                        }
                    }
                    echo json_encode($msg);
                } else {
                    return redirect()->to(base_url(''));
                }
            }
        } else {
            return redirect()->to(base_url(''));
        }
    }

    public function lihathasiladmin()
    {
        if ($this->request->isAJAX()) {
            $tadmin             = $this->template->tempadminaktif();
            $data = [
                'title'       => 'Tampilan POPUP',

                'konfigurasi' => $this->modalpopup->orderBy('modalpopup_id')->first(),
            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'modal/penawaran/viewpenawaran', $data)

            ];
            echo json_encode($msg);
        }
    }
}
