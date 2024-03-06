<?= $this->extend('frontend/' . $folder . '/desktop' . '/template-frontend') ?>
<?= $this->extend('frontend/' . $folder . '/desktop' . '/v_menu') ?>

<?= $this->section('content');
$db = \Config\Database::connect();
?>

<!-- Page-Title -->
<div class="page-title-box">
    <div class="container-fluid"></div>
</div>
<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <!-- ISI KONTEN -->

                            <div class="row pt-2 pb-5">
                                <div class="col-md-8">
                                    <div class="judul-single-konten">
                                        <?= $berita->judul_berita ?>
                                    </div>
                                    <?php
                                    $opd_id2 = $berita->opd_id;
                                    $viewopd2 = $db->table('custome__opd')->where('opd_id', $opd_id2)->where('opd_id !=', 0)->get()->getRowArray();

                                    ?>
                                    <div class="post-single-konten font-12">
                                        <i class="fas fa-user"></i> <?= $berita->fullname ?> <span class="text-capitalize"></span> |
                                        <i class="fas fa-calendar-alt"></i> <?= date_indo($berita->tgl_berita) ?> |
                                        <i class="fas fa-eye"></i> Dibaca <?= $berita->hits ?> kali |
                                        <?php if ($viewopd2) {
                                            if ($viewopd2['opd_id'] != 0) { ?>
                                                <!-- <div class="d-block d-sm-none">
                                                    <i class="far fa-building"></i> <?= $viewopd2['singkatan_opd'] ?>
                                                </div> -->
                                                <!-- <div class="d-none d-sm-block"> -->
                                                <i class="far fa-building"></i> <?= $viewopd2['nama_opd'] ?>
                                                <!-- </div> -->

                                        <?php  }
                                        } ?>

                                    </div>
                                    <hr>
                                    <?php if ($berita->jenis_berita == 'Berita') { ?>
                                        <img src="<?= base_url('/public/img/informasi/berita/' . $berita->gambar) ?>" width="100%" alt="" class="mb-1">
                                        <?php } else {

                                        if ($berita->gambar != 'default.png') { ?>
                                            <img src="<?= base_url('/public/img/informasi/profil/' . $berita->gambar) ?>" width="100%" alt="" class="mb-1">
                                        <?php } else { ?>
                                            <img src="<?= base_url('/public/img/informasi/profil/default.png/') ?>" width="100%" alt="" class="mb-1">
                                    <?php }
                                    } ?>
                                    <i><?= $berita->ket_foto ?></i>

                                    <!-- ISI KONTEN -->
                                    <div class="mt-0">
                                        <p><?= $berita->isi ?></p>
                                    </div>
                                    <?php if ($tag) { ?>
                                        <?php foreach ($tag as $data) {
                                        ?>
                                            <div class="btn-group ">
                                                <a href="<?= base_url('tag/' . $data['tag_id'] . '/' . $data['slug_tag']) ?>" class="btn btn-secondary btn-sm mb-0"><i class="fas fa-tags ml-1"></i> #<?= $data['nama_tag'] ?> </a>
                                            </div>
                                    <?php }
                                    } ?>

                                    <div class="a2a_kit a2a_kit_size_32 a2a_default_style mt-4">
                                        <div class="button-items mr-1 text-right">
                                            <span>BAGIKAN : </span>
                                            <a class="btn btn-sm btn-primary m-0" href="http://www.facebook.com/sharer.php?u=<?php echo site_url() . 'detail/' . $berita->slug_berita ?>" target="_blank" role="button"><i class="fab fa-facebook-f font-size-18"></i></a>
                                            <a class="btn btn-sm btn-info m-0" href="http://twitter.com/share?url=<?php echo site_url() . 'detail/' . $berita->slug_berita . '&hl=id' ?>" target="_blank" role="button"><i class="fab fa-twitter"></i></a>
                                            <a class="btn btn-sm btn-success m-0" href="whatsapp://send?text=<?= base_url('detail/' . $berita->slug_berita) ?>" role="button"><i class="fab fa-whatsapp"></i></a>
                                        </div>
                                    </div>
                                    <br>
                                    <hr>

                                    <!-- KOMENTAR -->
                                    <?php if ($berita->sts_komen != '0') { ?>
                                        <br>
                                        <div class="blog-comments">
                                            <?php if ($komen) {
                                            ?>
                                                <!-- Single Comment -->
                                                <div class="header">
                                                    <div class="title">Komentar</div>
                                                </div>

                                                <div id="comment-1" class="comment">
                                                    <div class="item">
                                                        <?php foreach ($komen as $data) { ?>
                                                            <div class="comment-img">
                                                                <img class="img-circle comment-img float-left" src="<?= base_url('public/template/backend/standar/assets/images/usr2.png') ?>" alt="img">
                                                            </div>
                                                            <div>
                                                                <div class="author"><?= $data['nama_komen'] ?></div>
                                                                <?php
                                                                $blnk = date('m', strtotime($data["tanggal_komen"]));
                                                                $blnck = bulan($blnk);
                                                                $tglk = date('d', strtotime($data["tanggal_komen"]));
                                                                $thnk = date('Y', strtotime($data["tanggal_komen"]));
                                                                $jamk = date('H:i:s', strtotime($data["tanggal_komen"]));
                                                                ?>
                                                                <div class="date"><?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?></div>
                                                                <p><?= $data['isi_komen'] ?> </p>
                                                            </div>

                                                            <?php if ($data['balas_komen'] != '') { ?>
                                                                <div class="alert alert-info" style='background-color:#f4f4f4; border-color:#e3e3e3;'>
                                                                    <div class="comment-img">
                                                                        <img class="img-circle comment-img float-left" src="<?= base_url('public/img/user/' . $data['user_image']) ?>" alt="<?= $data['nama_komen'] ?>">
                                                                    </div>
                                                                    <div>

                                                                        <?php
                                                                        $bln = date('m', strtotime($data["tgl_balas"]));
                                                                        $blnc = bulan($bln);
                                                                        $tgl = date('d', strtotime($data["tgl_balas"]));
                                                                        $thn = date('Y', strtotime($data["tgl_balas"]));
                                                                        $jam = date('H:i:s', strtotime($data["tgl_balas"]));


                                                                        ?>
                                                                        <div class="author text-primary"><?= $data['fullname'] ?></div>
                                                                        <div class="date text-danger"><?= $tgl . ' ' . $blnc . ' ' . $thn . ' ' . $jam ?></div>
                                                                        <p><i><?= $data['balas_komen'] ?></i> </p>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>

                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="alert-section">

                                            </div>


                                            <div class="reply-form">

                                                <div class="caption">Berikan Komentar</div>
                                                <p>
                                                <div class="alert alert-info" style='background-color:#f4f4f4; border-color:#e3e3e3;'>
                                                    <img style='float:left; padding: 7px; margin-top:-8px; margin-right:3px;' width="65" class="pull-left" src="<?= base_url('public/template/backend/standar/assets/images/icon_rules.png') ?>">
                                                    Silakan tulis komentar dalam formulir berikut ini (Gunakan bahasa yang santun). Komentar akan ditampilkan setelah disetujui oleh Admin
                                                </div>
                                                </p>
                                                <?= form_open('berita/simpankomen', ['class' => 'formkomen']) ?>

                                                <input type="hidden" id="berita_id" name="berita_id" value="<?= $berita->berita_id ?>" class="form-control">
                                                <div class="row">
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" class="form-control" name="nama_komen" value="" placeholder="Nama Lengkap*" required>
                                                        <div class="invalid-feedback errornama_komen"></div>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="text" class="form-control" name="hp_komen" maxlength="20" value="" placeholder="Nomor Handphone*" required>
                                                        <div class="invalid-feedback errorhp_komen"></div>
                                                    </div>
                                                    <div class="col-md-4 form-group">
                                                        <input type="email" class="form-control" name="email_komen" value="" placeholder="Alamat Email*" required>
                                                        <div class="invalid-feedback erroremail_komen"></div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12 form-group">
                                                        <textarea rows="4" name="isi_komen" class="form-control" placeholder="Tulis komentar disini*" required=""></textarea>
                                                        <div class="invalid-feedback errorisi_komen"></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer p-1">
                                                    <div class="g-recaptcha" data-sitekey="<?= $sitekey ?>"></div>
                                                    <button type="submit" class="btn btn-primary btnkomen"><i class="fas fa-paper-plane"></i> Kirim Komentar</button>
                                                </div>

                                                <?= form_close() ?>

                                            </div>


                                        </div><!-- End blog comments -->
                                    <?php } ?>

                                </div>
                                <div class="col-md-4">
                                    <div class="row pb-4">
                                        <div class="col-md-12">
                                            <div class="caption">Berita Terpopuler</div>
                                        </div>
                                    </div>

                                    <!-- BERITA SIDEBAR -->
                                    <div class="row">
                                        <div class="col-md-12">

                                            <?php $nomor = 0;
                                            foreach ($beritapopuler as $data) :
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
                                    <div class="row pb-3">
                                        <div class="col-md-12">
                                            <div class="caption">Info Grafis</div>
                                        </div>
                                    </div>

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
                                                    <div class="wraper-info-newx">
                                                        <img class=" pointer" onclick="lihatinfo('<?= $value['id_banner'] ?>')" src="<?= base_url('public/img/informasi/infografis/' .  $value['banner_image']) ?>" width="100%">
                                                    </div>
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


<script>
    $(document).ready(function() {

        $('.formkomen').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnkomen').prop('disable', true);
                    $('.btnkomen').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> <i>Loading...')

                },
                complete: function() {
                    $('.btnkomen').prop('disable', false);
                    $('.btnkomen').html('Kirim Komentar')
                    $('.btnkomen').html('<i class="fas fa-paper-plane"></i>  Kirim Komentar');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.nama_komen) {
                            $('#nama_komen').addClass('is-invalid');
                            $('.errornama_komen').html(response.error.nama_komen);
                        } else {
                            $('#nama_komen').removeClass('is-invalid');
                            $('.errornama_komen').html();
                            $('#nama_komen').addClass('is-valid');
                        }

                        if (response.error.hp_komen) {
                            $('#hp_komen').addClass('is-invalid');
                            $('.errorhp_komen').html(response.error.hp_komen);
                        } else {
                            $('#hp_komen').removeClass('is-invalid');
                            $('.errorhp_komen').html();
                            $('#hp_komen').addClass('is-valid');
                        }

                        if (response.error.isi_komen) {
                            $('#isi_komen').addClass('is-invalid');
                            $('.errorisi_komen').html(response.error.isi_komen);
                        } else {
                            $('#isi_komen').removeClass('is-invalid');
                            $('.errorisi_komen').html();
                            $('#isi_komen').addClass('is-valid');
                        }

                        if (response.error.email_komen) {
                            $('#email_komen').addClass('is-invalid');
                            $('.erroremail_komen').html(response.error.email_komen);
                        } else {
                            $('#email_komen').removeClass('is-invalid');
                            $('.erroremail_komen').html();
                            $('#email_komen').addClass('is-valid');
                        }


                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: "Terima Kasih!",
                            text: response.sukses,
                            icon: "success",
                            // showConfirmButton: false,
                            // timer: 4550
                        }).then(function() {

                            window.location = '';
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal kirim Komentar!",
                        html: `Silahkan coba kembali Error Code: <strong>${(xhr.status + "\n")}</strong> `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    }).then(function() {
                        window.location = '';
                    })
                }
            });
            return false;
        });
    });
</script>

<?= $this->endSection() ?>