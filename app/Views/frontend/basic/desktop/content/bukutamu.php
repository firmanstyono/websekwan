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
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <!-- ISI KONTEN -->

                            <div class="row pt-2 pb-3">
                                <div class="col-md-8">

                                    <div class="title-konten text-uppercase">Buku Tamu</div>
                                    <!-- ++++++ DETAIL KONTEN +++++++++++ -->

                                    <div class="mt-3">

                                        <!-- Start content -->
                                        <?= form_open('bukutamu/simpanbukutamu', ['class' => 'fbk']) ?>
                                        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />


                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-striped">
                                                <tbody>

                                                    <tr>
                                                        <td>Nama</td>
                                                        <td>
                                                            <input type="text" id="nama" name="nama" value="<?= htmlentities(set_value('nama'), ENT_QUOTES) ?>" class="form-control">
                                                            <div class="invalid-feedback errornama"></div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>No Hp</td>
                                                        <td>
                                                            <input type="text" id="telp" name="telp" class="form-control" value="<?= htmlentities(set_value('telp'), ENT_QUOTES) ?>">
                                                            <div class="invalid-feedback errortelp"></div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td>Instansi</td>
                                                        <td>
                                                            <input type="text" id="instansi" name="instansi" value="<?= htmlentities(set_value('instansi'), ENT_QUOTES) ?>" class="form-control">
                                                            <div class="invalid-feedback errorinstansi"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bidang</td>
                                                        <td>

                                                            <select class="form-control" name="bidang_id" id="bidang_id">
                                                                <option Disabled=true Selected=true>-- Pilih Bidang --</option>
                                                                <?php foreach ($mbidang as $key => $data) { ?>
                                                                    <option value="<?= $data['bidang_id'] ?>"><?= $data['nama_bidang'] ?></option>
                                                                <?php } ?>
                                                            </select>

                                                            <div class="invalid-feedback errorbidang_id"></div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keperluan</td>
                                                        <td>
                                                            <textarea type="text" id="keperluan" name="keperluan" class="form-control "></textarea>
                                                            <div class="invalid-feedback errorkeperluan"><?= htmlentities(set_value('keperluan'), ENT_QUOTES) ?></div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <div class="modal-footer p-1">
                                                <div class="g-recaptcha" data-sitekey="<?= $sitekey ?>"></div>
                                                <button type="submit" class="btn btn-primary btnkirim"><i class="fas fa-paper-plane"></i> Kirim </button>
                                            </div>

                                        </div>


                                        <?= form_close() ?>

                                    </div>

                                    <!-- end konten -->


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

        $('.fbk').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnkirim').prop('disable', true);
                    $('.btnkirim').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> <i>Loading...')

                },
                complete: function() {
                    $('.btnkirim').prop('disable', false);
                    $('.btnkirim').html('Kirim Pesan')
                    $('.btnkirim').html('<i class="fas fa-paper-plane"></i>  Kirim Pesan');
                },
                success: function(response) {
                    if (response.error) {

                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('.errornama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('.errornama').html();
                            $('#nama').addClass('is-valid');
                        }

                        if (response.error.instansi) {
                            $('#instansi').addClass('is-invalid');
                            $('.errorinstansi').html(response.error.instansi);
                        } else {
                            $('#instansi').removeClass('is-invalid');
                            $('.errorinstansi').html();
                            $('#instansi').addClass('is-valid');
                        }

                        if (response.error.telp) {
                            $('#telp').addClass('is-invalid');
                            $('.errortelp').html(response.error.telp);
                        } else {
                            $('#telp').removeClass('is-invalid');
                            $('.errortelp').html();
                            $('#telp').addClass('is-valid');
                        }

                        if (response.error.bidang_id) {
                            $('#bidang_id').addClass('is-invalid');
                            $('.errorbidang_id').html(response.error.bidang_id);
                        } else {
                            $('#bidang_id').removeClass('is-invalid');
                            $('.errorbidang_id').html();
                            $('#bidang_id').addClass('is-valid');
                        }

                        if (response.error.keperluan) {
                            $('#keperluan').addClass('is-invalid');
                            $('.errorkeperluan').html(response.error.keperluan);
                        } else {
                            $('#keperluan').removeClass('is-invalid');
                            $('.errorkeperluan').html();
                            $('#keperluan').addClass('is-valid');
                        }
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    }

                    if (response.sukses) {
                        Swal.fire({
                            title: "Terima Kasih!",
                            text: response.sukses,
                            icon: "success",
                            // showConfirmButton: false,
                            // timer: 4550
                        }).then(function() {
                            window.location = '<?= base_url('') ?>';
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal mengirim data!",
                        html: `Silahkan coba kembali`,
                        icon: "error",
                        // showConfirmButton: false,
                        // timer: 3100
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