<?php
$db = \Config\Database::connect();
?>
<?= $this->extend('frontend/' . $folder . '/desktop' . '/template-frontend') ?>
<?= $this->extend('frontend/' . $folder . '/desktop' . '/v_menu') ?>

<?= $this->section('content') ?>

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
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="title-konten text-uppercase">Fasilitas</div>
                            </div>
                        </div>
                        <div class="col-md-12 col-12 pb-4 text-center">
                            <?php if ($fasilitasutm) {
                                $db = \Config\Database::connect();
                                $idfas1 = $fasilitasutm->fasilitas_id;
                                $jumfoto1 = $db->table('fasilitas_detail')->where('fasilitas_id', $idfas1)->get()->getNumRows();
                            ?>


                                <div class="bg-white rounded">
                                    <div class="px-3 kategori bg-danger">
                                        <div class="text-light"><?= $jumfoto1 ?> Item </div>
                                    </div>
                                </div>
                                <div class="pages-pic">
                                    <div class=" pointer">
                                        <a class="" href="<?= base_url('fasilitas/det/' . $fasilitasutm->fasilitas_id) ?>" title="<?= $fasilitasutm->fasilitas ?>">
                                            <img class="img-thumbnail" src="<?= base_url('/public/img/informasi/fasilitas/' . $fasilitasutm->cover_foto) ?>" alt="<?= $fasilitasutm->fasilitas ?>" width="95%" />
                                        </a>
                                    </div>

                                    <div class="newsthumb__content">
                                        <!-- <div class="catedate">
                                            <a class="cate"><?= $jumfoto1 ?> Item </a>
                                        </div> -->
                                        <h2 class="newsthumb__title pointer"><a href="<?= base_url('fasilitas/det/' . $fasilitasutm->fasilitas_id) ?>"><?= $fasilitasutm->fasilitas ?></a></h2>
                                    </div>

                                </div>
                                <hr>
                            <?php } ?>
                        </div>
                        <?php if ($fasilitas) { ?>
                            <div class="row container-grid projects-wrapper">

                                <?php

                                foreach ($fasilitas as $key => $data) {
                                    $idfas = $data['fasilitas_id'];
                                    $jumfoto = $db->table('fasilitas_detail')->where('fasilitas_id', $idfas)->get()->getNumRows();
                                ?>

                                    <div class="col-md-3 col-12 pb-4 text-center">

                                        <div class="gallery-box mt-4">
                                            <div class="bg-white rounded">
                                                <div class="px-3 kategori bg-danger">
                                                    <div class="text-light"><?= $jumfoto ?> Foto </div>
                                                </div>
                                            </div>
                                            <?php if ($jumfoto != 0) { ?>
                                                <a href="<?= base_url('fasilitas/det/' . $data['fasilitas_id']) ?>" title="Lihat Foto">
                                                    <img class="" width="100%" height="200" src="<?= base_url('/public/img/informasi/fasilitas/' . $data['cover_foto']) ?>" alt="<?= $data['fasilitas'] ?>" />
                                                </a>
                                            <?php } else { ?>
                                                <a title="Belum ada item yang dapat ditampilkan">
                                                    <img class="" width="100%" height="200" src="<?= base_url('/public/img/informasi/fasilitas/' . $data['cover_foto']) ?>" alt="<?= $data['fasilitas'] ?>" />
                                                </a>
                                            <?php } ?>

                                        </div>
                                        <div class="judul-galeri">
                                            <?php if ($jumfoto != 0) { ?>
                                                <a href="<?= base_url('fasilitas/det/' . $data['fasilitas_id']) ?>" title="Lihat item"><?= $data['fasilitas'] ?></a>
                                            <?php } else { ?>
                                                <a title="Belum ada item yang dapat ditampilkan"><?= $data['fasilitas'] ?></a>

                                            <?php } ?>
                                        </div>
                                    </div>

                                <?php } ?>
                            </div>
                            <!-- PAGINATION -->
                            <div class="col-md-12 pt-4">
                                <nav>
                                    <?php if ($jumpg > 12) { ?>
                                        <P>
                                        <ul class="pagination justify-content-center">
                                            <?= $pager->links('hal', 'datagoe'); ?>
                                        </ul>
                                        </P>
                                    <?php } ?>

                                </nav>

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