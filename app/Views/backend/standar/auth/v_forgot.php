<!-- =======================================================
      * CMS DATAGOE
      * Content Management System.
      *
      * @author			Vian Taum <viantaum17@gmail.com>
      * @website		www.datagoe.com
      * @copyright		(c) 2023 - Datagoe Software
 ======================================================== -->

<?php

use App\Models\Modelkonfigurasi;

$this->konfigurasi = new Modelkonfigurasi();
$konfigurasi = $this->konfigurasi->orderBy('id_setaplikasi')->first();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <title>Lupa Password</title>
    <meta content="CMS DATAGOE" name="DATAGOE SOFTWARE" />

    <link rel="shortcut icon" href="<?= base_url('/public/img/konfigurasi/icon/' . $konfigurasi['icon']) ?>">
    <link href="<?= base_url('/public/template/backend/' . $folder . '/assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('/public/template/backend/' . $folder . '/assets/css/icons.css') ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('/public/template/backend/' . $folder . '/assets/css/style.css') ?>" rel="stylesheet" type="text/css">

</head>

<body>
    <!-- Background -->
    <div class="account-pages"></div>
    <!-- Begin page -->
    <div class="wrapper-page">
        <div class="card">
            <div class="card-body">
                <?php if (file_exists('public/img/konfigurasi/logo/' . $konfigurasi['logo'])) {
                    $img = $konfigurasi['logo'];
                } else {
                    $img = 'default.png';
                }
                ?>
                <h3 class="text-center m-0">
                    <a href="<?= base_url() ?>" class="logo logo-admin"><img src="<?= base_url('/public/img/konfigurasi/logo/' . $img) ?>"></a>
                </h3>
                <hr>
                <center>Silahkan Masukkan Email yang terkait dengan Akun!</center>
                <div class="p-1">
                    <?= form_open('login/proseslupa', ['class' => 'formlogin']) ?>

                    <form class="form-horizontal m-t-30" action="<?= base_url('login') ?>">
                        <div class="form-group">
                            <!-- <label for="username">Silahkan masukan Email</label> -->
                            <input type="text" class="form-control" name="email" id="email" value="<?= htmlentities(set_value('email'), ENT_QUOTES) ?>" placeholder="Enter Email" autofocus>
                            <div class="invalid-feedback erroremail"></div>
                        </div>

                        <div class="form-group row m-t-20">

                            <div class="col-12 text-center">
                                <button class="btn btn-primary w-md waves-effect waves-light btnlogin" type="submit"><i class="fas fa-paper-plane text-light"></i> Kirim Permintaan</button>
                            </div>
                        </div>

                    </form>
                    <?php echo form_close() ?>
                </div>

            </div>
        </div>

        <div class="m-t-40 text-center">
            <p class="text-muted">Remember It ? <a href="<?= base_url('/login') ?>" class="text-primary"> Kembali Login </a> </p>
            <p class="text-muted">Hak Cipta © <?= date('Y') ?> <?= $konfigurasi['nama'] ?></p>
        </div>

    </div>
    <!-- jQuery  -->
    <script src="<?= base_url('/public/template/backend/' . $folder . '/assets/js/jquery-3.7.1.min.js') ?>"></script>
    <!-- <script src="<?= base_url('/public/template/backend/' . $folder . '/assets/js/jquery.min.js') ?>"></script> -->
    <script src="<?= base_url('/public/template/backend/' . $folder . '/assets/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('/public/template/backend/' . $folder . '/assets/js/waves.min.js') ?>"></script>
    <script src="<?= base_url('/public/template/backend/' . $folder . '/plugins/jquery-sparkline/jquery.sparkline.min.js') ?>"></script>
    <script src="<?= base_url('/public/template/backend/' . $folder . '/assets/js/sweetalert2.js') ?>"></script>

</body>

</html>

<script>
    $(document).ready(function() {
        $('.formlogin').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "post",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function() {
                    $('.btnlogin').prop('disable', true);
                    $('.btnlogin').html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> <i>Loading...')

                },
                complete: function() {
                    $('.btnlogin').prop('disable', false);
                    $('.btnlogin').html('Set New Password')
                    $('.btnlogin').html('<i class="fas fa-paper-plane"></i>  Kirim Permintaan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.email) {
                            $('#email').addClass('is-invalid');
                            $('.erroremail').html(response.error.email);
                        } else {
                            $('#email').removeClass('is-invalid');
                            $('.erroremail').html();
                        }
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    }

                    if (response.sukses) {

                        Swal.fire({
                            title: "Sukses kirim link aktivasi",
                            text: "Buka email anda dan silahkan Ikuti petunjuk ",
                            icon: "success",


                        }).then(function() {
                            window.location = '<?= base_url('login') ?>';
                        })
                    }

                    if (response.wrongemail) {
                        Swal.fire({
                            title: "Oooopss!",
                            text: "Email tidak ditemukan",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1250
                        });
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    }
                    if (response.resetexpair) {
                        Swal.fire({
                            title: "Sorry there was a problem!",
                            text: "Tidak dapat kirim email!",
                            icon: "error",
                            // showConfirmButton: false,
                            // timer: 1250
                        });
                        $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                    }

                },
                error: function(xhr, ajaxOptions, thrownerror) {
                    Swal.fire({
                        title: "Maaf gagal proses data!",
                        html: `Ada kesalahan..! `,
                        icon: "error",
                        showConfirmButton: false,
                        timer: 3100
                    });
                    $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                }
            });
            return false;
        });
    });
</script>