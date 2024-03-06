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
                            <div class="col-md-12">
                                <div class="title-konten text-uppercase">Album Foto</div>
                            </div>
                        </div>
                        <?php if ($album) { ?>
                            <div class="row container-grid projects-wrapper">

                                <?php

                                foreach ($album as $key => $data) {
                                    $idalbum = $data['kategorifoto_id'];
                                    $jumfoto = $db->table('foto')->where('kategorifoto_id', $idalbum)->get()->getNumRows();
                                ?>

                                    <div class="col-md-3 col-12 pb-4 text-center">

                                        <div class="gallery-box mt-4">
                                            <div class="bg-white rounded">
                                                <div class="px-3 kategori bg-danger">
                                                    <div class="text-light"><?= $jumfoto ?> Foto </div>
                                                </div>
                                            </div>
                                            <?php if ($jumfoto != 0) { ?>
                                                <a href="<?= base_url('foto/detail/' . $data['kategorifoto_id']) ?>" title="Lihat Foto">
                                                    <img class="" width="100%" height="200" src="<?= base_url('/public/img/galeri/katfoto/' . $data['cover_foto']) ?>" alt="<?= $data['nama_kategori_foto'] ?>" />
                                                </a>
                                            <?php } else { ?>
                                                <a title="Belum ada foto yang dapat ditampilkan">
                                                    <img class="" width="100%" height="200" src="<?= base_url('/public/img/galeri/katfoto/' . $data['cover_foto']) ?>" alt="<?= $data['nama_kategori_foto'] ?>" />
                                                </a>
                                            <?php } ?>
                                            <!-- <span class="date"><?= longdate_indo($data['tgl_album']) ?></span> -->
                                        </div>
                                        <div class="judul-galeri">
                                            <?php if ($jumfoto != 0) { ?>
                                                <a href="<?= base_url('foto/detail/' . $data['kategorifoto_id']) ?>" title="Lihat Foto"><?= $data['nama_kategori_foto'] ?></a>
                                            <?php } else { ?>
                                                <a title="Belum ada foto yang dapat ditampilkan"><?= $data['nama_kategori_foto'] ?></a>

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