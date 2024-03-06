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
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <!-- ISI KONTEN -->

                            <div class="row pt-2 pb-3">
                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if ($ebook) { ?>
                                                <div class="title-konten text-uppercase">Hasil Pencarian :
                                                    <?php if ($keykategori != "") { ?>
                                                        Kategori : <b class="text-danger"><?= esc($keykategori) ?> </b>
                                                    <?php } ?>
                                                    <?php if ($keyword != "") { ?>
                                                        <b class="text-danger"><?= esc($keyword) ?> </b>
                                                    <?php } ?>
                                                </div>
                                            <?php  } else { ?>
                                                <div class="title-konten text-uppercase">Hasil Pencarian</div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- <div class="title-konten text-uppercase">Data Ebook</div> -->
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <div class="mt-3">

                                        <!-- Start content -->

                                        <?php if ($ebook) { ?>
                                            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="berita-tab">
                                                <div class="row mt-4">

                                                    <?php $nomor = 0;
                                                    foreach ($ebook as $data) :
                                                        $nomor++; ?>
                                                        <div class="col-md-4 col-lg-4 col-12 col-sampul">
                                                            <div class="row">
                                                                <div class="col-md-12 col-4 col-gambar">
                                                                    <div class="wraper-img-new">
                                                                        <a href="<?= base_url('bacabuku/' . $data['fileebook']) ?>" target="_blank" onclick="updatehit('<?= $data['ebook_id'] ?>')" title=" Jumlah Halaman <?= $data['j_hal'] ?>, Kategori <?= $data['kategoriebook_nama'] ?>">
                                                                            <img class="wraper-img-new" src=<?= base_url('/public/img/ebook/' . $data['gambar']) ?> ;>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class=" col-md-12 col-8 col-isi">
                                                                    <div class="posted-new">
                                                                        <i class="far fa-calendar-alt"></i> <?= date_indo($data['tanggal']) ?> |
                                                                        <i class="far fa-eye"></i> <?= $data['hits'] ?>x |
                                                                        <i class="fab fa-searchengin"></i> <a class="cate pointer" onclick="lihatbook('<?= $data['ebook_id'] ?>','<?= $data['kategoriebook_nama'] ?>')">Detail</a>

                                                                    </div>
                                                                    <a href="<?= base_url('bacabuku/' . $data['fileebook']) ?>" target="_blank" onclick="updatehit('<?= $data['ebook_id'] ?>')"><?= $data['judul'] ?></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>

                                                </div>
                                            </div>
                                            <!-- PAGINATION -->
                                            <div class="col-md-12 pt-4">
                                                <nav>

                                                    <P>
                                                    <ul class="pagination justify-content-center">
                                                        <?= $pager->links('hal', 'datagoe'); ?>
                                                    </ul>
                                                    </P>


                                                </nav>
                                            </div>

                                        <?php } else { ?>
                                            <div class="alert alert-danger text-center" style='background-color:#FAEBD7; border-color:#e3e3e3;'>
                                                Maaf keyword <b class="text-danger"><?= esc($keyword) ?> </b> tidak ditemukan..!!
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <!-- end konten -->


                                <div class="col-md-4">
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="float-end ">
                                                <a type="button" data-toggle="modal" data-target="#pencarian" style="padding: 4px; font-weight: 600; color: orange; " class="btn btn-block btn-warning btn-lg text-white ">
                                                    <i class="mdi mdi-file-find"></i> Cari Ebook
                                                </a>
                                            </div>
                                            <br>
                                            <div class="caption">Berita Terkini</div>

                                        </div>
                                    </div>

                                    <!-- BERITA SIDEBAR -->
                                    <div class="row">
                                        <div class="col-md-12">

                                            <?php $nomor = 0;
                                            foreach ($beritaterkini as $data) :
                                                $nomor++; ?>

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


<div class="modal fade modal-animate" id="pencarian" tabindex="-1" aria-labelledby="animateModalLabel" aria-hidden="true" style="margin-top: 10%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">Pencarian</h5>
                <button type=" button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div> -->
            <div class="modal-header">
                <h5 class="modal-title mt-0">Pencarian E-book</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= base_url('cari/buku') ?>" method="POST">
                    <?= csrf_field(); ?>
                    <div class="form-group mb-3">
                        <label class="form-label" for="inputState">Kategori</label>

                        <select name="kategori" id="kategori" class="form-control">
                            <option value="" selected="">Semua Kategori</option>
                            <?php foreach ($kategori as $key => $data) { ?>
                                <option value="<?= $data['kategoriebook_nama'] ?>"><?= $data['kategoriebook_nama'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="input-group mb-3">
                        <input name="keyword" type="text" value="<?= htmlentities(set_value('keyword'), ENT_QUOTES) ?>" class="form-control" placeholder="Masukkan Judul / Penulis" autofocus autocomplete="off" required>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit" style="padding: 7px;"> <i class="mdi mdi-file-find"></i> Cari</a>
                        </div>
                    </div>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" style="padding: 7px;" data-dismiss="modal">Close</button>

            </div>
            </form>
        </div>

    </div>
</div>

<?= $this->endSection() ?>