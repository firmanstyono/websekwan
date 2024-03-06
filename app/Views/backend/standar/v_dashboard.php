<?= $this->section('content') ?>
<?= $this->extend('backend/' . $folder . '/' . 'script');
$db = \Config\Database::connect();
$userid = session()->get('id');
$list = $db->table('users')->where('id', $userid)->get()->getRowArray();

?>

<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />

<!-- <div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title text-light" style="text-shadow: 0 0 2px #000; ">Haloo.. <?= session()->get('fullname') ?> </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Selamat datang kembali, Dashboard siap digunakan..!</li>
            </ol>
            <div class="state-information d-none d-sm-block">
                <div class="alert alert-secondary bg-light" role="alert">
                    <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#petunjuk" data-backdrop="static"><i class="far fa-compass"></i> Panduan Penggunaan</button>
                    <label id="stsbuka"> Jika Anda mengalami kendala teknis dapat menghubungi kami <a href="https://api.whatsapp.com/send?phone=+6281353967028" target="_blank" class="alert-link">disini</a>.</lab>
                </div>

            </div>

        </div>
    </div>
</div> -->
<!-- end row -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box ">

        </div>
    </div>
</div>

<div class="page-content-wrapper">

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary mini-stat position-relative shadow-lg">
                <div class="card-body p-2">
                    <a class="mini-stat-desc" href="<?= base_url('berita/all') ?>">
                        <h6 class="text-uppercase verti-label text-white-50">Berita</h6>
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Berita</h6>
                            <h3 class="mb-3 mt-0"><?= $berita ?></h3>
                            <div class="">
                                <span class="badge badge-light text-danger" style="font-size:13px"><?= $kategori ?> </span> <span class="ml-2">Kategori Berita</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-cube-outline display-2"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning mini-stat position-relative shadow-lg">
                <div class="card-body p-2">
                    <a class="mini-stat-desc" href="<?= base_url('layanan/all') ?>">
                        <h6 class="text-uppercase verti-label text-white-50">Layanan</h6>
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Layanan</h6>
                            <h3 class="mb-3 mt-0"><?= $totlayanan ?></h3>
                            <div class="">
                                <span class="">Informasi Layanan</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-buffer display-2"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-secondary mini-stat position-relative shadow-lg">
                <div class="card-body p-2">
                    <a class="mini-stat-desc" href="<?= base_url('bankdata/all') ?>">
                        <h6 class="text-uppercase verti-label text-white-50">BankData</h6>
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Bank Data</h6>
                            <?php if ($bankdata) {
                                $bankdata = $bankdata['bankdata_id'];
                            } else {
                                $bankdata = 0;
                            } ?>
                            <h3 class="mb-3 mt-0"><?= $bankdata ?></h3>
                            <div class="">
                                <span class="">Informasi Bank Data</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-tag-text-outline display-2"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success mini-stat position-relative shadow-lg">
                <div class="card-body p-2">
                    <a class="mini-stat-desc" href="<?= base_url('pengumuman/all') ?>">
                        <h6 class="text-uppercase verti-label text-white-50">Infomasi</h6>
                        <div class="text-white">
                            <h6 class="text-uppercase mt-0 text-white-50">Pengumuman</h6>
                            <h3 class="mb-3 mt-0"><?= $totpengumuman ?></h3>
                            <div class="">
                                <span class="">Informasi Pengumuman</span>
                            </div>
                        </div>
                        <div class="mini-stat-icon">
                            <i class="mdi mdi-bullhorn display-2"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <?php

        if ($grupakses) { ?>
            <div class="col-12 d-none d-sm-block">
                <div class="card m-b-20">
                    <div class="card-header font-24 ">
                        <div class="btn-group float-center">
                            <a class="text-center" href="<?= base_url('konfigurasi') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fas fa-cogs font-24"></i><br>Konfigurasi</button>
                            </a>

                            <a class="text-center" href="<?= base_url('halaman') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="far fa-newspaper font-24 "></i><br>Halaman</button>
                            </a>
                            <a class="text-center" href="<?= base_url('menu') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fas fa-sitemap font-24 "></i><br>Menu</button>
                            </a>
                            <a class="text-center" href="<?= base_url('banner') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="far fa-window-restore font-24 "></i><br>Banner</button>
                            </a>

                            <a class="text-center" href="<?= base_url('sambutan') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fas fa-microphone-alt font-24 "></i><br>Sambutan</button>
                            </a>
                            <a class="text-center" href="<?= base_url('pegawai/all') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="far fa-id-card font-24 "></i><br>Data Pegawai</button>
                            </a>
                            <a class="text-center" href="<?= base_url('infografis/all') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fab fa-slideshare font-24 "></i><br>Info Grafis</button>
                            </a>
                            <a class="text-center" href="<?= base_url('linkterkait') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary  mr-1"><i class="fas fa-link font-24 "></i><br>Link Terkait</button>
                            </a>
                            <a class="text-center" href="<?= base_url('video/all') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="fab fa-youtube font-24 "></i><br>Galeri Video</button>
                            </a>
                            <a class="text-center" href="<?= base_url('foto/all') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary mr-1"><i class="far fa-images font-24 "></i><br>Galeri Foto</button>
                            </a>
                            <a class="text-center" href="<?= base_url('poling') ?>">
                                <button type="button" class="btn btn-outline-primary waves-effect waves-secondary"><i class="fas fa-chart-bar font-24 "></i><br>Data Poling</button>
                            </a>

                        </div>

                    </div>

                </div>
            </div> <!-- end col -->
        <?php } ?>


        <div class="container-fluid">
            <div class="row">

                <!--  -->

                <!-- AGENDA -->
                <?php
                if ($agenda) {
                    foreach ($agenda as $data) : ?>

                        <div class="col-xl-5 col-lg-5">
                            <div class="card directory-card m-b-20">
                                <div class="card-body directory-card-bg">
                                    <h4 class="mt-0 header-title"> &nbsp;</h4>
                                    <div class="clearfix">
                                        <div class="directory-img float-left mr-4">
                                            <?php if ($data['gambar'] == 'default.png') { ?>
                                                <img class="rounded-circle thumb-lg img-thumbnail" src="<?= base_url('public/img/informasi/agenda/agenda128.png') ?>" alt="agenda">
                                            <?php } else { ?>
                                                <img class="rounded-circle thumb-lg img-thumbnail" src="<?= base_url('public/img/informasi/agenda/' . $data['gambar']) ?>" alt="agenda">
                                            <?php } ?>
                                        </div>

                                        <h5 class="font-16 mt-0"> <i class="far fa-calendar-alt"></i> <?= date_indo($data['tgl_mulai']) ?></h5>
                                        <p class="text-muted mb-2"><i class="far fa-clock"></i> <?= $data['jam'] ?></p>
                                        <a class="text-muted">
                                            <span class="text-muted"><i class="fas fa-map-marker-alt"></i> <?= $data['tempat'] ?></span>
                                        </a>
                                    </div>
                                    <div class="directory-content mt-4">
                                        <p class="text-warning mb-5 tooltips" data-toggle="tooltip" title="Penyelenggara / Pengirim Agenda "> <i class="fas fa-paper-plane"></i> <?= $data['pengirim'] ?>
                                        </p>
                                    </div>
                                    <a class="social-icons" href="<?= base_url('agenda/all') ?>">
                                        <ul class="social-links list-inline mb-0 p-2">
                                            <li class="list-inline-item tooltips" data-toggle="tooltip" title="<?= $data['tema'] ?>">
                                                <div class="text-light">Agenda Kegiatan</div>
                                            </li>
                                        </ul>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                } else {
                    ?>
                    <div class="col-xl-5 col-lg-5">
                        <img class="" src="<?= base_url('public/img/informasi/agenda/blankagenda.jpg') ?>" alt="agenda">
                        <center>
                            <a class="text-center p-1" href="<?= base_url('agenda/all') ?>" title="Lihat Semua Agenda">
                                <span style="color:#f5f5f5;background:orange;padding:3px 5px;">Belum ada agenda kegiatan terdekat..!</span>
                            </a>
                        </center>
                    </div>
                <?php } ?>

                <!-- agenda end -->
                <div class="col-lg-7">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />
                            <div class="viewtampilgrafik"></div>
                        </div>
                    </div>
                </div> <!-- end statistik -->
            </div>


        </div>
        <!-- BERITA POPULER -->
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title mb-4">BERITA PALING POPULER</h4>
                    <div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <tbody>
                                    <?php if ($beritapopuler) {

                                        foreach ($beritapopuler as $data) :  ?>
                                            <tr>
                                                <td class="text-center p-0"> <a href="<?= base_url('detail/' . $data['slug_berita']) ?>" target="_blank"><img class="img-circle elevation-2" src="<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?>" width="50px"></td>

                                                <td>
                                                    <h8 class="mt-0"><a href="<?= base_url('detail/' . $data['slug_berita']) ?>" target="_blank"><?= $data['judul_berita'] ?> <span class="badge badge-success" style="font-size:10px">(<?= $data['hits'] ?>)</span></h6>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="button-items mt-4">
                        <a href="<?= base_url('berita/all') ?>" class="btn btn-info btn-block waves-effect" style="font-size:14px"> <i class="fas fa-list-ul"></i> Lihat Semua Berita</a></ </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- start dge -->
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="viewonline"></div>
            </div>
        </div>
        <!-- END BERITA -->

    </div>

</div>

<script>
    $(document).ready(function() {
        TampilGrafik();
        uponline();

    });

    function TampilGrafik() {
        $.ajax({
            type: "post",
            url: "<?= site_url('admin/TampilkanGrafik') ?>",
            data: {
                // [csrfToken]: csrfHash,
                csrf_tokencmsdatagoe: $('input[name=csrf_tokencmsdatagoe]').val(),
            },
            dataType: "json",

            beforeSend: function() {
                $('.viewtampilgrafik').html('<center><span class="spinner-border spinner-grow-sm text-center" role="status" aria-hidden="true"></span> <i>Loading...</i></center>');
            },

            success: function(response) {
                if (response.data) {
                    $('.viewtampilgrafik').html(response.data);
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
                if (response.csrf_tokencmsdatagoe) {
                    //update hash untuk proses error validation 
                    $('#csrfToken, #csrfRandom').val(response.csrf_tokencmsdatagoe);
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe); //dataSrc untuk random request token char (wajib)
                }
            },
            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Silahkan Cek kembali Kode ErrorXC: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                }).then(function() {
                    // window.location = '';
                })
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }

    function uponline() {
        $.ajax({
            url: "<?= site_url('admin/getonline') ?>",
            dataType: "json",
            beforeSend: function() {
                $('.viewonline').html('<center><span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i></center>');
            },
            success: function(response) {
                $('.viewonline').html(response.data);
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                if (response.csrf_tokencmsdatagoe) {
                    //update hash untuk proses error validation 
                    $('#csrfToken, #csrfRandom').val(response.csrf_tokencmsdatagoe);
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe); //dataSrc untuk random request token char (wajib)
                }
            },

            error: function(xhr, ajaxOptions, thrownerror) {
                Swal.fire({
                    title: "Maaf gagal load data!",
                    html: `Ada kesalahan Kode ErrorX: <strong>${(xhr.status + "\n")}</strong> `,
                    icon: "error",
                    // showConfirmButton: false,
                    // timer: 3100
                });
                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
            }
        });
    }
</script>


<?= $this->endSection() ?>