<?= $this->extend('frontend/' . $folder . '/desktop' . '/template-frontend') ?>
<?= $this->extend('frontend/' . $folder . '/desktop' . '/v_menu') ?>

<?= $this->section('content') ?>
<style>
    .gradient-custom-2 {
        /* fallback for old browsers */
        background: #fbc2eb;

        /* Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, rgba(251, 194, 235, 1), rgba(166, 193, 238, 1));

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, rgba(251, 194, 235, 1), rgba(166, 193, 238, 1))
    }

    .testimonial-card .card-up {
        height: 120px;
        overflow: hidden;
        border-top-left-radius: 0.25rem;
        border-top-right-radius: 0.25rem;
    }

    .testimonial-card .avatar {
        /* width: 110px; */
        width: 128px;
        margin-top: -60px;
        overflow: hidden;
        border: 3px solid #fff;
        border-radius: 50%;
    }
</style>

<!-- Page-Title -->
<div class="page-title-box">
    <div class="container-fluid">


    </div>
</div>
<!-- end page title end breadcrumb -->

<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <!-- ISI KONTEN -->

                            <div class="row pt-2 pb-3">
                                <div class="col-md-8">

                                    <div class="title-konten text-uppercase">data pegawai</div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <!-- ISI KONTEN -->
                                    <div class="mt-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <?php if ($pegawai) {
                                                            ?>
                                                                <div class="row text-center">
                                                                    <?php
                                                                    foreach ($pegawai as $data) :
                                                                        $pot = substr($data['nama'], 0, 21);
                                                                        $potjab = substr($data['jabatan'], 0, 28);
                                                                    ?>
                                                                        <div class="col-md-4 mb-5 mb-md-3">
                                                                            <div class="card testimonial-card shadow-lg" style="border-style: solid;">
                                                                                <div class="card-up gradient-custom-2"></div>
                                                                                <!-- <div class="card-up" style="background-color: #9d789b;"></div> -->
                                                                                <div class="avatar mx-auto bg-white">
                                                                                    <img src="<?= base_url('/public/img/informasi/pegawai/' . $data['gambar']) ?>" class="rounded-circle img-fluid" style="width: 180px;" />
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <strong><a style="font-size: 20px;"><?= $pot ?></a></strong>
                                                                                    <p class="mb-2 pb-1" style="color: #2b2a2a;"><?= $potjab ?></p>
                                                                                    <hr />

                                                                                    <button type="button" class="btn btn-primary btn-rounded btn-sm" onclick="lihatpegawai('<?= $data['pegawai_id'] ?>')">
                                                                                        Lihat Detail
                                                                                    </button>

                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>

                                                                </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12 pt-4">
                                            <nav>
                                                <?php if ($jum > 6) { ?>
                                                    <ul class="pagination justify-content-center">
                                                        <?= $pager->links('hal', 'datagoe'); ?>
                                                    </ul>
                                                <?php } ?>
                                            </nav>

                                        </div>
                                    <?php } else { ?>
                                        <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                            <a style='color:red'>Maaf belum ada data..!</a>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="caption">Berita Terpopuler</div>
                                        </div>
                                    </div>

                                    <!-- BERITA SIDEBAR -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if ($beritapopuler) {

                                                foreach ($beritapopuler as $data) :
                                            ?>

                                                    <div class="card border-light mb-3">
                                                        <div class="row no-gutters">
                                                            <div class="col-md-3 col-4 wraper-img-side">
                                                                <img class="wraper-img-side" src=<?= base_url('/public/img/informasi/berita/' . $data['gambar']) ?> ;>
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
                                            <?php } else { ?>
                                                <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                                    <a style='color:red'>Maaf belum ada data..!</a>
                                                </div>
                                            <?php } ?>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection() ?>