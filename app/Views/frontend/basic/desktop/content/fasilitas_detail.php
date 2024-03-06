<?= $this->extend('frontend/' . $folder . '/desktop' . '/template-frontend') ?>
<?= $this->extend('frontend/' . $folder . '/desktop' . '/v_menu') ?>

<?= $this->section('content') ?>

<!-- Page-Title -->
<div class="page-title-box ">
    <div class="container-fluid ">

    </div>
</div>
<!-- end page title end breadcrumb -->
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <?php if ($detfasilitas) { ?>

                        <?php foreach ($detfasilitas as $data) {
                            }
                        } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-konten text-uppercase"><?= $data['fasilitas'] ?></div>
                            </div>
                        </div>
                        <?php if ($detfasilitas) { ?>
                            <div class="row container-grid projects-wrapper">

                                <?php $nomor = 0;
                                foreach ($detfasilitas as $data) :
                                    $nomor++;

                                ?>
                                    <div class="col-xl-3 col-md-4 col-sm-6 branding designing development">
                                        <div class="gallery-box mt-4">
                                            <a class="gallery-popup" href="<?= base_url('/public/img/informasi/fasilitas/detail/' . $data['gambar']) ?>" title="<?= $data['deskripsi'] ?>">
                                                <!-- <div class="wraper-img-new"> -->
                                                <img class="embed-responsive embed-responsive-16by9 wrapper-img-new" src="<?= base_url('/public/img/informasi/fasilitas/detail/' . $data['gambar']) ?>" style="height: 200px;" alt="1" />
                                                <!-- </div> -->
                                                <div class="gallery-overlay">
                                                    <div class="overlay-content">
                                                        <h5 class="overlay-title"><?= $data['deskripsi'] ?></h5>
                                                        <!-- <p class="text-uppercase mb-0"><?= $data['ket'] ?></p> -->
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="mt-3">
                                <p>
                                    <?= $data['ket'] ?>

                                    <?php
                                    if ($data['lokasi'] != '') { ?>
                                        <style type="text/css" media="screen">
                                            iframe {
                                                height: 250px;
                                                width: 100%;
                                            }
                                        </style>
                                        <?= $data['lokasi'] ?>
                                    <?php } ?>
                                </p>

                            </div>

                            <nav>
                                <P>
                                <ul class="pagination justify-content-center">
                                    <a type="submit" href="<?= base_url('fasilitas') ?>" class="btn btn-info text-light"><i class="fas fa-arrow-left"></i> <b class="text-light">Kembali</b> </a>
                                </ul>
                                </P>
                            </nav>
                        <?php } else { ?>
                            <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                <a style='color:red'>Maaf belum ada data..!</a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>