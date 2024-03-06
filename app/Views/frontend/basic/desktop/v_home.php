<?= $this->extend('frontend/' . $folder . '/desktop' . '/template-frontend') ?>
<?= $this->extend('frontend/' . $folder . '/desktop' . '/v_menu') ?>

<?= $this->section('content');
$db = \Config\Database::connect();
?>
<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />
<!-- Page-Title -->
<div class="page-title-box p-4">
    <div class="container-fluid">
    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="container-fluid pb-0">
                <div class="card p-0" style="border-radius: 20px">
                    <!-- berita utama -->
                    <!-- <div class="box-shadow">
                        <div class="section-heading">

                            <div class="title-konten text-uppercase font-size-18 mb-3">BERITA UTAMA</div>
                        </div>
                    </div> -->
                    <div id="beritautama" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php $no = 0;
                            foreach ($beritautama as $key => $value) { ?>
                                <!-- <li data-target="#beritautama" data-slide-to="<?= $no++ ?>" class="<?= ($no == 1) ? 'active' : '' ?>"></li> -->

                            <?php } ?>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <?php $no = 0;
                            foreach ($beritautama as $key => $data) {
                                $no++;
                                $opd_id2 = $data['opd_id'];
                                $viewopd2 = $db->table('custome__opd')->where('opd_id', $opd_id2)->where('opd_id !=', 0)->get()->getRowArray();

                            ?>
                                <div class="<?= ($no == 1) ? 'carousel-item active' : 'carousel-item' ?>">
                                    <div class="bg-white rounded">
                                        <div class="px-3 kategori bg-danger">
                                            <div class="text-light"><?= $data['nama_kategori'] ?> </div>
                                        </div>
                                    </div>
                                    <a href="<?= base_url('detail/' . $data['slug_berita']) ?>">
                                        <img class="d-block image1 rounded" src="<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?>" width="100%" alt="First slide">
                                    </a>
                                    <div class="ketberita">
                                        <!-- <div class="d-none d-sm-block"> -->
                                        <p class="d-none d-sm-block" style="color:#fff;font-size: 15px;line-height: 1.82;font-weight: 400;">
                                            <!-- </div> -->
                                            <span class="align-top">
                                                <a href="<?= base_url('detail/' . $data['slug_berita']) ?>" style="color:#EDD212; font-size: 20px; ">
                                                    <?= $data['judul_berita'] ?>
                                                </a>
                                                <br>
                                                <i class="far fa-calendar-alt"></i> <?= longdate_indo($data['tgl_berita']) ?>
                                                <?php if ($viewopd2) {
                                                    if ($viewopd2['opd_id'] != 0) { ?>
                                                        <i class="far fa-building"></i> <a class="text-light" href="<?= base_url('unit/' . $viewopd2['opd_id'] . '/' . $viewopd2['nama_opd']) ?>"><?= $viewopd2['nama_opd'] ?></a>
                                                <?php  }
                                                } ?>
                                            </span>
                                        </p>
                                        <p class="d-block d-sm-none" style="color:#fff;font-size: 10px;line-height: 1.52;font-weight: 400;">
                                            <!-- </div> -->
                                            <span class="align-top p-1">
                                                <a href="<?= base_url('detail/' . $data['slug_berita']) ?>" style="color:#EDD212; font-size: 12px; ">
                                                    <?= $data['judul_berita'] ?>
                                                </a>
                                                <br>
                                                <i class="far fa-calendar-alt"></i> <?= longdate_indo($data['tgl_berita']) ?>
                                                <?php if ($viewopd2) {
                                                    if ($viewopd2['opd_id'] != 0) { ?>
                                                        <i class="far fa-building"></i><a href="<?= base_url('unit/' . $viewopd2['opd_id'] . '/' . $viewopd2['singkatan_opd']) ?>"><?= $viewopd2['singkatan_opd'] ?></a>
                                                <?php  }
                                                } ?>
                                            </span>
                                        </p>
                                    </div>

                                </div>
                            <?php } ?>
                        </div>
                        <a class="carousel-control-prev" href="#beritautama" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#beritautama" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>

                    <!-- <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php $no = 0;
                            foreach ($banner as $key => $value) { ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $no++ ?>" class="<?= ($no == 1) ? 'active' : '' ?>"></li>

                            <?php } ?>
                        </ol>
                        <div class="carousel-inner" role="listbox"  style="border-radius: 20px">
                            <?php $no = 0;
                            foreach ($banner as $key => $value) {
                                $pot = substr($value['link'], 0, 5);
                                if ($pot == 'detai' || $pot == 'page/' || $pot == 'surve') {
                                    $linkbn = base_url($value['link']);
                                } else {
                                    $linkbn = ($value['link']);
                                }
                                $no++
                            ?>
                                <div class="<?= ($no == 1) ? 'carousel-item active' : 'carousel-item' ?>">
                                    <a href="<?= ($linkbn) ?>" title="<?= ($value['ket']) ?>">
                                        <img class="d-block img-fluid" src="<?= base_url('/public/img/banner/' . $value['banner_image']) ?>" width="100%" alt="First slide">
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div> -->

                    

                </div>

            </div>

            <div class="col-xl-9 pt-0">
                
                

                    <?php if ($konfigurasi->sts_section == '1') { ?>
                    <div class="card">
                        <section id="short-stat" class="short-stat">
                            <div class="title-konten text-uppercase font-size-18 mb-2"><?= $konfigurasi->judul_section ?> </div>
                            <div class="row m-1">

                                <?php foreach ($section as $data) {
                                    $sumber = $data['linksumber'];

                                    if ($sumber == 'N') {
                                        $link = base_url($data['link']);
                                    } else {
                                        $link = $data['link'];
                                    }

                                ?>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 p-2">
                                        <div class="count-box p-1 pointer">
                                            <a href="<?= $link ?>">
                                                <img src="<?= base_url('/public/img/section/' . $data['gambar']) ?>" alt="<?= $data['nama_section'] ?>" title="<?= $data['nama_section'] ?>" width="50" height="50">
                                                &nbsp;<?= $data['nama_section'] ?>
                                            </a>
                                        </div>
                                        <!-- <a href="<?= $link ?>" class="text-secondary"><?= $data['nama_section'] ?> <span><i class="fas fa-chevron-right"></i></span></a> -->
                                    </div>
                                <?php } ?>

                            </div>
                            <!-- </div> -->
                        </section>
                    </div>
                    <?php } ?>
                

                <!-- berita terbaru -->
                <div class="card">
                    <div class="card-body">

                        <!-- INFORMASI INSTANSI (BERITA DLL)-->
                        <div class="row">
                            <div class="col-md-12 pt-2 pb-3">
                                <div class="title-konten text-uppercase">Berita Terbaru</div>
                            </div>                            
                            <div class="col-md-12">
                                <?php $nomor = 0;
                                foreach ($terkini as $data) :
                                    $nomor++; ?>
                                    <div class="card border-light mb-3">
                                        <div class="row no-gutters">
                                            <div class="col-md-3 col-4 wraper-img-side">
                                                <img class="wraper-img-side" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> style="border-radius: 5px;">
                                            </div>

                                            <div class="col-md-9 col-8 pl-3">
                                                <a class="judul-side" href="<?php echo base_url('detail/' . $data['slug_berita']) ?>">
                                                    <div><?= $data['judul_berita'] ?></div>
                                                </a>
                                                <div class="post-side pt-2">
                                                    <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_berita']) ?> |
                                                    <i class="fa fa-eye"></i> <?= $data['hits'] ?> Kali
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                                
                            </div>
                        </div>


                        
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">

                        <!-- INFORMASI INSTANSI (BERITA DLL)-->
                        <div class="row">
                            <div class="col-md-12 pt-2 pb-3">
                                <div class="title-konten text-uppercase">Publikasi</div>
                            </div>
                            
                            <div class="col-md-12">
                                <ul class="nav nav-tabs nav-fill nav-pills" id="myTab" role="tablist">
                                    <li class="nav-item bg-warna-hijau">
                                        <a class="nav-link tab active" id="agenda-tab" data-toggle="tab" href="#agenda" role="tab" aria-controls="agenda" aria-selected="false">
                                            <i class="mdi mdi-timetable font-size-16 mr-1"></i><b>AGENDA</b></a>
                                    </li>
                                    
                                    <li class="nav-item mr-1">
                                        <a class="nav-link tab" id="layanan-tab" data-toggle="tab" href="#layanan" role="tab" aria-controls="layanan" aria-selected="false">
                                            <i class="mdi mdi-teach font-size-16 mr-1"></i><b>LAYANAN</b></a>
                                    </li>
                                    <li class="nav-item mr-1">
                                        <a class="nav-link tab" id="pengumuman-tab" data-toggle="tab" href="#pengumuman" role="tab" aria-controls="pengumuman" aria-selected="false">
                                            <i class="mdi mdi-bullhorn font-size-16 mr-1"></i><b>PENGUMUMAN</b></a>
                                    </li>
                                    
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    
                                    <!-- LAYANAN -->
                                    <div class="tab-pane fade" id="layanan" role="tabpanel" aria-labelledby="layanan-tab">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <?php $nomor = 0;
                                                foreach ($layanan as $data) :
                                                    $nomor++;
                                                    $pot = substr($data['isi_informasi'], 0, 20);

                                                ?>
                                                    <div class="list-group mt-2">
                                                        <a class="list-group-item list-group-item-action " onclick="lihatlayanan('<?= $data['informasi_id'] ?>')">
                                                            <div class="row no-gutters pointer">
                                                                <div class="media">
                                                                    <i class="fas fa-chalkboard-teacher float-left pr-3 list-icon mt-2"></i>
                                                                    <div class="media-body">
                                                                        <div class="list-judul"><?= $data['nama'] ?></div>
                                                                        <div class="list-posted">

                                                                            <i class="fas fa-user-alt"></i> <?= $data['fullname'] ?> |
                                                                            <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_informasi']) ?> |
                                                                            <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('layanan') ?>" class="btn btn-primary">Lihat Semua Layanan<i class="mdi mdi-arrow-right ml-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PENGUMUMAN -->
                                    <div class="tab-pane fade" id="pengumuman" role="tabpanel" aria-labelledby="pengumuman-tab">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <?php $nomor = 0;
                                                foreach ($pengumuman as $data) :
                                                    $nomor++; ?>
                                                    <div class="list-group mt-2">
                                                        <a class="list-group-item list-group-item-action" onclick="lihatpengumuman('<?= $data['informasi_id'] ?>')">
                                                            <div class="row no-gutters pointer">
                                                                <div class="media">
                                                                    <i class="fa fa-bullhorn float-left pr-3 list-icon mt-2"></i>
                                                                    <div class="media-body">
                                                                        <div class="list-judul"><?= $data['nama'] ?></div>
                                                                        <div class="list-posted">
                                                                            <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_informasi']) ?> |
                                                                            <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('pengumuman') ?>" class="btn btn-primary">Lihat Semua Pengumuman<i class="mdi mdi-arrow-right ml-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- AGENDA -->
                                    <div class="tab-pane fade  show active" id="agenda" role="tabpanel" aria-labelledby="agenda-tab">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <?php $nomor = 0;
                                                foreach ($agenda as $data) :
                                                    $nomor++; ?>

                                                    <div class="list-group mt-2">
                                                        <a class="list-group-item list-group-item-action pointer">
                                                            <div class="row no-gutters" onclick="lihatagenda('<?= $data['agenda_id'] ?>')">
                                                                <div class="media">
                                                                    <i class="far fa-calendar-check float-left pr-3 list-icon mt-2"></i>
                                                                    <div class="media-body">
                                                                        <div class="list-judul"> <?= $data['tema'] ?></div>
                                                                        <div class="list-posted">
                                                                            <i class="far fa-calendar-alt"></i>
                                                                            Dari : <?= date_indo($data['tgl_mulai']) ?> -
                                                                            Sampai : <?= date_indo($data['tgl_selesai']) ?>
                                                                            <i class="fas fa-map-marker-alt"></i>
                                                                            <?= $data['tempat'] ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('agenda') ?>" class="btn btn-primary">Lihat Semua Agenda<i class="mdi mdi-arrow-right ml-1"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- BANK DATA -->
                                    <div class="tab-pane fade" id="bankdata" role="tabpanel" aria-labelledby="bankdata-tab">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <?php $nomor = 0;
                                                foreach ($bankdata as $data) :
                                                    $nomor++; ?>
                                                    <div class="list-group mt-2">
                                                        <a href="<?= base_url('download/'  . $data['fileupload']); ?>" class="list-group-item list-group-item-action" onclick="updatehits('<?= $data['bankdata_id'] ?>')">
                                                            <div class="row no-gutters pointer">
                                                                <div class="media">
                                                                    <i class="fa fa-database float-left pr-3 list-icon mt-2"></i>
                                                                    <div class="media-body">
                                                                        <div class="list-judul"><?= $data['nama_bankdata'] ?></div>
                                                                        <div class="list-posted">
                                                                            <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_upload']) ?> |
                                                                            <i class="far fa-eye"></i> <?= $data['hits'] ?> kali
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php endforeach; ?>

                                            </div>
                                            <div class="col-md-12 text-center mt-3">
                                                <a href="<?= base_url('bankdata') ?>" class="btn btn-primary">Lihat Semua Data<i class="mdi mdi-arrow-right ml-1"></i></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>
                <!-- end berita -->
            </div>
            <!-- side kanan -->
            <div class="col-xl-3">

                <!-- sambutan -->
                <?php if ($konfigurasi->sts_sambutan == '1') { ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="title-konten text-uppercase font-size-18 mb-2"><?= $konfigurasi->jabatan_pimpinan ?> </div>

                            <div class="single-sidebar-widget pointer" data-toggle="modal" data-target="#modalViewsambutan">
                                <div class="text-center">
                                    <a rel="nofollow"><img class="img-thumbnail" src="<?= base_url('/public/img/konfigurasi/pimpinan/' . $konfigurasi->gbr_sambutan) ?>" title="Baca sambutan <?= $konfigurasi->jabatan_pimpinan ?>"></a>
                                </div>
                                <div class="text-center">

                                    <button type="submit" class="btn btn-light btn-sm text-uppercase mt-1" data-toggle="modal" data-target="#modalViewsambutan" title="Baca Sambutan <?= $konfigurasi->jabatan_pimpinan ?>">
                                        - <?= $konfigurasi->nama_pimpinan ?> -

                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php } ?>

                

                <!-- <p> -->

                <!-- Side Link terkait -->
                <div class="card">
                    <div class="card-body">
                        <div class="title-konten text-uppercase font-size-18 mb-3">Info Grafis</div>
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <?php $no = 0;
                                foreach ($infografis as $key => $value) { ?>
                                    <!-- <li data-target="#carouselExampleIndicators" data-slide-to="<?= $no++ ?>" class="<?= ($no == 1) ? 'active' : '' ?>"></li> -->

                                <?php } ?>
                            </ol>
                            <div class="carousel-inner" role="listbox">
                                <?php $no = 0;
                                foreach ($infografis as $key => $value) {
                                    $no++
                                ?>
                                    <div class="<?= ($no == 1) ? 'carousel-item active' : 'carousel-item' ?>">
                                        <div class=" wraper-info-new">
                                            <img class="img-thumbnail pointer" onclick="lihatinfo('<?= $value['id_banner'] ?>')" src="<?= base_url('public/img/informasi/infografis/' .  $value['banner_image']) ?>">
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- side kantor kami -->
                <div class="card">
                    <div class="card-body">
                        <div class="title-konten text-uppercase font-size-18 mb-3">Alamat</div>
                        <div>
                            <style type="text/css" media="screen">
                                iframe {
                                    height: 200px;
                                    width: 100%;
                                }
                            </style>
                            <?= $konfigurasi->google_map ?>
                        </div>

                    </div>
                </div>


            </div>

        </div>

    </div>

    <!-- end container -->

</div>

<!-- end page content -->

<div class="modal fade in" tabindex="-1" role="dialog" id="modalViewsambutan">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Sambutan
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>
            <div class="modal-body">
                <div class="card-body p-0">
                    <p style="text-align:justify; "><img src="<?= base_url('/public/img/konfigurasi/pimpinan/' . $konfigurasi->gbr_sambutan) ?>" style="float:left; padding: 8px;" height="180" class="img" /> <?= $konfigurasi->sambutan ?></p>
                </div>
                <div class="modal-footer p-0">
                    <div class="text-right">
                        <button type="button" class="btn btn-secondary " data-dismiss="modal">Ok</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php
if ($konfigurasi->sts_modal == '1') { ?>

    <script>
        $(document).ready(function() {
            penawaran();
        });
    </script>

<?php } ?>

<?= $this->endSection() ?>