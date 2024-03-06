<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     *
     * @var array<string, array<int, string>|string> [filter_name => classname]
     *                                               or [filter_name => [classname1, classname2, ...]]
     * @phpstan-var array<string, class-string|list<class-string>>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     *
     * @var array<string, array<string, array<string, string>>>|array<string, array<string>>
     * @phpstan-var array<string, list<string>>|array<string, array<string, array<string, string>>>
     */
    public array $globals = [
        'before' => [
            'Validasilogin' => [
                'except' => [
                    '/*',
                    'cors',
                    'database', 'database/*',
                    'apiupdate', 'apiupdate/*',
                    'transparansi', 'transparansi/',
                    'transparansi/TampilkanGrafikAll/', 'transparansi/TampilkanGrafikAll/',
                    'transparansi/TampilkanGrafik/', 'transparansi/TampilkanGrafik/',
                    'registrasi', 'registrasi/*',
                    'detail', 'detail/*',
                    'masukansaran', 'masukansaran/*',
                    'daftarakun', 'daftarakun/*',
                    'ebook/bacaebook', 'ebook/bacaebook/*',
                    'ebook', 'ebook',
                    'survey/', 'survey/',
                    'survey/isisurvei', 'survey/isisurvei',
                    'ebook/formlihat', 'ebook/formlihat/*',
                    'lupapassword', 'lupapassword/*',
                    'resetpassword', 'resetpassword/*',
                    'prosesgantipass', 'prosesgantipass/*',
                    'login', 'login/*',
                    'home', 'home/*',
                    'temp-frontend', 'temp-frontend/*',
                    'petasitus', 'petasitus/*',
                    'infografis', 'infografis',
                    'infografis/formlihatinfo', 'infografis/formlihatinfo/*',
                    'berita', 'berita',
                    'berita/detail', 'berita/detail/*',
                    'author', 'author/*',
                    'berita/kategori', 'berita/kategori/*',
                    'berita/simpankomen', 'berita/simpankomen/*',
                    'berita/likeposting', 'berita/likeposting/*',
                    'unit', 'unit/*',
                    'page/', 'page/*',
                    'category/', 'category/*',
                    'tag/', 'tag/*',
                    'masukansaran/', 'masukansaran/*',
                    'agenda', 'agenda',
                    'agenda/formlihatagenda', 'agenda/formlihatagenda',
                    'layanan', 'layanan',
                    'layanan/formlihatlayanan', 'layanan/formlihatlayanan',
                    'pengumuman/formlihatpengumuman', 'pengumuman/formlihatpengumuman',
                    'pengumuman', 'pengumuman',
                    'bankdata', 'bankdata',
                    'foto', 'foto',
                    'foto/detail/', 'foto/detail/*',
                    'foto/formlihatfoto', 'foto/formlihatfoto/*',
                    'video', 'video',
                    'video/detail', 'video/detail',
                    'pegawai', 'pegawai',
                    'pegawai/formlihat', 'pegawai/formlihat',
                    'bankdata/getbankdata', 'bankdata/getbankdata',
                    'pendaftaran', 'pendaftaran/*',
                    'cari', 'cari/*',
                    'poling/ubahpoling', 'poling/ubahpoling/*',
                    'poling/lihatpoling', 'poling/lihatpoling/*',
                    'kritiksaran/formkritik', 'kritiksaran/formkritik/*',
                    'kritiksaran/simpanKritik', 'kritiksaran/simpanKritik/*',
                    'bukutamu/simpanbukutamu', 'bukutamu/simpanbukutamu/*',
                    'bukutamu', 'bukutamu/',
                    'produkhukum', 'produkhukum',
                    'bacabuku/', 'bacabuku/*',
                    'daftar/simpananggota',
                    'daftar', 'daftar/',
                    'fasilitas', 'fasilitas/',
                    'sekolah-kejar-paket-a/', 'sekolah-kejar-paket-a/*',
                    'sekolah-kejar-paket-b/', 'sekolah-kejar-paket-b/*',
                    'sekolah-kejar-paket-c/', 'sekolah-kejar-paket-c/*',
                    'home-schooling/', 'home-schooling/*',
                ]
            ],


            // 'honeypot',
            // 'csrf',
            'csrf' => ['except' => [
                'halaman/listdata2', 'halaman/listdata2',
                'berita/listdata2', 'berita/listdata2',
                'login/logout', 'login/logout',
            ]],
            // 'invalidchars',
        ],
        'after' => [
            'Validasilogin' => [
                'except' => [
                    '/*',
                    'template', 'template/*',
                    'ebook', 'ebook/*',
                    'home', 'home/*',
                    'user', 'user/*',
                    // 'csrf',
                    'admin', 'admin/*',
                    'aplikasi', 'aplikasi/*',
                    'konfigurasi', 'konfigurasi/*',
                    'banner', 'banner/*',
                    'linkterkait', 'linkterkait/*',
                    'sambutan', 'sambutan/*',
                    'agenda', 'agenda/*',
                    'layanan', 'layanan/*',
                    'pengumuman', 'pengumuman/*',
                    'bankdata', 'bankdata/*',
                    'kategorifoto', 'kategorifoto/*',
                    'kategorivideo', 'kategorivideo/*',
                    'pegawai', 'pegawai/*',
                    'video', 'video/*',
                    'video/detail', 'video/detail/*',
                    'kritiksaran', 'kritiksaran/*',
                    'pendaftaran', 'pendaftaran/*',
                    'visitor', 'visitor/*',
                    'cari', 'cari/*',
                    'poling', 'poling/*',
                    'menu', 'menu/*',
                    'submenu', 'submenu/*',
                    'halaman', 'halaman/*',
                    'penawaran', 'penawaran/*',
                    'section', 'section/*',
                    'petasitus', 'petasitus/*',
                    'produkhukum', 'produkhukum/*',
                    'survey', 'survey/*',
                    'bidang', 'bidang/*',
                    'jsekolah', 'jsekolah/*',
                    'masukansaran/', 'masukansaran/*',
                    'bacabuku/', 'bacabuku/*',
                    'tanyajawab/', 'tanyajawab/*',

                ]

            ],
            //'toolbar',
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don't expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
