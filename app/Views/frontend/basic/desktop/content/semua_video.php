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
                                <div class="title-konten text-uppercase mb-3">SEMUA video</div>
                            </div>
                        </div>
                        <?php if ($video) { ?>


                            <div class="row container-grid projects-wrapper">
                                <?php $nomor = 0;
                                foreach ($video as $data) :
                                    $nomor++;
                                    $pot = substr($data['judul'], 0, 50);
                                ?>

                                    <div class="col-md-4 col-12 pb-4 text-center">
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?= $data['video_link'] ?>" allowfullscreen></iframe>
                                        </div>
                                        <div class="judul-galeri">
                                            <a href="" data-toggle="modal" data-target="#foto341874ad-bc33-11eb-8a43-e64c1828d62e" class="judul-galeri"><?= $data['judul'] ?></a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <!-- PAGINATION -->
                            <div class="col-md-12 pt-4">
                                <nav>
                                    <ul class="pagination justify-content-center">
                                        <?= $pager->links('hal', 'datagoe'); ?>
                                    </ul>
                                </nav>

                            </div>

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