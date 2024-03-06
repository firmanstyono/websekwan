<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->resource('api-show', ['controller' => 'Apiupdate']);
$routes->get('post-cms',                 'Apiupdate::berita');
// $routes->resource('apiupdate', ['controller' => 'Apiupdate']);
$routes->group('', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('petasitus', 'Petasitus::index');
    $routes->post('home/penawaran22', 'Home::penawaran22');
    $routes->post('home/cekpengunjung', 'Home::cekpengunjung');
    $routes->get('home/nonaktiftawaran', 'Home::nonaktiftawaran');

    $routes->get('konfigurasi', 'Konfigurasi::index');
    $routes->post('getkonfig', 'Konfigurasi::getkonfig');
    $routes->post('konfigurasi/formuploadlogo', 'Konfigurasi::formuploadlogo');
    $routes->post('simpankonfig', 'Konfigurasi::simpankonfig');
    $routes->post('konfigurasi/douploadlogo', 'Konfigurasi::douploadlogo');
    $routes->post('konfigurasi/formuploadicon', 'Konfigurasi::formuploadicon');
    $routes->post('konfigurasi/douploadicon', 'Konfigurasi::douploadicon');
    // modul
    $routes->get('modul', 'Modul::index');
    $routes->get('modul/getgrupmenu', 'Modul::getgrupmenu');
    $routes->post('modul/toggle', 'Modul::toggle');
    $routes->post('modul/formeditmenu', 'Modul::formeditmenu');
    $routes->post('modul/updatemodulmenu', 'Modul::updatemodulmenu');
    $routes->post('modul/formsetaksesmenu', 'Modul::formsetaksesmenu');
    $routes->post('modul/simpansetaksesmenu', 'Modul::simpansetaksesmenu');
    $routes->post('modul/hapus', 'Modul::hapus');
    $routes->get('modul/formtambahmenu', 'Modul::formtambahmenu');
    $routes->post('modul/simpangrupmenu', 'Modul::simpangrupmenu');


    $routes->get('submodul/(:segment)', 'Modul::det/$1');

    $routes->post('modul/getdata', 'Modul::getdata');
    $routes->post('modul/formedit', 'Modul::formedit');
    $routes->post('modul/updatemodul', 'Modul::updatemodul');
    $routes->get('modul/formtambah', 'Modul::formtambah');
    $routes->post('modul/simpanmodul', 'Modul::simpanmodul');

    $routes->get('modul/publik', 'Modul::publik');
    $routes->get('modul/getpublik', 'Modul::getpublik');
    $routes->post('modul/togglepublik', 'Modul::togglepublik');
    $routes->post('modul/simpanpublik', 'Modul::simpanpublik');
    $routes->post('modul/hapuspublik', 'Modul::hapuspublik');
    $routes->post('modul/formeditpublik', 'Modul::formeditpublik');
    $routes->post('modul/updatepublik', 'Modul::updatepublik');
    $routes->get('modul/formpublik', 'Modul::formpublik');
    $routes->post('modul/formsetakses', 'Modul::formsetakses');
    $routes->post('modul/simpansetakses', 'Modul::simpansetakses');

    // iklan
    $routes->get('iklan', 'Iklan::index');
    $routes->get('iklan/getdata', 'Iklan::getdata');
    $routes->get('iklan/formtambah', 'Iklan::formtambah');
    $routes->post('iklan/uploadfoto', 'Iklan::uploadfoto');
    $routes->post('iklan/hapusall', 'Iklan::hapusall');
    $routes->post('iklan/hapus', 'Iklan::hapus');
    $routes->post('iklan/formgantibanner', 'Iklan::formgantibanner');
    $routes->post('iklan/douploadbanner', 'Iklan::douploadbanner');
    $routes->post('iklan/formedit', 'Iklan::formedit');
    $routes->post('iklan/updatebanner', 'Iklan::updatebanner');

    // ebook
    $routes->get('ebook', 'Ebook::index');
    $routes->get('ebook/all', 'Ebook::all');
    $routes->get('ebook/getdata', 'Ebook::getdata');
    $routes->post('ebook/formganticover', 'Ebook::formganticover');
    $routes->post('ebook/douploadCover', 'Ebook::douploadCover');
    $routes->post('ebook/toggle', 'Ebook::toggle');
    $routes->post('ebook/formlihat', 'Ebook::formlihat');
    $routes->post('ebook/formedit', 'Ebook::formedit');
    $routes->post('ebook/updatedata', 'Ebook::updatedata');
    $routes->post('ebook/hapus', 'Ebook::hapus');
    $routes->post('ebook/hapusall', 'Ebook::hapusall');
    $routes->get('ebook/formtambah', 'Ebook::formtambah');
    $routes->post('ebook/simpanEbook', 'Ebook::simpanEbook');
    $routes->post('ebook/updatehit', 'Ebook::updatehit');
    $routes->get('ebook/getebook', 'Ebook::getebook');
    $routes->get('ebook/detail/(:segment)', 'Ebook::detail/$1');
    // kategori ebook
    $routes->get('ebook/kategori', 'Ebook::kategori');
    $routes->get('ebook/getkategori', 'Ebook::getkategori');
    $routes->post('ebook/formganticover', 'Ebook::formganticover');
    $routes->post('ebook/douploadCover', 'Ebook::douploadCover');
    $routes->post('ebook/formeditkategori', 'Ebook::formeditkategori');
    $routes->post('ebook/updatekategori', 'Ebook::updatekategori');
    $routes->post('ebook/hapuskategori', 'Ebook::hapuskategori');
    $routes->get('ebook/formkategori', 'Ebook::formkategori');
    $routes->post('ebook/simpankategori', 'Ebook::simpankategori');
    $routes->get('bacabuku/(:segment)', 'Ebook::bacaebook/$1', ['as' => 'bacabuku']);

    // banner
    $routes->get('banner', 'Banner::index'); //back
    $routes->get('banner/getdata', 'Banner::getdata');
    $routes->post('banner/formgantibanner', 'Banner::formgantibanner');
    $routes->post('banner/douploadbanner', 'Banner::douploadbanner');
    $routes->post('banner/toggle', 'Banner::toggle');
    $routes->post('banner/formedit', 'Banner::formedit');
    $routes->post('banner/updatebanner', 'Banner::updatebanner');
    $routes->post('banner/hapus', 'Banner::hapus');
    $routes->post('banner/hapusall', 'Banner::hapusall');
    $routes->get('banner/formtambah', 'Banner::formtambah');
    $routes->post('banner/uploadfoto', 'Banner::uploadfoto');

    // survei

    $routes->get('survey', 'Survey::index');
    $routes->post('survey/isisurvei', 'Survey::isisurvei');
    $routes->get('survey/all', 'Survey::all');
    $routes->get('survey/getdata', 'Survey::getdata');
    $routes->get('survey/formtambah', 'Survey::formtambah');
    $routes->post('survey/simpansurveytopik', 'Survey::simpansurveytopik');
    $routes->post('survey/formedit', 'Survey::formedit');
    $routes->post('survey/updatetopik', 'Survey::updatetopik');
    $routes->post('survey/toggle', 'Survey::toggle');
    $routes->post('survey/hapus', 'Survey::hapus');
    $routes->post('resetnilai', 'Survey::resetnilai');

    $routes->get('survey/pertanyaan/(:segment)', 'Survey::pertanyaan/$1');
    $routes->get('survey/getpertanyaan', 'Survey::getpertanyaan');
    $routes->post('survey/formeditpertanyaan', 'Survey::formeditpertanyaan');
    $routes->post('survey/updatepertanyaan', 'Survey::updatepertanyaan');
    $routes->get('survey/formtambahpertanyaan', 'Survey::formtambahpertanyaan');
    $routes->post('survey/simpanPertanyaan', 'Survey::simpanPertanyaan');
    $routes->post('survey/hapuspertanyaan', 'Survey::hapuspertanyaan');
    $routes->post('survey/hapusperall', 'Survey::hapusperall');

    $routes->get('survey/jawaban/(:segment)', 'Survey::jawaban/$1');
    $routes->get('survey/getjawaban', 'Survey::getjawaban');
    $routes->get('survey/formtambahjawaban', 'Survey::formtambahjawaban');

    $routes->post('survey/simpanjawaban', 'Survey::simpanjawaban');
    $routes->post('survey/formeditjawaban', 'Survey::formeditjawaban');
    $routes->post('survey/hapusjwball', 'Survey::hapusjwball');
    $routes->post('survey/hapusjawaban', 'Survey::hapusjawaban');

    $routes->post('survey/updatejawaban', 'Survey::updatejawaban');
    $routes->get('survey/pesan/(:segment)', 'Survey::pesan/$1');
    $routes->get('survey/getpesan', 'Survey::getpesan');
    $routes->post('survey/hapusrespon', 'Survey::hapusrespon');
    $routes->get('survey/cetak/(:segment)', 'Survey::cetak/$1');

    // bukutamu
    $routes->get('bukutamu', 'Bukutamu::index');
    $routes->get('bukutamu/list', 'Bukutamu::list');
    $routes->get('bukutamu/getdata', 'Bukutamu::getdata');
    $routes->post('bukutamu/hapus', 'Bukutamu::hapus');
    $routes->post('bukutamu/hapusall', 'Bukutamu::hapusall');
    $routes->post('bukutamu/formedit', 'Bukutamu::formedit');
    $routes->post('bukutamu/simpanbukutamu', 'Bukutamu::simpanbukutamu');

    $routes->get('bukutamu/bidang', 'Bukutamu::bidang');
    $routes->get('bukutamu/getbidang', 'Bukutamu::getbidang');
    $routes->post('bukutamu/formeditbidang', 'Bukutamu::formeditbidang');
    $routes->post('bukutamu/updatebidang', 'Bukutamu::updatebidang');
    $routes->post('bukutamu/hapusbidang', 'Bukutamu::hapusbidang');
    $routes->get('bukutamu/formbidang', 'Bukutamu::formbidang');
    $routes->post('bukutamu/simpanbidang', 'Bukutamu::simpanbidang');
    // faq 
    $routes->get('tanyajawab', 'Tanyajawab::index'); // front
    $routes->get('tanyajawab/list', 'Tanyajawab::list');
    $routes->get('tanyajawab/getdata', 'Tanyajawab::getdata');
    $routes->get('tanyajawab/formtambah', 'Tanyajawab::formtambah');
    $routes->post('tanyajawab/simpanfaqtanya', 'Tanyajawab::simpanfaqtanya');
    $routes->post('tanyajawab/formedit', 'Tanyajawab::formedit');
    $routes->post('tanyajawab/updatefaqtanya', 'Tanyajawab::updatefaqtanya');
    $routes->post('tanyajawab/hapus', 'Tanyajawab::hapus');
    $routes->post('tanyajawab/hapusall', 'Tanyajawab::hapusall');

    // jawaban faq
    $routes->get('tanyajawab/jawaban/(:segment)', 'Tanyajawab::jawaban/$1');
    $routes->get('tanyajawab/getjawaban', 'Tanyajawab::getjawaban');
    $routes->get('tanyajawab/formtambahjawaban', 'Tanyajawab::formtambahjawaban');
    $routes->post('tanyajawab/simpanjawaban', 'Tanyajawab::simpanjawaban');
    $routes->post('tanyajawab/formeditjawaban', 'Tanyajawab::formeditjawaban');
    $routes->post('tanyajawab/updatejawaban', 'Tanyajawab::updatejawaban');
    $routes->post('tanyajawab/hapusjawaban', 'Tanyajawab::hapusjawaban');
    $routes->post('tanyajawab/hapusjwball', 'Tanyajawab::hapusjwball');

    // polling 
    $routes->get('poling', 'Poling::index');
    $routes->get('poling/list', 'Poling::list');
    $routes->get('poling/getdata', 'Poling::getdata');
    $routes->get('poling/formtambah', 'Poling::formtambah');
    $routes->post('poling/toggle', 'Poling::toggle');
    $routes->post('poling/simpanpoling', 'Poling::simpanpoling');
    $routes->post('poling/formedit', 'Poling::formedit');
    $routes->post('poling/updatepoling', 'Poling::updatepoling');
    $routes->post('poling/ubahpoling', 'Poling::ubahpoling');
    // $routes->get('poling/ubahpoling', 'Poling::ubahpoling');
    $routes->post('poling/hapus', 'Poling::hapus');
    $routes->post('poling/hapusall', 'Poling::hapusall');
    $routes->get('poling/lihatpoling', 'Poling::lihatpoling');

    // sambutan 
    $routes->get('sambutan', 'Sambutan::index');
    $routes->get('sambutan/lihathasiladmin', 'Sambutan::lihathasiladmin');
    $routes->post('sambutan/formuploadpimpinan', 'Sambutan::formuploadpimpinan');
    $routes->post('sambutan/douploadlogo', 'Sambutan::douploadlogo');
    $routes->post('sambutan/submit', 'Sambutan::submit');

    // Pegawai
    $routes->get('pegawai', 'Pegawai::index'); //front
    $routes->get('pegawai/all', 'Pegawai::all'); //back
    $routes->get('pegawai/getdata', 'Pegawai::getdata');
    $routes->get('pegawai/formtambah', 'Pegawai::formtambah');
    $routes->post('pegawai/simpanPegawai', 'Pegawai::simpanPegawai');
    $routes->post('pegawai/formedit', 'Pegawai::formedit');
    $routes->post('pegawai/updatepegawai', 'Pegawai::updatepegawai');
    $routes->post('pegawai/formgantifoto', 'Pegawai::formgantifoto');
    $routes->post('pegawai/douploadfoto', 'Pegawai::douploadfoto');
    $routes->post('pegawai/formgantitupoksi', 'Pegawai::formgantitupoksi');
    $routes->post('pegawai/douploadtupoksi', 'Pegawai::douploadtupoksi');
    $routes->post('pegawai/hapuspdf', 'Pegawai::hapuspdf');
    $routes->post('pegawai/formlihat', 'Pegawai::formlihat');
    $routes->post('pegawai/formlihatback', 'Pegawai::formlihatback');
    $routes->post('pegawai/hapus', 'Pegawai::hapus');
    $routes->post('pegawai/hapusall', 'Pegawai::hapusall');
    $routes->get('pegawai/formimport', 'Pegawai::formimport');
    $routes->post('pegawai/prosesExcel', 'Pegawai::prosesExcel');


    // layanan
    $routes->get('layanan', 'Layanan::index');
    $routes->get('layanan/all', 'Layanan::all');
    $routes->get('layanan/getdata', 'Layanan::getdata');
    $routes->get('layanan/formtambah', 'Layanan::formtambah');
    $routes->post('layanan/simpanLayanan', 'Layanan::simpanLayanan');
    $routes->post('layanan/formedit', 'Layanan::formedit');
    $routes->post('layanan/updatelayanan', 'Layanan::updatelayanan');
    $routes->post('layanan/formgantifoto', 'Layanan::formgantifoto');
    $routes->post('layanan/douploadLayanan', 'Layanan::douploadLayanan');
    $routes->post('layanan/hapus', 'Layanan::hapus');
    $routes->post('layanan/formuploadfile', 'Layanan::formuploadfile');
    $routes->post('layanan/douploadFileUnduh', 'Layanan::douploadFileUnduh');
    $routes->post('layanan/hapusfile', 'Layanan::hapusfile');
    $routes->post('layanan/hapusall', 'Layanan::hapusall');
    $routes->post('layanan/formlihatlayanan', 'Layanan::formlihatlayanan');

    // agenda
    $routes->get('agenda', 'Agenda::index');
    $routes->get('agenda/all', 'Agenda::all');
    $routes->get('agenda/getdata', 'Agenda::getdata');
    $routes->get('agenda/formtambah', 'Agenda::formtambah');
    $routes->post('agenda/simpanAgenda', 'Agenda::simpanAgenda');
    $routes->post('agenda/formedit', 'Agenda::formedit');
    $routes->post('agenda/formlihatagenda', 'Agenda::formlihatagenda');
    $routes->post('agenda/updateagenda', 'Agenda::updateagenda');
    $routes->post('agenda/formgantifoto', 'Agenda::formgantifoto');
    $routes->post('agenda/douploadAgenda', 'Agenda::douploadAgenda');
    $routes->post('agenda/hapus', 'Agenda::hapus');
    $routes->post('agenda/formuploadfile', 'Agenda::formuploadfile');
    $routes->post('agenda/douploadFileUnduh', 'Agenda::douploadFileUnduh');
    $routes->post('agenda/hapusfile', 'Agenda::hapusfile');
    $routes->post('agenda/hapusall', 'Agenda::hapusall');

    // bankdata
    $routes->get('bankdata', 'Bankdata::index');
    $routes->get('bankdata/all', 'Bankdata::all');
    $routes->get('bankdata/getdata', 'Bankdata::getdata');
    $routes->get('bankdata/formtambah', 'Bankdata::formtambah');
    $routes->post('bankdata/simpanBankData', 'Bankdata::simpanBankData');
    $routes->post('bankdata/formedit', 'Bankdata::formedit');
    $routes->post('bankdata/updatebankdata', 'Bankdata::updatebankdata');
    $routes->post('bankdata/formgantifoto', 'Bankdata::formgantifoto');
    $routes->post('bankdata/hapus', 'Bankdata::hapus');
    $routes->post('bankdata/formuploadfile', 'Bankdata::formuploadfile');
    $routes->post('bankdata/douploadbankdata', 'Bankdata::douploadbankdata');
    $routes->post('bankdata/hapusfile', 'Bankdata::hapusfile');
    $routes->post('bankdata/hapusall', 'Bankdata::hapusall');
    $routes->get('bankdata/getbankdata', 'Bankdata::getbankdata');
    $routes->get('download/(:segment)', 'Bankdata::download/$1');

    // pengumuman
    $routes->get('pengumuman', 'Pengumuman::index');
    $routes->get('pengumuman/all', 'Pengumuman::all');
    $routes->get('pengumuman/getdata', 'Pengumuman::getdata');
    $routes->get('pengumuman/formtambah', 'Pengumuman::formtambah');
    $routes->post('pengumuman/simpanPengumuman', 'Pengumuman::simpanPengumuman');
    $routes->post('pengumuman/formedit', 'Pengumuman::formedit');
    $routes->post('pengumuman/formlihatpengumuman', 'Pengumuman::formlihatpengumuman');
    $routes->post('pengumuman/updatePengumuman', 'Pengumuman::updatePengumuman');
    $routes->post('pengumuman/formgantifoto', 'Pengumuman::formgantifoto');
    $routes->post('pengumuman/douploadFileUnduh', 'Pengumuman::douploadFileUnduh');
    $routes->post('pengumuman/hapus', 'Pengumuman::hapus');
    $routes->post('pengumuman/formuploadfile', 'Pengumuman::formuploadfile');
    $routes->post('pengumuman/hapusfile', 'Pengumuman::hapusfile');
    $routes->post('pengumuman/hapusall', 'Pengumuman::hapusall');
    $routes->post('pengumuman/douploadPengumuman', 'Pengumuman::douploadPengumuman');
    $routes->post('pengumuman/updatepengumuman', 'Pengumuman::updatepengumuman');

    // produk hukum
    $routes->get('produkhukum', 'Produkhukum::index');
    $routes->get('produkhukum/all', 'Produkhukum::all');
    $routes->get('produkhukum/getdata', 'Produkhukum::getdata');
    $routes->get('produkhukum/formtambah', 'Produkhukum::formtambah');
    $routes->post('produkhukum/simpanprodukhukum', 'Produkhukum::simpanprodukhukum');
    $routes->post('produkhukum/formedit', 'Produkhukum::formedit');
    $routes->post('produkhukum/updateproduk', 'Produkhukum::updateproduk');
    $routes->post('produkhukum/hapus', 'Produkhukum::hapus');
    // subprodukhukum
    $routes->get('produkhukum/subproduk/(:segment)', 'Produkhukum::subproduk/$1');
    $routes->get('produkhukum/subprodukajx/', 'Produkhukum::subprodukajx');
    $routes->get('produkhukum/formtambahsubproduk/', 'Produkhukum::formtambahsubproduk');
    $routes->post('produkhukum/simpanSubproduk', 'Produkhukum::simpanSubproduk');
    $routes->post('produkhukum/formeditsub', 'Produkhukum::formeditsub');
    $routes->post('produkhukum/updatesubproduk', 'Produkhukum::updatesubproduk');
    $routes->post('produkhukum/formuploadfile', 'Produkhukum::formuploadfile');
    $routes->post('produkhukum/douploadsubproduk', 'Produkhukum::douploadsubproduk');
    $routes->post('produkhukum/hapussub', 'Produkhukum::hapussub');
    $routes->post('produkhukum/hapussuball', 'Produkhukum::hapussuball');

    // subsubprodukhukum
    $routes->get('produkhukum/detailsubproduk/(:segment)', 'Produkhukum::detailsubproduk/$1');
    $routes->get('produkhukum/subsubprodukajx/', 'Produkhukum::subsubprodukajx');
    $routes->get('produkhukum/formtambahsubsubproduk/', 'Produkhukum::formtambahsubsubproduk');
    $routes->post('produkhukum/simpanSubsubproduk', 'Produkhukum::simpanSubsubproduk');
    $routes->post('produkhukum/formeditsubsub', 'Produkhukum::formeditsubsub');
    $routes->post('produkhukum/updatesubsubproduk', 'Produkhukum::updatesubsubproduk');
    $routes->post('produkhukum/formuploadsubfile', 'Produkhukum::formuploadsubfile');
    $routes->post('produkhukum/douploadsubsubproduk', 'Produkhukum::douploadsubsubproduk');
    $routes->post('produkhukum/hapussubsub', 'Produkhukum::hapussubsub');
    $routes->post('produkhukum/hapussubsuball', 'Produkhukum::hapussubsuball');

    //    kategori foto
    $routes->get('foto', 'Foto::index');
    $routes->get('foto/all', 'Foto::all');
    $routes->get('foto/getdata', 'Foto::getdata');
    $routes->get('foto/formkategori', 'Foto::formkategori');
    $routes->post('foto/simpankategori', 'Foto::simpankategori');
    $routes->post('foto/formeditkategori', 'Foto::formeditkategori');
    $routes->post('foto/updatekategori', 'Foto::updatekategori');
    $routes->post('foto/hapuskategori', 'Foto::hapuskategori');
    $routes->post('foto/ganticoverkat', 'Foto::ganticoverkat');
    $routes->post('foto/douploadcover', 'Foto::douploadcover');

    // detail foto 1

    $routes->get('foto/det/(:segment)', 'Foto::det/$1');
    $routes->get('foto/detail/(:segment)', 'Foto::detail/$1');
    $routes->post('foto/getdetailft', 'Foto::getdetailft');
    $routes->get('foto/formtambah', 'Foto::formtambah');
    $routes->post('foto/formlihatfoto', 'Foto::formlihatfoto');

    $routes->post('foto/formedit', 'Foto::formedit');
    $routes->post('foto/updatefoto', 'Foto::updatefoto');
    $routes->post('foto/hapus', 'Foto::hapus');
    $routes->post('foto/hapusall', 'Foto::hapusall');
    $routes->post('foto/uploadmulti', 'Foto::uploadmulti');
    $routes->post('foto/simpanmulti', 'Foto::simpanmulti');
    // video
    $routes->get('video', 'Video::index');
    $routes->get('video/all', 'Video::all');
    $routes->get('video/getdata', 'Video::getdata');
    $routes->get('video/formtambah', 'Video::formtambah');
    $routes->post('video/uploadvideo', 'Video::uploadvideo');
    $routes->post('video/toggle', 'Video::toggle');
    $routes->post('video/uploadvideomulti', 'Video::uploadvideomulti');
    $routes->post('video/simpanmulti', 'Video::simpanmulti');
    $routes->post('video/formedit', 'Video::formedit');
    $routes->post('video/updatevideo', 'Video::updatevideo');
    $routes->post('video/hapus', 'Video::hapus');
    $routes->post('video/hapusall', 'Video::hapusall');
    $routes->get('video/detail/(:segment)', 'Video::detail/$1');
    // kategori video
    $routes->get('video/kategori', 'Video::kategori');
    $routes->get('video/getkategori', 'Video::getkategori');
    $routes->get('video/formkategori', 'Video::formkategori');
    $routes->post('video/simpankategori', 'Video::simpankategori');
    $routes->post('video/formeditkategori', 'Video::formeditkategori');
    $routes->post('video/updatekategori', 'Video::updatekategori');
    $routes->post('video/hapuskategori', 'Video::hapuskategori');

    // modal
    $routes->get('penawaran', 'Penawaran::index');
    $routes->get('penawaran/lihathasiladmin', 'Penawaran::lihathasiladmin');
    $routes->post('penawaran/formuploadtawaran', 'Penawaran::formuploadtawaran');
    $routes->post('penawaran/douploadlogo', 'Penawaran::douploadlogo');
    $routes->post('penawaran/submit', 'Penawaran::submit');

    // template
    $routes->get('template', 'Template::index');
    $routes->get('template/getdata', 'Template::getdata');
    $routes->post('template/toggle', 'Template::toggle');

    $routes->get('template/front', 'Template::front');
    $routes->get('template/formtambah', 'Template::formtambah');
    $routes->get('template/getdatafront', 'Template::getdatafront');
    $routes->post('template/simpantemplate', 'Template::simpantemplate');
    $routes->post('template/updatetemplate', 'Template::updatetemplate');

    $routes->post('template/formedit', 'Template::formedit');
    $routes->post('template/hapus', 'Template::hapus');

    $routes->get('template/back', 'Template::back');
    $routes->get('template/formtambahback', 'Template::formtambahback');
    $routes->post('template/simpantemplateback', 'Template::simpantemplateback');
    $routes->get('template/getdataback', 'Template::getdataback');
    $routes->post('template/formeditback', 'Template::formeditback');
    $routes->post('template/updatetemplateback', 'Template::updatetemplateback');
    $routes->post('template/hapusback', 'Template::hapusback');
    $routes->post('template/toggleback', 'Template::toggleback');

    // kritik
    $routes->get('kritiksaran/list', 'Kritiksaran::list');
    $routes->get('kritiksaran/getdata', 'Kritiksaran::getdata');
    $routes->post('kritiksaran/toggle', 'Kritiksaran::toggle');
    $routes->post('kritiksaran/formedit', 'Kritiksaran::formedit');
    $routes->post('kritiksaran/updatestatus', 'Kritiksaran::updatestatus');
    $routes->post('kritiksaran/hapus', 'Kritiksaran::hapus');
    $routes->post('kritiksaran/hapusall', 'Kritiksaran::hapusall');
    $routes->post('kritiksaran/simpankritik', 'Kritiksaran::simpankritik');
    $routes->get('kritiksaran/getdatanew', 'Kritiksaran::getdatanew');

    $routes->get('suaraanda', 'Kritiksaran::suaraanda', ['as' => 'suaraanda']);
    $routes->get('masukansaran', 'Kritiksaran::masukansaran', ['as' => 'masukansaran']);
    $routes->get('kritiksaran', 'Kritiksaran::masukansaran', ['as' => 'kritiksaran']);

    // menu
    $routes->get('menu', 'Menu::index');
    $routes->post('menu/getmenu', 'Menu::getmenu');
    $routes->post('menu/hapusmenu', 'Menu::hapusmenu');
    $routes->post('menu/simpanmenu', 'Menu::simpanmenu');
    $routes->post('menu/toggle', 'Menu::toggle');
    $routes->post('menu/formeditmenu', 'Menu::formeditmenu');
    $routes->post('menu/updatemenu', 'Menu::updatemenu');
    $routes->get('menu/formmenu', 'Menu::formmenu');
    // submenu
    $routes->get('submenu/(:segment)', 'Menu::submenu/$1');
    $routes->post('menu/getsubmenu', 'Menu::getsubmenu');
    $routes->post('menu/formeditsubmenu', 'Menu::formeditsubmenu');
    $routes->post('menu/updatesubmenu', 'Menu::updatesubmenu');
    $routes->post('menu/hapussubmenu', 'Menu::hapussubmenu');
    $routes->get('menu/formsubmenu', 'Menu::formsubmenu');
    $routes->post('menu/simpansubmenu', 'Menu::simpansubmenu');
    $routes->post('menu/togglesub', 'Menu::togglesub');

    // subsubmenu
    $routes->get('subsubmenu/(:segment)', 'Menu::subsubmenu/$1');
    $routes->post('menu/getsubsubmenu', 'Menu::getsubsubmenu');
    $routes->post('menu/formeditsubsubmenu', 'Menu::formeditsubsubmenu');
    $routes->post('menu/updatesubsubmenu', 'Menu::updatesubsubmenu');
    $routes->post('menu/hapussubsubmenu', 'Menu::hapussubsubmenu');
    $routes->get('menu/formsubsubmenu', 'Menu::formsubsubmenu');
    $routes->post('menu/simpansubsubmenu', 'Menu::simpansubsubmenu');
    $routes->post('menu/togglesubsub', 'Menu::togglesubsub');

    // seconmenu
    $routes->get('menu/formmenusec', 'Menu::formmenusec');
    $routes->post('menu/formeditmenusec', 'Menu::formeditmenusec');
    $routes->post('menu/updatemenusec', 'Menu::updatemenusec');
    $routes->post('menu/simpanmenusec', 'Menu::simpanmenusec');

    // berita
    $routes->get('add-new', 'Berita::tambahbaru');
    $routes->get('ubah/(:segment)', 'Berita::editberita/$1');
    $routes->get('berita/all', 'Berita::all');
    $routes->get('berita/getdata', 'Berita::getdata');
    $routes->post('berita/listdata2', 'Berita::listdata2');
    $routes->post('berita/formedit', 'Berita::formedit');
    $routes->post('berita/toggle', 'Berita::toggle');
    $routes->post('berita/toggleutm', 'Berita::toggleutm');
    $routes->post('berita/togglepil', 'Berita::togglepil');
    $routes->post('berita/updateberita', 'Berita::updateberita');
    $routes->post('berita/hapus', 'Berita::hapus');
    $routes->post('berita/hapusall', 'Berita::hapusall');
    $routes->post('berita/formgantifoto', 'Berita::formgantifoto');
    $routes->post('berita/douploadBerita', 'Berita::douploadBerita');

    $routes->get('berita/formtambah', 'Berita::formtambah');
    $routes->post('berita/simpanBerita', 'Berita::simpanBerita');
    $routes->get('berita/formkategori', 'Berita::formkategori');
    $routes->post('berita/simpankategori', 'Berita::simpankategori');
    $routes->get('berita/allkategori', 'Berita::allkategori');
    $routes->get('berita/getkategori', 'Berita::getkategori');
    $routes->post('berita/formeditkategori', 'Berita::formeditkategori');
    $routes->post('berita/updatekategori', 'Berita::updatekategori');
    $routes->post('berita/formeditposkategori', 'Berita::formeditposkategori');
    $routes->post('berita/updateposkategori', 'Berita::updateposkategori');
    $routes->post('berita/hapuskategori', 'Berita::hapuskategori');

    $routes->get('berita/alltag', 'Berita::alltag');
    $routes->get('berita/gettag', 'Berita::gettag');
    $routes->get('berita/formtag', 'Berita::formtag');
    $routes->post('berita/simpantag', 'Berita::simpantag');
    $routes->post('berita/formedittag', 'Berita::formedittag');
    $routes->post('berita/updatetag', 'Berita::updatetag');
    $routes->post('berita/hapustag', 'Berita::hapustag');

    $routes->get('berita/listkomen', 'Berita::listkomen');
    $routes->get('berita/getdatakomen', 'Berita::getdatakomen');
    $routes->get('berita/getkomennew', 'Berita::getkomennew');
    $routes->post('berita/formkomenback', 'Berita::formkomenback');
    $routes->post('berita/updatekomentar', 'Berita::updatekomentar');
    $routes->post('berita/hapuskomenall', 'Berita::hapuskomenall');
    $routes->post('berita/hapuskomen', 'Berita::hapuskomen');
    $routes->post('berita/simpankomen', 'Berita::simpankomen');
    $routes->get('berita', 'Berita::index', ['as' => 'berita']);
    $routes->get('berita/likeposting', 'Berita::likeposting');
    $routes->post('berita/simpantagpilihan', 'Berita::simpantagpilihan');
    // $routes->get('cari/berita', 'Cari::berita');
    $routes->get('cari', 'Cari::berita');
    $routes->get('search', 'Cari::index');
    $routes->post('search', 'Cari::index');
    $routes->post('cari/buku', 'Cari::buku');

    $routes->get('artikel', 'Berita::index', ['as' => 'artikel']);
    $routes->get('category/(:segment)', 'Berita::kategori/$1');

    $routes->get('detail/(:segment)', 'Berita::detail/$1');
    $routes->get('tag/(:segment)/(:segment)', 'Berita::tag/$1/$2');
    $routes->get('tagar/(:segment)', 'Berita::tag/$1/$2');
    $routes->get('tagar/(:segment)', 'Berita::tag/$1');
    $routes->get('author/(:segment)/(:segment)', 'Berita::author/$1/$2');
    $routes->get('unit/(:segment)/(:segment)', 'Berita::opd/$1/$2');
    $routes->get('post/(:segment)', 'Berita::detail/$1');
    // halaman
    $routes->get('halaman', 'Halaman::index');
    $routes->get('halaman/getdata', 'Halaman::getdata');
    $routes->post('halaman/listdata2', 'Halaman::listdata2');
    $routes->post('halaman/formedit', 'Halaman::formedit');
    $routes->post('halaman/updateprofil', 'Halaman::updateprofil');
    $routes->get('halaman/formtambah', 'Halaman::formtambah');
    $routes->post('halaman/simpanHalaman', 'Halaman::simpanHalaman');
    $routes->post('halaman/hapus', 'Halaman::hapus');
    $routes->post('halaman/toggle', 'Halaman::toggle');
    $routes->post('halaman/formgantifoto', 'Halaman::formgantifoto');
    $routes->post('halaman/douploadBerita', 'Halaman::douploadBerita');
    $routes->post('halaman/formgantipdf', 'Halaman::formgantipdf');
    $routes->post('halaman/douploadpdf', 'Halaman::douploadpdf');
    $routes->post('halaman/hapuspdf', 'Halaman::hapuspdf');
    $routes->post('halaman/hapusall', 'Halaman::hapusall');
    $routes->get('page/(:segment)', 'Halaman::detail/$1');

    // $routes->get('sekolah-kejar-paket-a', 'Halaman::det');
    // $routes->get('sekolah-kejar-paket-b', 'Halaman::det');
    // $routes->get('sekolah-kejar-paket-c', 'Halaman::det');
    // $routes->get('home-schooling', 'Halaman::det');

    // link terkait
    $routes->get('linkterkait', 'Linkterkait::index');
    $routes->get('linkterkait/getdata', 'Linkterkait::getdata');
    $routes->post('linkterkait/toggle', 'Linkterkait::toggle');
    $routes->get('linkterkait/formtambah', 'Linkterkait::formtambah');
    $routes->post('linkterkait/simpanLink', 'Linkterkait::simpanLink');
    $routes->post('linkterkait/formedit', 'Linkterkait::formedit');
    $routes->post('linkterkait/updatelinkterkait', 'Linkterkait::updatelinkterkait');
    $routes->post('linkterkait/formgantifoto', 'Linkterkait::formgantifoto');
    $routes->post('linkterkait/douploadLink', 'Linkterkait::douploadLink');
    $routes->post('linkterkait/hapusall', 'Linkterkait::hapusall');
    $routes->post('linkterkait/hapus', 'Linkterkait::hapus');

    // transparansi
    $routes->get('transparansi', 'Transparansi::index');
    $routes->get('transparansi/list', 'Transparansi::list');
    $routes->get('transparansi/getdata', 'Transparansi::getdata');
    $routes->post('transparansi/listdata', 'Transparansi::listdata');
    $routes->post('transparansi/formedit', 'Transparansi::formedit');
    $routes->post('transparansi/updatedata', 'Transparansi::updatedata');
    $routes->post('transparansi/toggledef', 'Transparansi::toggledef');
    $routes->post('transparansi/toggle', 'Transparansi::toggle');
    $routes->get('transparansi/formtambah', 'Transparansi::formtambah');
    $routes->post('transparansi/simpantransparansi', 'Transparansi::simpantransparansi');
    $routes->post('transparansi/hapus', 'Transparansi::hapus');
    $routes->post('transparansi/TampilkanGrafikAll', 'Transparansi::TampilkanGrafikAll');
    $routes->post('transparansi/TampilkanGrafik', 'Transparansi::TampilkanGrafik');

    // detail trans
    $routes->get('transparansi/detail/(:segment)', 'Transparansi::detail/$1');
    $routes->get('transparansi/detailajx', 'Transparansi::detailajx');
    $routes->get('transparansi/formtambahsubproduk', 'Transparansi::formtambahsubproduk');
    $routes->post('transparansi/simpanDetail', 'Transparansi::simpanDetail');
    $routes->post('transparansi/formeditdetail', 'Transparansi::formeditdetail');
    $routes->post('transparansi/updatedetail', 'Transparansi::updatedetail');
    $routes->post('transparansi/hapusdetail', 'Transparansi::hapusdetail');
    $routes->post('transparansi/hapusdetailall', 'Transparansi::hapusdetailall');

    // fasilitas
    $routes->get('fasilitas', 'Fasilitas::index');
    $routes->get('fasilitas/list', 'Fasilitas::list');
    $routes->get('fasilitas/getdata', 'Fasilitas::getdata');
    $routes->get('fasilitas/formtambah', 'Fasilitas::formtambah');
    $routes->post('fasilitas/simpanfasilitas', 'Fasilitas::simpanfasilitas');
    $routes->post('fasilitas/formeditfasilitas', 'Fasilitas::formeditfasilitas');
    $routes->post('fasilitas/updatefasilitas', 'Fasilitas::updatefasilitas');
    $routes->post('fasilitas/toggledef', 'Fasilitas::toggledef');
    $routes->post('fasilitas/ganticoverfas', 'Fasilitas::ganticoverfas');
    $routes->post('fasilitas/douploadcover', 'Fasilitas::douploadcover');
    $routes->post('fasilitas/hapusfasilitas', 'Fasilitas::hapusfasilitas');
    // detail fasilitas
    $routes->get('fasilitas/detail/(:segment)', 'Fasilitas::detail/$1');
    $routes->get('fasilitas/det/(:segment)', 'Fasilitas::det/$1');
    $routes->get('fasilitas/detailajx', 'Fasilitas::detailajx');
    $routes->get('fasilitas/formtambahdetail', 'Fasilitas::formtambahdetail');
    $routes->post('fasilitas/formeditdetail', 'Fasilitas::formeditdetail');
    $routes->post('fasilitas/uploadfotodetail', 'Fasilitas::uploadfotodetail');
    $routes->post('fasilitas/updatefotodet', 'Fasilitas::updatefotodet');
    $routes->post('fasilitas/hapusdetailall', 'Fasilitas::hapusdetailall');
    $routes->post('fasilitas/hapusdetail', 'Fasilitas::hapusdetail');

    // counter
    $routes->get('counter', 'Counter::index');
    $routes->get('counter/list', 'Counter::list');
    $routes->get('counter/getdata', 'Counter::getdata');
    $routes->post('counter/formedit', 'Counter::formedit');
    $routes->post('counter/updatedata', 'Counter::updatedata');
    $routes->post('counter/toggle', 'Counter::toggle');
    $routes->get('counter/formtambah', 'Counter::formtambah');
    $routes->post('counter/simpan', 'Counter::simpan');
    $routes->post('counter/hapus', 'Counter::hapus');

    // infografis
    $routes->get('infografis', 'Infografis::index');
    $routes->get('infografis/all', 'Infografis::all');
    $routes->get('infografis/getdata', 'Infografis::getdata');
    $routes->post('infografis/formedit', 'Infografis::formedit');
    $routes->post('infografis/formlihatinfo', 'Infografis::formlihatinfo');
    $routes->post('infografis/updateinfografis', 'Infografis::updateinfografis');
    $routes->get('infografis/formtambah', 'Infografis::formtambah');
    $routes->post('infografis/uploadfoto', 'Infografis::uploadfoto');
    $routes->post('infografis/hapus', 'Infografis::hapus');
    $routes->post('infografis/hapusall', 'Infografis::hapusall');

    // section
    $routes->get('section', 'Section::index');
    $routes->get('section/list', 'Section::list');
    $routes->get('section/getdata', 'Section::getdata');
    $routes->post('section/formedit', 'Section::formedit');
    $routes->post('section/updatesection', 'Section::updatesection');
    $routes->get('section/formtambah', 'Section::formtambah');
    $routes->post('section/uploadFoto', 'Section::uploadFoto');
    $routes->post('section/hapus', 'Section::hapus');
    $routes->post('section/hapusall', 'Section::hapusall');

    // unit kerja
    $routes->get('unitkerja', 'Unitkerja::index');
    $routes->get('unitkerja/getdata', 'Unitkerja::getdata');
    $routes->post('unitkerja/formedit', 'Unitkerja::formedit');
    $routes->post('unitkerja/updatepenerbit', 'Unitkerja::updatepenerbit');
    $routes->get('unitkerja/formtambah', 'Unitkerja::formtambah');
    $routes->post('unitkerja/simpan', 'Unitkerja::simpan');
    $routes->post('unitkerja/hapus', 'Unitkerja::hapus');
    $routes->post('unitkerja/hapusall', 'Unitkerja::hapusall');

    $routes->get('unitkerja/tipe', 'Unitkerja::tipe');
    $routes->get('unitkerja/gettipe', 'Unitkerja::gettipe');
    $routes->post('unitkerja/formedittipe', 'Unitkerja::formedittipe');
    $routes->post('unitkerja/updatetipe', 'Unitkerja::updatetipe');
    $routes->get('unitkerja/formtipe', 'Unitkerja::formtipe');
    $routes->post('unitkerja/simpantipe', 'Unitkerja::simpantipe');
    $routes->post('unitkerja/hapustipe', 'Unitkerja::hapustipe');


    $routes->get('user', 'User::index');
    $routes->get('user/getdata', 'User::getdata');

    $routes->get('user/formtambah', 'User::formtambah');
    $routes->post('user/formlihat', 'User::formlihat');
    $routes->post('user/simpanUser', 'User::simpanUser');
    $routes->post('user/toggle', 'User::toggle');
    $routes->post('user/formedit', 'User::formedit');
    $routes->post('user/updateuser', 'User::updateuser');
    $routes->post('user/hapusall', 'User::hapusall');
    $routes->post('user/hapus', 'User::hapus');
    $routes->post('user/formgantifoto', 'User::formgantifoto');
    $routes->post('user/douploaduser', 'User::douploaduser');

    // grup
    $routes->get('user/grup', 'User::grup');
    $routes->get('user/getgrup', 'User::getgrup');
    $routes->get('user/formgrup', 'User::formgrup');

    $routes->post('user/formaddmenugrup', 'User::formaddmenugrup');
    $routes->post('user/simpangrupmenu', 'User::simpangrupmenu');
    $routes->post('user/simpangrup', 'User::simpangrup');
    $routes->post('user/formlihatakses', 'User::formlihatakses');
    $routes->post('user/formeditgrupnm', 'User::formeditgrupnm');
    $routes->post('user/updategrupnm', 'User::updategrupnm');
    $routes->post('user/formeditmenugrup', 'User::formeditmenugrup');
    $routes->post('user/updatemenu', 'User::updatemenu');
    $routes->post('user/formeditgrup', 'User::formeditgrup');
    $routes->post('user/updategrup', 'User::updategrup');
    $routes->post('user/hapusgrup', 'User::hapusgrup');

    // auth
    $routes->get('login', 'Login::index');
    $routes->get('akun', 'Akun::index');
    $routes->post('akun/douploaduser', 'Akun::douploaduser');
    $routes->post('akun/updateuser', 'Akun::updateuser');
    $routes->post('akun/formgantifoto', 'Akun::formgantifoto');


    $routes->get('registrasi', 'Login::registrasi', ['as' => 'registrasi']);
    $routes->post('login/proseslupa', 'Login::proseslupa');
    $routes->post('login/prosesgantipass', 'Login::prosesgantipass');
    $routes->post('login/daftarakun', 'Login::daftarakun');
    $routes->get('daftarakun?(:segment)', 'Login::daftarakun/$1', ['as' => 'daftarakun']);

    $routes->post('login/logout', 'Login::logout');
    $routes->post('login/validasi', 'Login::validasi');
    $routes->get('admin/getonline', 'Admin::getonline');
    $routes->get('admin/hapusfile', 'Admin::hapusfile');

    $routes->post('admin/TampilkanGrafik', 'Admin::TampilkanGrafik');
    $routes->get('dashboard', 'Admin::index');
    $routes->get('admin/offuser', 'Admin::offuser');

    // Forgotten password
    $routes->get('lupapassword', 'Login::lupapassword', ['as' => 'lupapassword']);
    $routes->get('resetpassword?(:segment)', 'Login::resetpassword/$1', ['as' => 'resetpassword']);
    // dokumen

    $routes->get('dokumen', 'Dokumen::index');
    $routes->get('dokumen/getdata', 'Dokumen::getdata');
    $routes->post('dokumen/listdata2', 'Dokumen::listdata2');
    $routes->post('dokumen/formtambah', 'Dokumen::formtambah');
    $routes->post('dokumen/simpanDokumen', 'Dokumen::simpanDokumen');
    $routes->post('dokumen/hapus', 'Dokumen::hapus');
    $routes->post('dokumen/hapusall', 'Dokumen::hapusall');
    $routes->post('dokumen/formedit', 'Dokumen::formedit');
    $routes->post('dokumen/updatedokumen', 'Dokumen::updatedokumen');
    $routes->post('dokumen/formuploadfile', 'Dokumen::formuploadfile');
    $routes->post('dokumen/douploaddokumen', 'Dokumen::douploaddokumen');
    $routes->get('dokumen/kategori', 'Dokumen::kategori');

    $routes->post('dokumen/getkategori', 'Dokumen::getkategori');
    $routes->post('dokumen/getkategori', 'Dokumen::getkategori');
    $routes->post('dokumen/formkategori', 'Dokumen::formkategori');
    $routes->post('dokumen/simpankategori', 'Dokumen::simpankategori');
    $routes->post('dokumen/formeditkategori', 'Dokumen::formeditkategori');
    $routes->post('dokumen/updatekategori', 'Dokumen::updatekategori');
    $routes->post('dokumen/hapuskategori', 'Dokumen::hapuskategori');
    $routes->get('(:segment)', 'Berita::detail/$1');
});
