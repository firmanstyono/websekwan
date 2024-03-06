<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;

class Permohonaninfo extends BaseController
{

    //front end
    public function index()
    {
        $konfigurasi    = $this->konfigurasi->vkonfig();
        $template       = $this->template->tempaktif();
        $data = [
            'title'         => 'Permohonan Informasi ' . $konfigurasi->nama,
            'deskripsi'     => $konfigurasi->deskripsi,
            'url'           => $konfigurasi->website,
            'img'           => base_url('/public/img/konfigurasi/logo/' . $konfigurasi->logo),
            'konfigurasi'   => $konfigurasi,
            'mainmenu'      => $this->menu->mainmenu(),
            'footer'        => $this->menu->footermenu(),
            'topmenu'       => $this->menu->topmenu(),

            'caraperolehinfo'   => $this->masterdata->list1(),
            'pekerjaan'         => $this->masterdata->list2(),
            'caradapatinfo'     => $this->masterdata->list3(),

            'linkterkaitall'  => $this->linkterkait->publishlinkall(),
            'sitekey'         => $konfigurasi->g_sitekey,

            'folder'        => $template['folder']
        ];
        if ($template['duatema'] == 1) {
            $agent = $this->request->getUserAgent();
            if ($agent->isMobile()) {
                return view('frontend/' . $template['folder'] . '/mobile/' . 'content/permohonan_info', $data);
            } else {
                return view('frontend/' . $template['folder'] . '/desktop/' . 'content/permohonan_info', $data);
            }
        } else {
            return view('frontend/' . $template['folder'] . '/desktop/' . 'content/permohonan_info', $data);
        }
    }

    //back end
    public function list()
    {
        if (session()->get('id') == '') {
            return redirect()->to('');
        }
        $tadmin = $this->template->tempadminaktif();
        $data = [
            'title'           => 'Permintaan',
            'subtitle'        => 'Informasi',
            'folder'          => $tadmin['folder'],
        ];

        return view('backend/' . $tadmin['folder'] . '/' . 'interaksi/permintaan-info/index', $data);
    }

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $id_grup = session()->get('id_grup');

            $url = 'permintaan-info/list';
            $listgrupf =  $this->grupakses->listgrupakses($id_grup, $url);

            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
                $hapus = $data['hapus'];
                $ubah = $data['ubah'];

            endforeach;
            // jika temukan maka eksekusi
            $tadmin = $this->template->tempadminaktif();
            if ($listgrupf) {
                # cek akses
                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'     => 'Permintaan Informasi',
                        'list'      => $this->permohonaninfo->list(),
                        'akses'     => $akses,
                        'hapus'     => $hapus,
                        'ubah'      => $ubah
                    ];
                    $msg = [
                        'data' => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/permintaan-info/list', $data),

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

    public function getdatanew()
    {
        if ($this->request->isAJAX()) {
            $tadmin             = $this->template->tempadminaktif();
            $data = [

                'list'      => $this->kritiksaran->listkritiknew(),
                'totkritik' => $this->kritiksaran->totkritik()

            ];
            $msg = [
                'data' => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/kritiksaran/vmenukritik', $data)

            ];
            echo json_encode($msg);
        }
    }

    public function kirimpermohonan()
    {
        if ($this->request->isAJAX()) {

            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'nama_pemohon' => [
                    'label' => 'Nama',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],

                'email_pemohon' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                        'valid_email' => 'Masukkan {field} dengan benar!',
                    ]
                ],
                'hp_pemohon' => [
                    'label' => 'No HP',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'alamat_pemohon' => [
                    'label' => 'Alamat',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',

                    ]
                ],
                'foto_ktp' => [
                    'label' => 'Identitas diri',
                    'rules' => [
                        'uploaded[foto_ktp]',
                        'max_size[foto_ktp,1024]',
                        'mime_in[foto_ktp,image/png,image/jpg,image/jpeg,image/gif]|is_image[foto_ktp]',

                    ],
                    // 'rules' => 'uploaded[foto_ktp]|max_size[foto_ktp,1024]|mime_in[foto_ktp,image/png,image/jpg,image/jpeg,image/gif]|is_image[foto_ktp]',
                    'errors' => [
                        'uploaded' => 'Masukkan gambar {field}',
                        'max_size' => 'Ukuran {field} Maksimal 1024 KB..!!',
                        'mime_in' => 'Format file {field} PNG, Jpeg, Jpg, atau Gif..!!'
                    ]
                ],

                'info_ygdibutuhkan' => [
                    'label' => 'Informasi yang dibutuhkan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
                'tujuan_info' => [
                    'label' => 'Tujuan penggunaan Informasi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong!',
                    ]
                ],
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'nama_pemohon'      => $validation->getError('nama_pemohon'),
                        'email_pemohon'     => $validation->getError('email_pemohon'),
                        'hp_pemohon'        => $validation->getError('hp_pemohon'),
                        'alamat_pemohon'    => $validation->getError('alamat_pemohon'),
                        'foto_ktp'          => $validation->getError('foto_ktp'),
                        'info_ygdibutuhkan' => $validation->getError('info_ygdibutuhkan'),
                        'tujuan_info'       => $validation->getError('tujuan_info'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $email              = $this->request->getVar('email_pemohon');
                $hpuser             = $this->request->getVar('hp_pemohon');

                $nama_pemohon       = htmlspecialchars($this->request->getVar('nama_pemohon'), ENT_QUOTES);
                $alamat_pemohon     = htmlspecialchars($this->request->getVar('alamat_pemohon'), ENT_QUOTES);
                $info_ygdibutuhkan  = htmlspecialchars($this->request->getVar('info_ygdibutuhkan'), ENT_QUOTES);
                $tujuan_info        = htmlspecialchars($this->request->getVar('tujuan_info'), ENT_QUOTES);

                $filefoto           = $this->request->getFile('foto_ktp');
                $foto_ktp           = $filefoto->getRandomName();
                // konfig
                $konfigurasi        = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $apikey             = $konfigurasi['tokenwa'];
                $phone              = $konfigurasi['no_waysender'];
                $secretkey          = $konfigurasi['g_secretkey'];
                $g_sitekey          = $konfigurasi['g_sitekey'];

                // arr data
                $insertdata = [
                    'nama_pemohon'         => $nama_pemohon,
                    'alamat_pemohon'       => $alamat_pemohon,
                    'pek_pemohon'          => $this->request->getVar('pek_pemohon'),
                    'hp_pemohon'           => $hpuser,
                    'email_pemohon'        => $email,
                    'info_ygdibutuhkan'    => $info_ygdibutuhkan,
                    'tujuan_info'          => $tujuan_info,
                    'foto_ktp'             => $foto_ktp,
                    'cara_perolehinfo'     => $this->request->getVar('cara_perolehinfo'),
                    'cara_dapatkaninfo'    => $this->request->getVar('cara_dapatkaninfo'),
                    'tgl_ajuan'            => date('Y-m-d H:i:s'),
                    'sts_info'             => '0'

                ];

                // gcaptcha

                if ($secretkey != '' && $g_sitekey != '') {

                    $recaptchaResponse = trim($this->request->getVar('g-recaptcha-response'));
                    $secret            = $secretkey;

                    $credential = array(
                        'secret' => $secret,
                        'response' => $recaptchaResponse
                    );

                    $verify = curl_init();
                    curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
                    curl_setopt($verify, CURLOPT_POST, true);
                    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($credential));
                    curl_setopt($verify, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($verify);

                    $status = json_decode($response, true);

                    if ($status['success']) {

                        $this->permohonaninfo->insert($insertdata);
                        \Config\Services::image()
                            ->withFile($filefoto)
                            ->save('public/file/dokumen/' .  $foto_ktp);

                        $isipesan = 'Permohonan dari : *' . $nama_pemohon . '* Informasi yang dibutuhkan : *' . $info_ygdibutuhkan . '* _[Klik disini untuk balas](' . base_url('permintaan-info/list') . ')';

                        if ($apikey != '' and $phone != '') {
                            $this->kirimWA($isipesan);
                        }
                        $msg = [
                            'sukses' => 'Permohonan Anda sukses terkirim..! Tanggapan akan dikirimkan ke Email Anda!'
                        ];
                    } else {
                        $msg = [
                            'gagal' => 'Gagal kirim permohonan Silahkan periksa Kembali!'
                        ];
                    }
                } else {

                    $this->permohonaninfo->insert($insertdata);
                    \Config\Services::image()
                        ->withFile($filefoto)
                        ->save('public/file/dokumen/' .  $foto_ktp);

                    $isipesan = 'Permohonan dari : *' . $nama_pemohon . '* Informasi yang dibutuhkan : *' . $info_ygdibutuhkan . '* _[Klik disini untuk balas](' . base_url('permintaan-info/list') . ')';

                    if ($apikey != '' and $phone != '') {
                        $this->kirimWA($isipesan);
                    }
                    $msg = [
                        'sukses' => 'Permohonan Anda sukses terkirim..! Tanggapan akan dikirimkan ke Email Anda!'
                    ];
                }

                // gunakan google
            }
            echo json_encode($msg);
        }
    }

    function kirimWA($isipesan)
    {

        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $apikey = $konfigurasi['tokenwa']; //nomor wa 165329ea1ff5c5ecbdbbeef
        $phone = $konfigurasi['no_waysender']; //nomor wa gateway
        $hpuser = $konfigurasi['wa_penerima']; //nomor wa penerima
        $urlserver = $konfigurasi['urlserver']; //server layanan

        $data = [
            'api_key' => $apikey,
            'sender'  => $phone, //dari Wa gateway
            'number'  => $hpuser, // yg terima wa
            'message' => $isipesan
        ];

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $urlserver,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data)
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        // echo $response;
    }

    // form balas masukan saran
    public function formedit()
    {
        if ($this->request->isAJAX()) {

            $id_grup        = session()->get('id_grup');
            $id_mohoninfo   = $this->request->getVar('id_mohoninfo');
            $url            = 'permintaan-info/list';
            $listgrupf      = $this->grupakses->listgrupakses($id_grup, $url);
            $tadmin         = $this->template->tempadminaktif();
            foreach ($listgrupf as $data) :
                $akses = $data['akses'];
            endforeach;
            // jika temukan maka eksekusi
            if ($listgrupf) {
                # cek akses
                $list                   = $this->permohonaninfo->find($id_mohoninfo);
                $idpek                  = $list['pek_pemohon'];
                $idcara_perolehinfo     = $list['cara_perolehinfo'];
                $idcara_dapatkaninfo    = $list['cara_dapatkaninfo'];


                $pek                    = $this->masterdata->find($idpek);
                $caraperoleh            = $this->masterdata->find($idcara_perolehinfo);
                $caradapat              = $this->masterdata->find($idcara_dapatkaninfo);
                $pekerjaan              = $pek['nama_master'];
                $caraperolehinfo        = $caraperoleh['nama_master'];
                $caradapatinfo          = $caradapat['nama_master'];

                if ($akses == '1' || $akses == '2') {
                    $data = [
                        'title'             => 'Detail Permohonan Informasi',
                        'id_mohoninfo'      => $list['id_mohoninfo'],
                        'nama_pemohon'      => $list['nama_pemohon'],
                        'alamat_pemohon'    => $list['alamat_pemohon'],
                        // 'pek_pemohon'       => $pekerjaan,
                        'hp_pemohon'        => $list['hp_pemohon'],
                        'email_pemohon'     => $list['email_pemohon'],
                        'info_ygdibutuhkan' => $list['info_ygdibutuhkan'],
                        'tujuan_info'       => $list['tujuan_info'],
                        'foto_ktp'          => $list['foto_ktp'],
                        // 'cara_perolehinfo'  => $list['cara_perolehinfo'],
                        // 'cara_dapatkaninfo' => $list['cara_dapatkaninfo'],
                        'tgl_ajuan'         => $list['tgl_ajuan'],
                        'sts_info'          => $list['sts_info'],
                        'respon_balas'      => $list['respon_balas'],
                        'akses'             => $akses,
                        'caraperolehinfo'   => $caraperolehinfo,
                        'pekerjaan'         => $pekerjaan,
                        'caradapatinfo'     => $caradapatinfo,


                    ];
                    $msg = [
                        'sukses'                => view('backend/' . $tadmin['folder'] . '/' . 'interaksi/permintaan-info/edit', $data),
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
        }
        echo json_encode($msg);
    }

    public function updatestatus()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $valid = $this->validate([
                'respon_balas' => [
                    'label' => 'Tanggapan/Balasan',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} tidak boleh kosong',
                    ]
                ]
            ]);
            if (!$valid) {
                $msg = [
                    'error' => [
                        'respon_balas' => $validation->getError('respon_balas'),
                    ],
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $id             = session()->get('id');
                $konfigurasi    = $this->konfigurasi->orderBy('id_setaplikasi')->first();
                $balasbuka      = $konfigurasi['smtp_pesanbalas']; //email dinas penyamaran
                $apikey         = $konfigurasi['tokenwa'];
                $phone          = $konfigurasi['no_waysender']; //nomor wa gateway

                $id_mohoninfo   = $this->request->getVar('id_mohoninfo');
                $sts_info       = $this->request->getVar('sts_info');
                $email_pemohon  = $this->request->getVar('email_pemohon'); //email user
                $nama_pemohon   = $this->request->getVar('nama_pemohon'); //nama_pemohon user
                $hp_pemohon     = $this->request->getVar('hp_pemohon');
                $balas          = $this->request->getVar('respon_balas'); //isi balasan
                $title          = 'Balasan Permohonan Informasi';
                $pesanbalas     = '<h2> ' . $balasbuka . ' </h2><p> <h4> ' . $balas . '</h4></p>';
                $isibalas       = 'Hallo, *' . $nama_pemohon . '*.. ' . $balasbuka . 'Berikut tanggapan kami.. *' . $balas . '* _Jangan balas pesan ini, karena otomatis dari Sistem_ ' . $konfigurasi['website'];

                $data = [
                    'sts_info'      => $sts_info,
                    'respon_balas'  => $balas,
                    'id'            => $id,
                    'tgl_respon'    => date('Y-m-d H:i:s'),
                ];

                $this->permohonaninfo->update($id_mohoninfo, $data);

                if ($sts_info != 0) {

                    $this->sendEmail($email_pemohon, $title, $pesanbalas);

                    if ($apikey != '' and $phone != '') {
                        $this->kirimwabalas($isibalas, $hp_pemohon);
                    }
                    $titelbalas = 'Sukses tanggapi & dikirim ke Email!';
                } else {
                    $titelbalas = 'Ajuan sukses diubah';
                }

                $msg = [
                    'sukses'                => $titelbalas,
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }
            echo json_encode($msg);
        }
    }

    function kirimwabalas($isibalas, $no_hpusr)
    {

        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $apikey = $konfigurasi['tokenwa']; //nomor wa 165329ea1ff5c5ecbdbbeef
        $phone = $konfigurasi['no_waysender']; //nomor wa gateway
        $urlserver = $konfigurasi['urlserver']; //server layanan

        $data = [
            'api_key' => $apikey,
            'sender'  => $phone, //dari Wa gateway
            'number'  => $no_hpusr, // yg terima wa
            'message' => $isibalas
        ];

        $curl = curl_init();
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => $urlserver,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($data)
            )
        );

        $response = curl_exec($curl);
        curl_close($curl);
        // echo $response;
    }


    private function sendEmail($emailusr, $title, $pesanbalas)
    {
        $email_smtp = \Config\Services::email();
        $konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
        $namadinas = $konfigurasi['smtp_pengirim']; //nama samar

        $namadomain = $konfigurasi['smtp_host'];
        $smptuser = $konfigurasi['smtp_username'];
        $pass = $konfigurasi['smtp_password'];
        $port = $konfigurasi['smtp_port'];


        $config["protocol"] = "smtp";

        //isi sesuai nama domain/mail server
        $config["SMTPHost"]  = $namadomain;

        //alamat email SMTP
        $config["SMTPUser"]  = $smptuser;

        //password email SMTP
        $config["SMTPPass"]  = $pass;

        $config["SMTPPort"]  = $port;
        $config["SMTPCrypto"] = "ssl";

        $email_smtp->initialize($config);

        $email_smtp->setFrom($smptuser, $namadinas);
        $email_smtp->setTo($emailusr);
        $email_smtp->setSubject($title);
        $email_smtp->setMessage($pesanbalas);

        $email_smtp->send();
    }


    public function toggle()
    {
        if ($this->request->isAJAX()) {
            $id_mohoninfo = $this->request->getVar('id_mohoninfo');
            $cari =  $this->permohonaninfo->find($id_mohoninfo);

            if ($cari['sts_public'] == '1') {
                $list =  $this->permohonaninfo->getaktif($id_mohoninfo);
                $toggle = $list ? 0 : 1;
                $updatedata = [
                    'sts_public'        => $toggle,
                ];
                $this->permohonaninfo->update($id_mohoninfo, $updatedata);
                $msg = [
                    'sukses'                => 'Berhasil dinonaktifkan!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            } else {
                $list =  $this->permohonaninfo->getnonaktif($id_mohoninfo);
                $toggle = $list ? 1 : 0;
                $updatedata = [
                    'sts_public'        => $toggle,
                ];
                $this->permohonaninfo->update($id_mohoninfo, $updatedata);
                $msg = [
                    'sukses' => 'Berhasil menampilkan ke publik!',
                    'csrf_tokencmsdatagoe'  => csrf_hash(),
                ];
            }

            echo json_encode($msg);
        }
    }

    public function hapus()
    {
        if ($this->request->isAJAX()) {

            $id_mohoninfo   = $this->request->getVar('id_mohoninfo');
            $cekdata        = $this->permohonaninfo->find($id_mohoninfo);
            $filelama       = $cekdata['foto_ktp'];

            if ($filelama != '' && file_exists('public/file/dokumen/' . $filelama)) {
                unlink('public/file/dokumen/' . $filelama);
            }
            $this->permohonaninfo->delete($id_mohoninfo);
            $msg = [
                'sukses'                => 'Data berhasil dihapus!',
                'csrf_tokencmsdatagoe'  => csrf_hash(),
            ];

            echo json_encode($msg);
        }
    }

    public function hapusall()
    {
        if ($this->request->isAJAX()) {
            $id_mohoninfo = $this->request->getVar('id_mohoninfo');
            $jmldata = count($id_mohoninfo);
            for ($i = 0; $i < $jmldata; $i++) {
                $cekdata        = $this->permohonaninfo->find($id_mohoninfo[$i]);
                $filelama       = $cekdata['foto_ktp'];

                if ($filelama != '' && file_exists('public/file/dokumen/' . $filelama)) {
                    unlink('public/file/dokumen/' . $filelama);
                }
                $this->permohonaninfo->delete($id_mohoninfo[$i]);
            }

            $msg = [
                'sukses' => "$jmldata data berhasil dihapus"
            ];
            echo json_encode($msg);
        }
    }
}
