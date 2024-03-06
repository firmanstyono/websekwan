<div class="modal fade" id="modaledit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="card-header mt-0">

                <h6 class="modal-title m-0">Permohonan dari <?= esc($nama_pemohon)  ?>

                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formbalasrespon']) ?>
            <?php
            $blnk = date('m', strtotime($tgl_ajuan));
            $blnck = bulan($blnk);
            $tglk = date('d', strtotime($tgl_ajuan));
            $thnk = date('Y', strtotime($tgl_ajuan));
            $jamk = date('H:i:s', strtotime($tgl_ajuan));
            ?>
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_tokencmsdatagoe" />

            <div class="modal-body">
                <input type="hidden" value="<?= $id_mohoninfo ?>" name="id_mohoninfo">

                <div class="row">
                    <div class="form-group col-md-4 col-12">
                        <label for="">Nama </label>
                        <input type="text" class="form-control form-control-sm" id="nama_pemohon" name="nama_pemohon" value="<?= esc($nama_pemohon) ?>" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label for="">E-mail </label>
                        <input type="email" class="form-control form-control-sm" id="email_pemohon" name="email_pemohon" value="<?= esc($email_pemohon) ?>" readonly>

                    </div>
                    <div class="form-group col-md-4 col-12">
                        <label for="">Nomor HP (WA) </label>
                        <input type="text" class="form-control form-control-sm" id="hp_pemohon" name="hp_pemohon" value="<?= esc($hp_pemohon) ?>" readonly>

                    </div>
                    <div class="form-group col-12">
                        <label for="">Alamat </label>
                        <textarea type="text" class="form-control form-control-sm bg-light" id="alamat_pemohon" name="alamat_pemohon" readonly><?= esc($alamat_pemohon) ?></textarea>

                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label for="">Pekerjaan </label>
                        <input type="text" class="form-control form-control-sm" id="pekerjaan" name="pekerjaan" value="<?= esc($pekerjaan) ?>" readonly>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label for="">Identitas Diri </label>

                        <label class="form-control  form-control-sm"><a class="text-success" title="klik untuk buka file" target='_BLANK' href="<?= base_url('public/file/dokumen/'  . $foto_ktp) ?>"><?= $foto_ktp ?></a></label>
                    </div>

                    <div class="form-group col-12">
                        <label for="">Informasi yang dibutuhkan </label>
                        <textarea type="text" class="form-control form-control-sm bg-light" id="info_ygdibutuhkan" name="info_ygdibutuhkan" readonly><?= esc($info_ygdibutuhkan) ?></textarea>
                        <div class="invalid-feedback errorinfo_ygdibutuhkan"></div>
                    </div>
                    <div class="form-group col-12">
                        <label for="">Tujuan Penggunaan Informasi </label>
                        <textarea type="text" class="form-control form-control-sm bg-light" id="tujuan_info" name="tujuan_info" readonly><?= esc($tujuan_info) ?></textarea>

                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label for="">Cara Memperoleh Informasi </label>
                        <input type="text" class="form-control form-control-sm" id="caraperolehinfo" name="caraperolehinfo" value="<?= esc($caraperolehinfo) ?>" readonly>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label for="">Cara Mendapatkan Informasi </label>
                        <input type="text" class="form-control form-control-sm" id="caradapatinfo" name="caradapatinfo" value="<?= esc($caradapatinfo) ?>" readonly>
                    </div>

                    <div class="form-group col-md-6 col-12">
                        <label> Status Ajuan </label>
                        <div class="form-control form-control-sm">
                            <input type="radio" name="sts_info" id="sts_info1" value="0" <?= $sts_info == '0' ? 'checked' : '' ?>> <label for="sts_info1" class="pointer"> Ajuan Baru &nbsp</label>
                            <input type="radio" name="sts_info" id="sts_info2" value="1" <?= $sts_info == '1' ? 'checked' : '' ?>> <label for="sts_info2" class="pointer"> Terima ajuan &nbsp</label>
                            <input type="radio" name="sts_info" id="sts_info3" value="2" <?= $sts_info == '2' ? 'checked' : '' ?>> <label for="sts_info3" class="pointer"> Tolak ajuan &nbsp</label>
                        </div>
                    </div>
                    <div class="form-group col-md-6 col-12">
                        <label for="">Tanggal Ajuan </label>
                        <input type="text" class="form-control form-control-sm" id="caraperolehinfo" name="caraperolehinfo" value="<?= $tglk . ' ' . $blnck . ' ' . $thnk . ' ' . $jamk ?>" readonly>
                    </div>
                    <div class="form-group col-12">
                        <label> <i class="far fa-comments text-primary"></i>
                            Respon Permintaan Informasi
                        </label>
                        <textarea type="text" class="form-control form-control-sm" id="respon_balas" name="respon_balas"><?= $respon_balas ?></textarea>
                        <div class="invalid-feedback errorrespon_balas"></div>
                        <code><a class="text-secondary"> Format default ke email user:</a><a class="text-danger"> Terima Kasih telah menghubungi kami..! </a><a class="text-secondary">Selanjutnya silahkan isi balasan diatas.</a></code>
                    </div>

                </div>
                <div class="modal-footer p-0">
                    <?php if ($akses == 1) { ?>
                        <div class="float-right">
                            <button class="btn btn-primary btnupload"><i class="fas fa-paper-plane"></i> Kirim Balasan</button>
                        </div>
                    <?php } ?>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Tutup</button>

                </div>
                <?php echo form_close() ?>

            </div>
        </div>
    </div>


    <script>
        $(document).ready(function() {
            $('textarea#respon_balas').summernote({
                height: 150,
                minHeight: null,
                maxHeight: null,
                focus: true
            });


            $('.btnupload').click(function(e) {
                e.preventDefault();
                let form = $('.formbalasrespon')[0];
                let data = new FormData(form);
                toastr.options = {
                        "closeButton": true,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    },
                    $.ajax({
                        type: "post",
                        url: '<?= site_url('permohonaninfo/updatestatus') ?>',
                        data: data,
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json",
                        beforeSend: function() {
                            $('.btnupload').attr('disable', 'disable');
                            $('.btnupload').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                        },
                        complete: function() {
                            $('.btnupload').removeAttr('disable', 'disable');
                            $('.btnupload').html('<i class="fas fa-paper-plane"></i> Kirim Balasan');
                        },
                        success: function(response) {

                            if (response.noakses) {
                                toastr["error"](response.noakses)
                                Swal.fire({
                                    title: "Gagal Akses!",
                                    html: `Anda tidak berhak mengakses <strong>Modul ini</strong> `,
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 3100
                                }).then(function() {
                                    window.location = '../';
                                })
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            }

                            if (response.blmakses) {

                                Swal.fire({
                                    title: "Maaf gagal load Modul!",
                                    html: `Modul ini belum atau tidak didaftarkan `,
                                    icon: "error",
                                    showConfirmButton: false,
                                    timer: 3100
                                }).then(function() {
                                    window.location = '../admin';
                                })
                            }

                            if (response.error) {

                                if (response.error.respon_balas) {
                                    $('#respon_balas').addClass('is-invalid');
                                    $('.errorrespon_balas').html(response.error.respon_balas);
                                } else {
                                    $('#respon_balas').removeClass('is-invalid');
                                    $('.errorrespon_balas').html('');
                                }
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            } else {

                                toastr["success"](response.sukses)

                                $('#modaledit').modal('hide');
                                listpermohonaninfo();
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownerror) {
                            toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), );
                            $('#modaledit').modal('hide');
                        }
                    });
            });
        });
    </script>