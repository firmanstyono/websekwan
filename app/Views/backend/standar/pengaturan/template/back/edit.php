<link href="<?= base_url() ?>/public/template/backend/standar/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?= base_url() ?>/public/template/backend/standar/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="<?= base_url() ?>/public/template/backend/standar/assets/pages/form-advanced.js"></script>

<div class="modal fade" id="modaledit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="card-header mt-0">
                <h6 class="modal-title m-0">Edit Data
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </h6>
            </div>

            <?= form_open_multipart('', ['class' => 'formedit']) ?>

            <div class='card-body pt-1'>
                <input type="hidden" class="form-control" id="template_id" value="<?= $template_id ?>" name="template_id" readonly>
                <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home1" role="tab">Setting Umum Tema</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#gambarkover" role="tab">Gambar Cover</a>
                    </li>
                </ul>
                <div class="tab-content pt-0">

                    <div class="tab-pane active " id="home1" role="tabpanel">
                        <p class="mt-3 mb-0">
                        <div class="row">
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-text-shadow"></i>
                                    Nama Template
                                </label>
                                <input type="text" class="form-control" id="nama" value="<?= $nama ?>" name="nama">
                                <div class="invalid-feedback errornama"></div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="far fa-folder"></i>
                                    Nama Folder
                                </label>
                                <?php if ($folder == 'standar') { ?>
                                    <input type="text" class="form-control" id="folder" value="<?= $folder ?>" name="folder" readonly>
                                <?php  } else { ?>
                                    <input type="text" class="form-control" id="folder" value="<?= $folder ?>" name="folder">
                                <?php } ?>

                                <div class="invalid-feedback errorfolder"></div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label><i class="mdi mdi-format-color-fill"></i>Warna Topbar</label>
                                <input type="text" class="colorpicker-default form-control form-control-sm" id="warna_topbar" name="warna_topbar" value="#<?= $warna_topbar ?>">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label> <i class="mdi mdi-page-layout-sidebar-left"></i> Mode Sidebar</label>
                                <div class="form-control form-control-sm">
                                    <input type="radio" name="sidebar_mode" id="sidebar_mode2" value="0" <?= $sidebar_mode == '0' ? 'checked' : '' ?>> <label for="sidebar_mode2" class="pointer"> Light &nbsp;</label>
                                    <input type="radio" name="sidebar_mode" id="sidebar_mode1" value="1" <?= $sidebar_mode == '1' ? 'checked' : '' ?>> <label for="sidebar_mode1" class="pointer"> Dark </label>
                                </div>
                            </div>

                            <div class="form-group col-md-6 col-12">
                                <label> <i class="far fa-user"></i>
                                    Sumber Pembuat
                                </label>
                                <input type="text" class="form-control" id="pembuat" value="<?= $pembuat ?>" name="pembuat">
                                <div class="invalid-feedback errorpembuat"></div>
                            </div>


                            <div class="form-group col-md-6 col-12">
                                <label> <i class="ion-ios7-settings-strong"></i>
                                    Keterangan
                                </label>
                                <input type="text" class="form-control" id="ket" name="ket" value="<?= $ket ?>">
                                <div class="invalid-feedback errorket"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="gambarkover" role="tabpanel">
                        <p class="mt-3 mb-0">
                        <div class="form-group">
                            <label> <i class="mdi mdi-file-image"></i>
                                Ganti Gambar
                            </label>
                            <input type="file" class="form-control" id="img" name="img">
                            <div class="invalid-feedback errorimg"></div>

                        </div>
                        <?php if ($img != '') { ?>
                            <div class="form-group">
                                <label> <i class="mdi mdi-image"></i>
                                    Gambar
                                </label>
                                <img id='img_load' width='100%' src='<?= base_url('public/img/template/' . $img) ?>'>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btnupdate"><i class="mdi mdi-content-save-all"></i> Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ion-close"></i> Batal</button>
                </div>

                <?= form_close() ?>
            </div>
        </div>
    </div>

    <script>
        function bacaGambar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#img_load').attr('src', e.target.result)
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $('#img').change(function() {
            bacaGambar(this);
        });
        $(document).ready(function() {

            $('.btnupdate').click(function(e) {
                e.preventDefault();
                let form = $('.formedit')[0];
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
                        url: '<?= site_url('template/updatetemplateback') ?>',
                        data: data,
                        enctype: 'multipart/form-data',
                        processData: false,
                        contentType: false,
                        cache: false,
                        dataType: "json",

                        beforeSend: function() {
                            $('.btnupdate').attr('disable', 'disable');
                            $('.btnupdate').html('<span class="spinner-border spinner-grow-sm" role="status" aria-hidden="true"></span> <i>Loading...</i>');
                        },
                        complete: function() {
                            $('.btnupdate').removeAttr('disable', 'disable');
                            $('.btnupdate').html('<i class="mdi mdi-content-save-all"></i> Simpan');
                        },
                        success: function(response) {
                            if (response.error) {

                                if (response.error.nama) {
                                    $('#nama').addClass('is-invalid');
                                    $('.errornama').html(response.error.nama);
                                } else {
                                    $('#nama').removeClass('is-invalid');
                                    $('.errornama').html('');
                                }

                                if (response.error.pembuat) {
                                    $('#pembuat').addClass('is-invalid');
                                    $('.errorpembuat').html(response.error.pembuat);
                                } else {
                                    $('#pembuat').removeClass('is-invalid');
                                    $('.errorpembuat').html('');
                                }

                                if (response.error.folder) {
                                    $('#folder').addClass('is-invalid');
                                    $('.errorfolder').html(response.error.folder);
                                } else {
                                    $('#folder').removeClass('is-invalid');
                                    $('.errorfolder').html('');
                                }
                                if (response.error.img) {
                                    $('#img').addClass('is-invalid');
                                    $('.errorimg').html(response.error.img);
                                } else {
                                    $('#img').removeClass('is-invalid');
                                    $('.errorimg').html('');
                                }
                                $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                            } else {

                                toastr["success"](response.sukses)
                                $('#modaledit').modal('hide');
                                // $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                                // listtemplateback();
                                window.location = '';
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownerror) {

                            toastr["error"]("Maaf gagal proses Kode Error:  " + (xhr.status + "\n"), )
                            $('#modaledit').modal('hide');
                            $('input[name=csrf_tokencmsdatagoe]').val(response.csrf_tokencmsdatagoe);
                        }
                    });
            });

        });
    </script>